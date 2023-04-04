<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Reservation;
use Carbon\Carbon;
use App\Services\EventService;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 予約人数
        $reservedPeople = DB::table('reservations')
            ->select('event_id', DB::raw('sum(number_of_people) as number_of_people'))
            ->groupBy('event_id');

        $today = Carbon::today();

        $events = DB::table('events')
            ->select(DB::raw('DATE(start_date) AS date'), 'name', 'location', DB::raw('SUM(max_people) AS max_people_sum'), DB::raw('SUM(IFNULL(number_of_people, 0)) AS reserved_people_sum'))
            ->leftJoinSub($reservedPeople, 'rp', function ($join) {
                $join->on('events.id', '=', 'rp.event_id');
            })
            ->whereDate('events.start_date', '>=', $today) // 最新の情報のみ取得
            ->groupBy('date', 'name', 'location')
            ->orderBy('start_date', 'desc')
            ->paginate(10);

        return view(
            'manager.events.index',
            compact('events')
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function detail($event, $date)
    {
        // 予約人数
        $reservedPeople = DB::table('reservations')
            ->select('event_id', DB::raw('sum(number_of_people) as number_of_people'))
            ->groupBy('event_id');

        $events = Event::where('location', $event)
            ->whereRaw("DATE(start_date) = '{$date}'") // 日付部分が一致するレコードを検索
            ->leftJoinSub( // 外部結合
                $reservedPeople,
                'reservedPeople',
                function ($join) {
                    $join->on('events.id', '=', 'reservedPeople.event_id');
                }
            )
            ->orderBy('start_date', 'asc')
            ->get();

        foreach ($events as $event) {
            $event->startDate = $event->startTime;
            $event->endDate = $event->endTime;
        }

        $users = collect();
        $events->each(function ($event) use ($users) {
            $users->push($event->users);
        });
        $users = $users->flatten();

        return view(
            'manager.events.detail',
            compact(
                'events',
                'users',
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manager.events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEventRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventRequest $request)
    {
        //重複チェック
        $check = EventService::checkEventDuplication($request['event_date'], $request['start_time'], $request['end_time']);

        if ($check) { // 重複していた場合
            session()->flash('status', 'この時間帯は既に他の予約が存在します。');
            return view('manager.events.create');
        }

        $startDate = EventService::joinDateAndTime($request['event_date'], $request['start_time']);
        $endDate = EventService::joinDateAndTime($request['event_date'], $request['end_time']);

        Event::create([
            'name' => $request['event_name'],
            'location' => $request['location'],
            'price' => $request['price'],
            'start_date' => $startDate,
            'end_date' => $endDate,
            'max_people' => $request['max_people'],
            'is_visible' => $request['is_visible'],
        ]);

        session()->flash('status', '登録完了');

        if ($request['registration'] === "1") {
            return back()->withInput();
        }
        return to_route('events.index'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        $event = Event::findOrFail($event->id);
        $users = $event->users;

        $reservations = []; // 連想配列を作成 
        foreach ($users as $user) {
            $reservedInfo = [
                'id' => $user->id,
                'name' => $user->name,
                'number_of_people' => $user->pivot->number_of_people,
                'email' => $user->pivot->email,
            ];
            array_push($reservations, $reservedInfo); // 連想配列に追加
        }

        $eventDate = $event->eventDate;
        $startTime = $event->startTime;
        $endTime = $event->endTime;

        return view(
            'manager.events.show',
            compact(
                'event',
                'users',
                'reservations',
                'eventDate',
                'startTime',
                'endTime'
            )
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        $event = Event::findOrFail($event->id);

        // 過去のイベントは編集不可にする（URLからアクセス不可にする）
        $today = Carbon::today()->format('Y年m月d日');
        if ($event->eventDate < $today) {
            return abort(404);
        }

        $eventDate = $event->editEventDate;
        $startTime = $event->startTime;
        $endTime = $event->endTime;

        return view(
            'manager.events.edit',
            compact('event', 'eventDate', 'startTime', 'endTime')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEventRequest  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEventRequest $request, Event $event)
    {
        //重複チェック
        $check = EventService::countEventDuplication(
            $request['event_date'],
            $request['start_time'],
            $request['end_time']
        );

        if ($check > 1) {
            session()->flash('status', 'この時間帯は既に他の予約が存在します。');
            $event = Event::findOrFail($event->id);
            $eventDate = $event->editEventDate;
            $startTime = $event->startTime;
            $endTime = $event->endTime;
            return view(
                'manager.events.edit',
                compact('event', 'eventDate', 'startTime', 'endTime')
            );
        }

        $startDate = EventService::joinDateAndTime($request['event_date'], $request['start_time']);
        $endDate = EventService::joinDateAndTime($request['event_date'], $request['end_time']);

        // 保存処理
        $event = Event::findOrFail($event->id);
        $event->name = $request['event_name'];
        $event->location = $request['location'];
        $event->price = $request['price'];
        $event->start_date = $startDate;
        $event->end_date = $endDate;
        $event->max_people = $request['max_people'];
        $event->is_visible = $request['is_visible'];
        $event->save();

        session()->flash('status', '更新完了');
        return to_route('events.index'); //名前付きルート
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function past()
    {
        // 予約人数
        $reservedPeople = DB::table('reservations')
            ->select('event_id', DB::raw('sum(number_of_people) as number_of_people'))
            ->groupBy('event_id');

        $today = Carbon::today();

        $events = DB::table('events')
            ->select(DB::raw('DATE(start_date) AS date'), 'name', 'location', DB::raw('SUM(max_people) AS max_people_sum'), DB::raw('SUM(IFNULL(number_of_people, 0)) AS reserved_people_sum'))
            ->leftJoinSub($reservedPeople, 'rp', function ($join) {
                $join->on('events.id', '=', 'rp.event_id');
            })
            ->whereDate('events.start_date', '<', $today)
            ->groupBy('date', 'name', 'location')
            ->orderBy('start_date', 'desc')
            ->paginate(10);

        return view('manager.events.past', compact('events'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $event = Event::findOrFail($event->id);
        $location = $event->location;
        $date = substr($event->start_date, 0, 10);

        $users = $event->users;

        $reservations = []; // 連想配列を作成 
        foreach ($users as $user) {
            $reservedInfo = [
                'id' => $user->id,
                'name' => $user->name,
                'number_of_people' => $user->pivot->number_of_people,
                'email' => $user->pivot->email,
            ];
            array_push($reservations, $reservedInfo); // 連想配列に追加
        }

        if ($reservations) { // 予約者の有無確認
            session()->flash('status', '予約している人が存在するため、キャンセルできません。');

            $eventDate = $event->eventDate;
            $startTime = $event->startTime;
            $endTime = $event->endTime;

            return view(
                'manager.events.show',
                compact(
                    'event',
                    'users',
                    'reservations',
                    'eventDate',
                    'startTime',
                    'endTime'
                )
            );
        }

        $event->delete();

        session()->flash('status', 'キャンセルしました。');

        return to_route('events.index'); //名前付きルート
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function cancel($event, $id)
    {
        $reservation = Reservation::where('user_id', '=', $id)
            ->where('event_id', '=', $event)
            ->latest()
            ->first();

        $reservation->delete();

        session()->flash('status', 'キャンセルしました。');
        return back();
    }
}
