<?php

namespace App\Http\Controllers\Caregiver;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Patient;
use App\Models\PatientSchedule;
use App\Models\Shift;




class CaregiverHomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function showCaregiverHome($id)
    {
        $caregiverEmpId = Auth::user()->employee->emp_id;
    
        $caregroup = Shift::where('emp_ID', $caregiverEmpId)->value('caregroup');
    
        $patients = Patient::where('caregroup', $caregroup)->get();
    
        // $patientSchedules = PatientSchedule::whereIn('patient_id', $patients->pluck('patient_id'))->get();
    
        return view('caregiverHome', compact('patients'));
    }
    
    public function showSchedule($id)
    {
        $caregiverId = auth()->user()->employee->emp_id;
        $patientId = $id;
        $shiftDate = now()->format('Y-m-d');
        $caregroupEmp = Shift::where('emp_ID', $caregiverId)->value('caregroup');
    
        $schedule = PatientSchedule::where('caregiver_id', $caregiverId)
            ->where('patient_id', $patientId)
            ->where('particular_date', $shiftDate)
            // ->where('caregroup', $caregroup)
            ->first();
    
        if (!$schedule) {
            $schedule = PatientSchedule::create([
                'caregiver_id' => $caregiverId,
                'patient_id' => $patientId,
                'particular_date' => $shiftDate,
                // 'caregroup' => $caregroup, //no caregroup in the schedule..?
                'm_med' => false,
                'a_med' => false,
                'n_med' => false,
                'breakfast' => false,
                'lunch' => false,
                'dinner' => false,
            ]);
        }
        return view('schedule', compact('schedule'));
    }
    
    public function savePatientSchedule(Request $request)
    {
        $caregiverId = auth()->user()->employee->emp_id;
    
        $validated = $request->validate([
            'patient_id' => 'required|array',
            'm_med' => 'array',
            'a_med' => 'array',
            'n_med' => 'array',
            'breakfast' => 'array',
            'lunch' => 'array',
            'dinner' => 'array',
        ]);
    
        foreach ($validated['patient_id'] as $patientId) {
            PatientSchedule::updateOrCreate(
                [
                    'caregiver_id' => $caregiverId,
                    'patient_id' => $patientId,
                    'particular_date' => now()->format('Y-m-d'),
                ],
                [
                    'm_med' => in_array($patientId, $validated['m_med'] ?? []),
                    'a_med' => in_array($patientId, $validated['a_med'] ?? []),
                    'n_med' => in_array($patientId, $validated['n_med'] ?? []),
                    'breakfast' => in_array($patientId, $validated['breakfast'] ?? []),
                    'lunch' => in_array($patientId, $validated['lunch'] ?? []),
                    'dinner' => in_array($patientId, $validated['dinner'] ?? []),
                ]
            );
        }
    
        return redirect()->route('caregiverHome', ['id' => auth()->user()->id])->with('success', 'Schedule updated successfully!');
    }
    

    
}

