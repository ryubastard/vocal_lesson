<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $informations = DB::table('information')
            ->leftJoin('users', 'information.user_id', '=', 'users.id')
            ->select('information.*', 'users.name')
            ->get();

        foreach ($informations as $information) {
            $information->information = mb_substr($information->information, 0, 100);
        }

        return view('teacher', compact('informations'));
    }
}
