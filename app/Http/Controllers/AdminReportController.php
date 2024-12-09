<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\PatientSchedule;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->input('date');

        $query = PatientSchedule::where(function ($query) {
            $query->where('m_med', false)
                ->orWhere('a_med', false)
                ->orWhere('n_med', false)
                ->orWhere('breakfast', false)
                ->orWhere('lunch', false)
                ->orWhere('dinner', false);
        });

        if ($date) {
            $query->whereDate('particular_date', $date);
        }

        $missedActivities = $query->get();

        foreach ($missedActivities as $activity) {
            $latestAppointment = $activity->patient->appointments()->orderBy('app_date', 'desc')->first();
            $doctorUser = $latestAppointment ? $latestAppointment->employee->user : null;
            $prescriptionsGiven = $latestAppointment && $latestAppointment->prescriptions->isNotEmpty();
            $activity->doctorUser = $doctorUser;
            $activity->latestAppointment = $latestAppointment;
            $activity->prescriptionsGiven = $prescriptionsGiven;
            $activity->attended = $prescriptionsGiven;
        }

        return view('adminReport', compact('missedActivities', 'date'));
    }
}