<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardControllers extends Controller
{
    public function index(){
        return redirect()->route('dashboard');
    }

    public function dashboard(){
        return view('dashboard');
    }
}
