<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller; //////////////

class SupervisorHomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
        
    // public function index() //need to make index function later
    // {
    //     $listUsers = User::where('role', 'Patient')->get();

    //     return view('patientList', ['listingPatients' => $listingPatients]); 

    // }
    
    public function supervisorHome()
    {
        return view('supervisorHome'); // A Blade view for Supervisor Home
    }
}

