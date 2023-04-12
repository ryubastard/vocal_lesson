<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Information;

class InformationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $information = Information::first();
        return view('information', compact('information'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Information  $lesson
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $information = Information::first();
        
    }
}
