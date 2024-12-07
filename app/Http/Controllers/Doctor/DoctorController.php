<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Prescription;

class DoctorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $doctorId = auth()->user()->employee->emp_id;
        $currentDate = now()->toDateString();
        $tillDate = $request->input('tillDate', now()->addMonth()->toDateString());
    
        $name = $request->input('name');
        $date = $request->input('date');
        $comment = $request->input('comment');
        $morningMed = $request->input('morningMed');
        $afternoonMed = $request->input('afternoonMed');
        $nightMed = $request->input('nightMed');
    
        $pastAppointmentsQuery = Appointment::where('doctor_id', $doctorId)
            ->where('app_date', '<', $currentDate)
            ->with(['patient.user', 'prescriptions']);
    
        $currentAppointmentsQuery = Appointment::where('doctor_id', $doctorId)
            ->whereBetween('app_date', [$currentDate, $tillDate])
            ->with(['patient.user', 'prescriptions']);
    
        if ($name) {
            $pastAppointmentsQuery->whereHas('patient.user', function ($query) use ($name) {
                $query->where('first_name', 'like', "%$name%")
                    ->orWhere('last_name', 'like', "%$name%");
            });
            $currentAppointmentsQuery->whereHas('patient.user', function ($query) use ($name) {
                $query->where('first_name', 'like', "%$name%")
                    ->orWhere('last_name', 'like', "%$name%");
            });
        }
    
        if ($date) {
            $pastAppointmentsQuery->where('app_date', $date);
            $currentAppointmentsQuery->where('app_date', $date);
        }
    
        if ($comment) {
            $pastAppointmentsQuery->whereHas('prescriptions', function ($query) use ($comment) {
                $query->where('doc_notes', 'like', "%$comment%");
            });
            $currentAppointmentsQuery->whereHas('prescriptions', function ($query) use ($comment) {
                $query->where('doc_notes', 'like', "%$comment%");
            });
        }
    
        if ($morningMed) {
            $pastAppointmentsQuery->whereHas('prescriptions', function ($query) use ($morningMed) {
                $query->where('m_med', 'like', "%$morningMed%");
            });
            $currentAppointmentsQuery->whereHas('prescriptions', function ($query) use ($morningMed) {
                $query->where('m_med', 'like', "%$morningMed%");
            });
        }
    
        if ($afternoonMed) {
            $pastAppointmentsQuery->whereHas('prescriptions', function ($query) use ($afternoonMed) {
                $query->where('a_med', 'like', "%$afternoonMed%");
            });
            $currentAppointmentsQuery->whereHas('prescriptions', function ($query) use ($afternoonMed) {
                $query->where('a_med', 'like', "%$afternoonMed%");
            });
        }
    
        if ($nightMed) {
            $pastAppointmentsQuery->whereHas('prescriptions', function ($query) use ($nightMed) {
                $query->where('n_med', 'like', "%$nightMed%");
            });
            $currentAppointmentsQuery->whereHas('prescriptions', function ($query) use ($nightMed) {
                $query->where('n_med', 'like', "%$nightMed%");
            });
        }
    
        $pastAppointments = $pastAppointmentsQuery->orderBy('app_date', 'asc')->get();
        $currentAppointments = $currentAppointmentsQuery->orderBy('app_date', 'asc')->get();
    
        return view('doctorHome', compact('pastAppointments', 'currentAppointments'));
    }
    
    
    public function showPatientDetails(Request $request, $id)
    {
        $appointment = Appointment::with(['patient.user'])->findOrFail($id);
        $doctorId = auth()->user()?->employee?->emp_id;
        if ($appointment->doctor_id !== $doctorId) {
            abort(403, 'Unauthorized access.');
        }
    
        $patientAppointments = Appointment::where('patient_id', $appointment->patient_id)
            ->with(['prescriptions' => function ($query) {
                $query->latest()->limit(1); // getting only the most recent prescription
            }])
            ->get();
    
        return view('patientofDoctor', compact('appointment', 'patientAppointments'));
    }

    public function savePrescription(Request $request, $appointmentId)
    {
        $request->validate([
            'doc_notes' => 'nullable|string',
            'm_med' => 'nullable|string',
            'a_med' => 'nullable|string',
            'n_med' => 'nullable|string',
        ]);

        $appointment = Appointment::findOrFail($appointmentId);

        if ($appointment->app_date !== now()->toDateString()) {
            return redirect()->back()->withErrors("Error: Either today isn't the appointment day, or you already saved a prescription for this appointment.");
        }

        $existingPrescription = $appointment->prescriptions()
        ->whereDate('created_at', now()->toDateString())
        ->first();

        if ($existingPrescription) {
            return redirect()->back()->withErrors("Error: Either today isn't the appointment day, or you already saved a prescription for this appointment.");
        }

        $appointment->prescriptions()->create([
            'appointment_id' => $appointment->appointment_id,
            'doctor_id' => auth()->user()?->employee?->emp_id,
            'doc_notes' => $request->input('doc_notes', ''),
            'm_med' => $request->input('m_med', ''),
            'a_med' => $request->input('a_med', ''),
            'n_med' => $request->input('n_med', ''),
        ]);

        return redirect()->back()->with('success', 'Prescription saved successfully.');
    }
}
