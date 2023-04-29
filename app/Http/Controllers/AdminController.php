<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $teachers = User::where('role', '=', 5)->get();
        return view('admin.index', compact('teachers'));
    }
}
