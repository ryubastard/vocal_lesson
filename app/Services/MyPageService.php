<?php

namespace App\Services;

use Carbon\Carbon;

class MyPageService
{
    public static function reservedLesson($lessons, $string)
    {
        $reservedLessons = [];
        if ($string === 'fromToday') {
            foreach ($lessons->sortBy('start_date') as $lesson) {
                if (
                    $lesson->start_date >= Carbon::now()->format('Y-m-d 00:00:00')
                ) {
                    $lessonInfo = [
                        'id' => $lesson->id,
                        'name' => $lesson->name,
                        'location' => $lesson->location,
                        'start_date' => $lesson->start_date,
                        'end_date' => $lesson->end_date,
                        'number_of_people' => $lesson->pivot->number_of_people
                    ];

                    array_push($reservedLessons, $lessonInfo);
                }
            }
        }

        if ($string === 'past') {
            foreach ($lessons->sortByDesc('start_date') as $lesson) {
                if (
                    $lesson->start_date < Carbon::now()->format('Y-m-d 00:00:00')
                ) {
                    $lessonInfo = [
                        'id' => $lesson->id,
                        'name' => $lesson->name,
                        'location' => $lesson->location,
                        'start_date' => $lesson->start_date,
                        'end_date' => $lesson->end_date,
                        'number_of_people' => $lesson->pivot->number_of_people, 
                    ];
                    array_push($reservedLessons, $lessonInfo);
                }
            }
        }
        return $reservedLessons;
    }
}
