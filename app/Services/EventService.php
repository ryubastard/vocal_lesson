<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EventService
{
    // 日時の重複メソッド
    public static function checkEventDuplication(
        $eventDate,
        $startTime,
        $endTime
    ) {
        return DB::table('events')
            ->whereDate('start_date', $eventDate)
            ->whereTime('end_date', '>', $startTime)
            ->whereTime('start_date', '<', $endTime)
            ->exists();
    }

    // 重複チェック
    // 重複しているのが1件なら問題なく、1件より多ければエラー
    public static function countEventDuplication($eventDate, $startTime, $endTime)
    {
        return DB::table('events')
            ->whereDate('start_date', $eventDate)
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
