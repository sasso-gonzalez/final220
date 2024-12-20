<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Patient;
use App\Models\PatientSchedule;
use App\Models\User;
use App\Models\Employee;
use App\Models\Appointment;

class FamilyMemberController extends Controller
{
    public function index($id)
    {
        return view('familyHome');
    }

    public function show(Request $request)
    {
        $validated = $request->validate([
            'family_code' => 'required|integer',
            'patient_id' => 'required|integer',
            'date' => 'required|date',
        ]);

        $patientInfo = Patient::join('users', 'patients.user_id', '=', 'users.id')
            ->where('patients.family_code', $validated['family_code'])
            ->where('patients.patient_id', $validated['patient_id'])
            ->select('patients.*', 'users.first_name', 'users.last_name')
            ->first();

        if ($patientInfo) {
            $schedule = PatientSchedule::join('employees', 'patient_schedules.caregiver_id', '=', 'employees.emp_id')
                ->join('users', 'employees.user_id', '=', 'users.id')
                ->where('patient_schedules.patient_id', $patientInfo->patient_id)
                ->where('patient_schedules.particular_date', $validated['date'])
                ->select('patient_schedules.*', 'users.first_name as caregiver_first_name', 'users.last_name as caregiver_last_name')
                ->get();

            $latestAppointment = Appointment::where('patient_id', $patientInfo->patient_id)
                ->orderBy('app_date', 'desc')
                ->first();

            $doctorUser = $latestAppointment ? User::join('employees', 'users.id', '=', 'employees.user_id')
                ->where('employees.emp_id', $latestAppointment->doctor_id)
                ->select('users.first_name', 'users.last_name')
                ->first() : null;

            $prescriptionsGiven = $latestAppointment && $latestAppointment->prescriptions->isNotEmpty();
            $attended = $prescriptionsGiven;
        } else {
            $schedule = null;
            $latestAppointment = null;
            $doctorUser = null;
            $prescriptionsGiven = false;
            $attended = false;
        }

        $user = Auth::user();

        return view('familyHome', [
            'patientInfo' => $patientInfo,
            'schedule' => $schedule,
            'user' => $user,
            'date' => $validated['date'],
            'doctorUser' => $doctorUser,
            'latestAppointment' => $latestAppointment,
            'prescriptionsGiven' => $prescriptionsGiven,
            'attended' => $attended,
        ]);
    }
}