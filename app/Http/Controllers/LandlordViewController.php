<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandlordViewController extends Controller
{
    public function dashboard()
    {
        return view('landlord.dashboard');
    }
}