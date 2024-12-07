<?php

namespace App\Http\Controllers; 

use Illuminate\Http\Request;

class AdminHomeController extends Controller //changed from AdminController to AdminHomeController??? -serena
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function adminHome()
    {
        return view('adminHome'); // A Blade view for Admin 
    }
}

