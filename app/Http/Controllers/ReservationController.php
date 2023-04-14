<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lesson;
use App\Models\Reservation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\NewUserAndLessonRequest;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        return view('dashboard');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        $lesson = Lesson::findOrFail($id);

        $reservedPeople = DB::table('reservations')
            ->select('lesson_id', DB::raw('sum(number_of_people) as number_of_people'))
            ->groupBy('lesson_id')
            ->having('lesson_id', $lesson->id) // havingはgroupByの後に検索
            ->first();

        if (!is_null($reservedPeople)) {
            $resevablePeople = $lesson->max_people - $reservedPeople->number_of_people;
        } else {
            $resevablePeople = $lesson->max_people;
        }

        // 予約済みイベントは再度予約できないようにする
        $isReserved = Reservation::where('user_id', '=', Auth::id())
            ->where('lesson_id', '=', $id)
            ->latest()
            ->first();

        return view(
            'lesson-detail',
            compact('lesson', 'resevablePeople', 'isReserved')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reserve(Request $request)
    {
        $lesson = Lesson::findOrFail($request->id);
        $reservedPeople = DB::table('reservations')
            ->select('lesson_id', DB::raw('sum(number_of_people) as number_of_people'))
            ->groupBy('lesson_id')
            ->having('lesson_id', $request->id)
            ->first();

        if (
            is_null($reservedPeople) ||
            $lesson->max_people >= $reservedPeople->number_of_people + $request->reserved_people
        ) {
            Reservation::create([
                'user_id' => Auth::id(),
                'lesson_id' => $request->id,
                'email' => Auth::user()->email,
                'number_of_people' => $request->reserved_people,
            ]);

            // 予約が完了した後に、予約人数がレッスンの最大人数を上回っている場合は、lessonsテーブルのis_visibleカラムを0に変更する
            if ($lesson->max_people <= ($reservedPeople->number_of_people ?? 0) + $request->reserved_people) {
                $lesson->is_visible = 0;
                $lesson->save();
            }

            session()->flash('status', '予約しました。');
            return to_route('dashboard');
        } else {
            session()->flash('status', 'この人数は予約できません。');
            return view('dashboard');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function confirmation(Request $request, $id)
    {
        $reserved_people = $request['reserved_people'];
        // コントローラーでセッションに値を保存する
        $request->session()->put('reserved_people', $reserved_people);

        return view('dashboard/confirmation', compact('id'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id)
    {
        $lesson = Lesson::findOrFail($id);
        // 次の画面でセッションから値を取得する
        $reserved_people = $request->session()->get('reserved_people');

        return view('dashboard/register', compact('lesson', 'reserved_people'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function verify(NewUserAndLessonRequest $request, $id)
    {
        $name = $request['name'];
        $kana = $request['kana'];
        $email = $request['email'];
        $password = Hash::make($request['password']);

        session([
            'name' => $name,
            'kana' => $kana,
            'email' => $email,
            'password' => $password,
        ]);

        $lesson = Lesson::findOrFail($id);
        $reserved_people = $request->session()->get('reserved_people');

        $reservedPeople = DB::table('reservations')
            ->select('lesson_id', DB::raw('sum(number_of_people) as number_of_people'))
            ->groupBy('lesson_id')
            ->having('lesson_id', $id)
            ->first();

        if (
            is_null($reservedPeople) ||
            $lesson->max_people >= $reservedPeople->number_of_people + $reserved_people
        ) {
            return view('dashboard/register-confirmation', compact('name', 'kana', 'email', 'password', 'lesson'));
        } else {
            session()->flash('status', 'この人数は予約できません。');
            return to_route('registration.create', ['id' => $id]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLessonRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $lesson = Lesson::findOrFail($id);
        $user_id = User::latest('id')->value('id') + 1;

        User::create([
            'id' => $user_id,
            'name' => $request->session()->get('name'),
            'kana' => $request->session()->get('kana'),
            'email' => $request->session()->get('email'),
            'password' => $request->session()->get('password'),
            'role' => 9,
        ]);

        Reservation::create([
            'user_id' => $user_id,
            'lesson_id' => $lesson->id,
            'email' => $request->session()->get('email'),
            'number_of_people' => $request->session()->get('reserved_people'),
        ]);

        // 予約人数がレッスンの定員を上回る場合に、is_visibleを0に更新する
        $reservedPeople = Reservation::select(DB::raw('sum(number_of_people) as number_of_people'))
            ->where('lesson_id', '=', $id)
            ->first();

        // 予約が完了した後に、予約人数がレッスンの最大人数を上回っている場合は、lessonsテーブルのis_visibleカラムを0に変更する
        if ($lesson->max_people <= ($reservedPeople->number_of_people ?? 0) + $request->reserved_people) {
            $lesson->is_visible = 0;
            $lesson->save();
        }

        session()->flush();
        return view('dashboard/register-completed');
    }
}
