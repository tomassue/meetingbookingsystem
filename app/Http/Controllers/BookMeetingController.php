<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookMeetingController extends Controller
{
    public function index(Request $request)
    {   


        return view('book.book');

    }
}
