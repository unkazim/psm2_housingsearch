<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminViewController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }
}