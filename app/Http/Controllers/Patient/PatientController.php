<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Patient;
use App\Models\Schedule;
use App\Models\Appointment;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PatientController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //
    public function patientHome()
    {
        $user = Auth::user();
        $patient = Patient::where('user_id', $user->id)
            ->with(['patientSchedules' => function($query) {
                $query->whereDate('particular_date', now()->toDateString());
            }, 'appointments' => function($query) {
                $query->orderBy('app_date', 'desc');
            }, 'appointments.employee.user', 'appointments.prescriptions'])
            ->first();
    
        $latestAppointment = $patient->appointments->first();
        $doctorUser = null;
        $attended = false;
    
        if ($latestAppointment) {
            $doctor = optional($latestAppointment->employee);
            $doctorUser = optional($doctor->user);
            $attended = $latestAppointment->prescriptions()->whereDate('created_at', Carbon::today())->exists();
        }
    
        return view('patientHome', [
            'user' => $user,
            'patient' => $patient,
            'doctorUser' => $doctorUser,
            'latestAppointment' => $latestAppointment,
            'attended' => $attended
        ]);
    }
    
    public function patientDetails(Request $request, $id)
    {
        $patient = Patient::with('user')->where('patient_id', $id)->firstOrFail();
        return view('additionalInfo', compact('patient'));
    }

    //additional info page
    public function updatingDetails(Request $request, $id)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,patient_id',
            'caregroup' => 'required|string',
            'admission_date' => 'required|date',
        ]);

        $patient = Patient::where('patient_id', $id)->first();

        if (!$patient) {
            return redirect()->back()->withErrors(['error' => 'Patient not found.']);
        }

        $patient->caregroup = $request->caregroup;
        $patient->admission_date = $request->admission_date;
        $patient->payment_date = $request->admission_date;
        $patient->save();
        return redirect()->route('patientList')->with('success', 'Patient details updated successfully.');
    }
}
