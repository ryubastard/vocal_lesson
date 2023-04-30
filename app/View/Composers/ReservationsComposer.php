<?php

namespace App\View\Composers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Lesson;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ReservationsComposer
{
    public function compose(View $view)
    {
        $user = User::findOrFail(Auth::id());
        $today = Carbon::today();
        $lessons = Lesson::where('teacher_id', Auth::id())
            ->where('end_date', '>=', $today)
            ->get();
        // 今日以降の日付の予約があるかチェックする
        $reservations = $user->lessons()->where('end_date', '>=', $today)->get();
        $view->with(['reservations' => $reservations, 'lessons' => $lessons]);
    }
}
