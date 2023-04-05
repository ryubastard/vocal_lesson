<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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
        return view(
            'lesson-detail',
            compact('lesson', 'resevablePeople')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reserve(Request $request)
    {
        $event = Lesson::findOrFail($request->id);
        $reservedPeople = DB::table('reservations')
            ->select('lesson_id', DB::raw('sum(number_of_people) as number_of_people'))
            ->groupBy('lesson_id')
            ->having('lesson_id', $request->id)
            ->first();

        if (
            is_null($reservedPeople) ||
            $event->max_people >= $reservedPeople->number_of_people + $request->reserved_people
        ) {
            Reservation::create([
                'user_id' => Auth::id(),
                'lesson_id' => $request->id,
                'email' => Auth::user()->email,
                'number_of_people' => $request->reserved_people,
            ]);

            session()->flash('status', '登録完了です');
            return to_route('dashboard');
        } else {
            session()->flash('status', 'この人数は予約できません。');
            return view('dashboard');
        }
    }
}
