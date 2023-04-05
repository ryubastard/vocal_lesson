<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
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
    public static function countLessonDuplication($lessonDate, $startTime, $endTime)
    {
        return DB::table('lessons')
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
}
