<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StudentViewController extends Controller
{
    public function dashboard()
    {
        return view('student.dashboard');
    }
}