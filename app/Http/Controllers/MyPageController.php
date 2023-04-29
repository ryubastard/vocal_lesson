<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Lesson;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use App\Services\MyPageService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\CancelMail;

class MyPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::findOrFail(Auth::id());
        $lessons = $user->lessons()->withPivot('number_of_people')->get(); // イベント一覧を取得
        $fromTodayLessons = MyPageService::reservedLesson($lessons, 'fromToday'); // 今日以降
        $pastLessons = MyPageService::reservedLesson($lessons, 'past'); // 過去

        return view('mypage/index', compact('fromTodayLessons', 'pastLessons'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lesson = Lesson::leftJoin('users', 'lessons.teacher_id', '=', 'users.id')
            ->select('lessons.*', 'users.name AS teacher_name')
            ->findOrFail($id);
        $reservation = Reservation::where('user_id', '=', Auth::id())
            ->where('lesson_id', '=', $id)
            ->latest() // 最新の情報
            ->first();

        // dd($reservation);
        return view('mypage/show', compact('lesson', 'reservation'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cancel($id)
    {
        try {
            DB::beginTransaction();

            $reservation = Reservation::where('user_id', '=', Auth::id())
                ->where('lesson_id', '=', $id)
                ->latest()
                ->first();

            $reservation->delete();

            // 予約がキャンセルされたレッスンの空き人数がレッスンの最大人数未満である場合、lessonsテーブルのis_visibleカラムを1に変更する
            $reservedPeople = Reservation::where('lesson_id', '=', $id)->sum('number_of_people');
            $lesson = Lesson::findOrFail($id);
            if ($lesson->max_people > $reservedPeople) {
                $lesson->is_visible = 1;
                $lesson->save();
            }

            $user = Auth::user()->name;
            $lessonDate = $lesson->lessonDate;
            $startTime = $lesson->startTime;
            $endTime = $lesson->endTime;

            Mail::to(Auth::user()->email)
                ->queue(new CancelMail($user, $lesson, $lessonDate, $startTime, $endTime));

            session()->flash('status', 'キャンセルしました。');
            DB::commit();

            return to_route('dashboard');
        } catch (\Exception $e) {
            DB::rollback();
            session()->flash('status', 'キャンセルできませんでした。');
            return to_route('dashboard');
        }
    }
}
