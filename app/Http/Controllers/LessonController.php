<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\User;
use App\Models\Reservation;
use Carbon\Carbon;
use App\Services\lessonService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\OwnerCancelMail;

class LessonController extends Controller
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
            ->select('lesson_id', DB::raw('sum(number_of_people) as number_of_people'))
            ->groupBy('lesson_id');

        $today = Carbon::today();

        $lessons = DB::table('lessons')
            ->select(DB::raw('DATE(start_date) AS date'), 'name', 'location', DB::raw('SUM(max_people) AS max_people_sum'), DB::raw('SUM(IFNULL(number_of_people, 0)) AS reserved_people_sum'))
            ->leftJoinSub($reservedPeople, 'rp', function ($join) {
                $join->on('lessons.id', '=', 'rp.lesson_id');
            })
            ->whereDate('lessons.start_date', '>=', $today) // 最新の情報のみ取得
            ->where('teacher_id', Auth::id())
            ->groupBy('date', 'name', 'location')
            ->orderBy('start_date', 'desc')
            ->paginate(10);

        return view(
            'manager.lessons.index',
            compact('lessons')
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lesson $lesson
     * @return \Illuminate\Http\Response
     */
    public function overview($lesson, $date)
    {
        // 予約人数
        $reservedPeople = DB::table('reservations')
            ->select('lesson_id', DB::raw('sum(number_of_people) as number_of_people'))
            ->groupBy('lesson_id');

        $lessons = Lesson::where('location', $lesson)
            ->whereRaw("DATE(start_date) = '{$date}'") // 日付部分が一致するレコードを検索
            ->leftJoinSub( // 外部結合
                $reservedPeople,
                'reservedPeople',
                function ($join) {
                    $join->on('lessons.id', '=', 'reservedPeople.lesson_id');
                }
            )
            ->orderBy('start_date', 'asc')
            ->get();

        foreach ($lessons as $lesson) {
            $lesson->startDate = $lesson->startTime;
            $lesson->endDate = $lesson->endTime;
        }

        $users = collect();
        $lessons->each(function ($lesson) use ($users) {
            $users->push($lesson->users);
        });
        $users = $users->flatten();

        return view(
            'manager.lessons.overview',
            compact(
                'lessons',
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
        return view('manager.lessons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLessonRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLessonRequest $request)
    {
        //重複チェック
        $check = lessonService::checkLessonDuplication($request['lesson_date'], $request['start_time'], $request['end_time']);

        if ($check) { // 重複していた場合
            session()->flash('status', 'この時間帯は既に他の予約が存在します。');
            return view('manager.lessons.create');
        }

        $startDate = lessonService::joinDateAndTime($request['lesson_date'], $request['start_time']);
        $endDate = lessonService::joinDateAndTime($request['lesson_date'], $request['end_time']);

        lesson::create([
            'name' => $request['lesson_name'],
            'location' => $request['location'],
            'price' => $request['price'],
            'start_date' => $startDate,
            'end_date' => $endDate,
            'max_people' => $request['max_people'],
            'is_visible' => $request['is_visible'],
            'teacher_id' => Auth::id(),
        ]);

        session()->flash('status', '登録完了');

        if ($request['registration'] === "1") {
            return back()->withInput();
        }
        return to_route('lessons.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function show(lesson $lesson)
    {
        $lesson = lesson::findOrFail($lesson->id);
        $users = $lesson->users;

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

        $lessonDate = $lesson->lessonDate;
        $startTime = $lesson->startTime;
        $endTime = $lesson->endTime;

        return view(
            'manager.lessons.show',
            compact(
                'lesson',
                'users',
                'reservations',
                'lessonDate',
                'startTime',
                'endTime'
            )
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function edit(lesson $lesson)
    {
        $lesson = lesson::findOrFail($lesson->id);

        // 過去のイベントは編集不可にする（URLからアクセス不可にする）
        $today = Carbon::today()->format('Y年m月d日');
        if ($lesson->lessonDate < $today) {
            return abort(404);
        }

        $lessonDate = $lesson->editlessonDate;
        $startTime = $lesson->startTime;
        $endTime = $lesson->endTime;

        return view(
            'manager.lessons.edit',
            compact('lesson', 'lessonDate', 'startTime', 'endTime')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatelessonRequest  $request
     * @param  \App\Models\lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatelessonRequest $request, lesson $lesson)
    {
        try {
            DB::beginTransaction();

            //重複チェック
            $check = lessonService::countlessonDuplication(
                $request['lesson_date'],
                $request['start_time'],
                $request['end_time']
            );

            if ($check > 1) {
                session()->flash('status', 'この時間帯は既に他の予約が存在します。');
                $lesson = lesson::findOrFail($lesson->id);
                $lessonDate = $lesson->editlessonDate;
                $startTime = $lesson->startTime;
                $endTime = $lesson->endTime;
                return view(
                    'manager.lessons.edit',
                    compact('lesson', 'lessonDate', 'startTime', 'endTime')
                );
            }

            $startDate = lessonService::joinDateAndTime($request['lesson_date'], $request['start_time']);
            $endDate = lessonService::joinDateAndTime($request['lesson_date'], $request['end_time']);

            // 保存処理
            $lesson = lesson::findOrFail($lesson->id);
            $lesson->name = $request['lesson_name'];
            $lesson->location = $request['location'];
            $lesson->price = $request['price'];
            $lesson->start_date = $startDate;
            $lesson->end_date = $endDate;
            $lesson->max_people = $request['max_people'];
            $lesson->is_visible = $request['is_visible'];
            $lesson->teacher_id = Auth::id();
            $lesson->save();

            DB::commit();

            session()->flash('status', '更新完了');
            return to_route('lessons.index'); //名前付きルート
        } catch (\Exception $e) {
            DB::rollback();

            session()->flash('status', '更新に失敗しました。');
            return back()->withInput();
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function past()
    {
        // 予約人数
        $reservedPeople = DB::table('reservations')
            ->select('lesson_id', DB::raw('sum(number_of_people) as number_of_people'))
            ->groupBy('lesson_id');

        $today = Carbon::today();

        $lessons = DB::table('lessons')
            ->select(DB::raw('DATE(start_date) AS date'), 'name', 'location', DB::raw('SUM(max_people) AS max_people_sum'), DB::raw('SUM(IFNULL(number_of_people, 0)) AS reserved_people_sum'))
            ->leftJoinSub($reservedPeople, 'rp', function ($join) {
                $join->on('lessons.id', '=', 'rp.lesson_id');
            })
            ->whereDate('lessons.start_date', '<', $today)
            ->where('teacher_id', Auth::id())
            ->groupBy('date', 'name', 'location')
            ->orderBy('start_date', 'desc')
            ->paginate(10);

        return view('manager.lessons.past', compact('lessons'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function destroy(lesson $lesson)
    {
        DB::beginTransaction();

        try {
            $lesson = lesson::findOrFail($lesson->id);
            $location = $lesson->location;
            $date = substr($lesson->start_date, 0, 10);

            $users = $lesson->users;

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

                $lessonDate = $lesson->lessonDate;
                $startTime = $lesson->startTime;
                $endTime = $lesson->endTime;

                return view(
                    'manager.lessons.show',
                    compact(
                        'lesson',
                        'users',
                        'reservations',
                        'lessonDate',
                        'startTime',
                        'endTime'
                    )
                );
            }

            $lesson->delete();

            DB::commit();

            session()->flash('status', 'キャンセルしました。');

            return to_route('lessons.index'); //名前付きルート
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function cancel($lesson, $id)
    {
        DB::transaction(function () use ($lesson, $id) {
            $reservation = Reservation::where('user_id', '=', $id)
                ->where('lesson_id', '=', $lesson)
                ->latest()
                ->first();

            $reservation->delete();

            // 予約がキャンセルされたレッスンの空き人数がレッスンの最大人数未満である場合、lessonsテーブルのis_visibleカラムを1に変更する
            $reservedPeople = Reservation::where('lesson_id', '=', $lesson)->sum('number_of_people');
            $lesson = Lesson::findOrFail($lesson);
            if ($lesson->max_people > $reservedPeople) {
                $lesson->is_visible = 1;
                $lesson->save();
            }
        });

        $lesson = Lesson::findOrFail($lesson);
        $user = User::findOrFail($id);
        $lessonDate = $lesson->lessonDate;
        $startTime = $lesson->startTime;
        $endTime = $lesson->endTime;

        Mail::to($user->email)
            ->queue(new OwnerCancelMail($user, $lesson, $lessonDate, $startTime, $endTime));

        session()->flash('status', 'キャンセルしました。');
        return back();
    }
}
