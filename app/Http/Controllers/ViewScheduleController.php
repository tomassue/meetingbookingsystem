<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewScheduleController extends Controller
{
    public function index(Request $request)
    {   


        return view('viewschedule.viewschedule');

    }
}
