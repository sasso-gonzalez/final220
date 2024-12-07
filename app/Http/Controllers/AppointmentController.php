<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Patient;
use App\Models\Employee;
use App\Models\Shifts;
use App\Models\Role;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //dont need this?
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $doctors = User::whereHas('role', function ($query) {
            $query->where('role', 'Doctor');
        })->get();
    
        $patient = Patient::first();
    
        return view('appointment', compact('patient', 'doctors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'patient_id' => 'required|exists:patients,patient_id',
            'doctor_id' => 'required|exists:employees,emp_id', 
            'app_date' => 'required|date',
        ]);
    
        $patient = Patient::find($validatedData['patient_id']);
        if ($patient && (!$patient->admission_date || $validatedData['app_date'] < $patient->admission_date)) {
            return redirect()->back()->withErrors(['patient_id' => 'The appointment date cannot be before the admission date or if the admission date is not set.']);
        }
    
        // Creating the appointment here.
        $appointment = Appointment::create([
            'patient_id' => $validatedData['patient_id'],
            'doctor_id' => $validatedData['doctor_id'],
            'app_date' => $validatedData['app_date'],
            'app_notes' => $request->input('app_notes'),
        ]);
    
        return redirect()->route('appointment.create')->with('success', 'Appointment created successfully.');
    }

    public function getPatient($id)
    {
        $patient = Patient::with('user')->find($id);
        if ($patient) {
            return response()->json([
                'first_name' => $patient->user->first_name,
                'last_name' => $patient->user->last_name,
                'admission_date' => $patient->admission_date,
            ]);
        } else {
            return response()->json(null, 404);
        }
    }

    public function getScheduledDoctors($date)
    {
        $doctors = Employee::whereHas('user.role', function ($query) {
            $query->where('access_level', 3);
        })->whereHas('shifts', function ($query) use ($date) {
            $query->where('shift_date', $date);
        })->with('user')->get();
    
        return response()->json($doctors->map(function ($doctor) {
            return [
                'doctor_id' => $doctor->emp_id,
                'first_name' => $doctor->user->first_name,
                'last_name' => $doctor->user->last_name,
            ];
        }));
    }
}