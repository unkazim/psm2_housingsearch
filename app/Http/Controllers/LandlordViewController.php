<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandlordViewController extends Controller
{
    public function __construct()
    {
        // $this->middleware('role:landlord');
    }

    public function dashboard()
    {
        return view('landlord.dashboard');
    }
}