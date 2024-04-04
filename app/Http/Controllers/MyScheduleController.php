<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyScheduleController extends Controller
{
    public function index(Request $request)
    {   


        return view('schedule.schedule');

    }

}
