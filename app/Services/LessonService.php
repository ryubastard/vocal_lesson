<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Carbon\Carbon;

class LessonService
{
    // 日時の重複メソッド
    public static function checkLessonDuplication(
        $lessonDate,
        $startTime,
        $endTime
    ) {
        return DB::table('lessons')
            ->whereDate('start_date', $lessonDate)
            ->whereTime('end_date', '>', $startTime)
            ->whereTime('start_date', '<', $endTime)
            ->exists();
    }

    // 重複チェック
    // 重複しているのが1件なら問題なく、1件より多ければエラー
    public static function countLessonDuplication($teacher_id, $lessonDate, $startTime, $endTime)
    {
        return DB::table('lessons')
            ->where('teacher_id', '<>', $teacher_id) // 重複をチェックするために追加した条件
            ->whereDate('start_date', $lessonDate)
            ->whereTime('end_date', '>', $startTime)
            ->whereTime('start_date', '<', $endTime)
            ->count();
    }

    // 日付と時間をくっつけるメソッド
    public static function joinDateAndTime($date, $time)
    {
        $join = $date . "" . $time;
        $dateTime = Carbon::createFromFormat(
            'Y-m-d H:i',
            $join
        );

        return $dateTime;
    }

    // 一週間分の情報を取得するメソッド
    public static function getWeekLessons($startDate, $endDate)
    {
        $id = Request::route()->parameter('id');
        $reservedPeople = DB::table('reservations')
            ->select('lesson_id', DB::raw('sum(number_of_people) as number_of_people'))
            ->groupBy('lesson_id');

        return DB::table('lessons')
            ->leftJoinSub($reservedPeople, 'reservedPeople', function ($join) {
                $join->on('lessons.id', '=', 'reservedPeople.lesson_id');
            })
            ->whereBetween('start_date', [$startDate, $endDate])
            ->where('is_visible', 1)
            ->where('teacher_id', $id)
            ->orderBy('start_date', 'asc')
            ->get();
    }
}
