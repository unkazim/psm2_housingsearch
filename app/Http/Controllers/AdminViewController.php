<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminViewController extends Controller
{
    public function __construct()
    {
        // $this->middleware('role:admin');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }
}