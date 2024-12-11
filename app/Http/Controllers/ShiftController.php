<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Shift;
use App\Models\Employee;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    public function index(Request $request)
    {
        $query = Shift::with('employee.user'); // Eager load employee and user
    
        if ($request->has('date')) {
            $date = $request->input('date');
            $query->whereDate('shift_start', $date);
        }
    
        $shifts = $query->orderBy('shift_start', 'asc')->get();
    
        return view('shifts.index', compact('shifts'));
    }
    public function getAvailableEmployees(Request $request)
    {
        $date = $request->input('date');
    
        $assignedCaregivers = Shift::where('shift_date', $date)
            ->whereHas('employee.user', function ($query) {
                $query->where('role', 'Caregiver');
            })
            ->pluck('emp_id')
            ->toArray();
    
        $employees = Employee::with('user')
            ->whereNotIn('emp_id', $assignedCaregivers)
            ->get();
    
        return response()->json(['employees' => $employees]);
    }
    
    public function create(Request $request)
    {
        $date = $request->input('date', now()->toDateString());

        $assignedCaregivers = Shift::where('shift_date', $date)
            ->whereHas('employee.user', function ($query) {
                $query->where('role', 'Caregiver');
            })
            ->pluck('emp_id')
            ->toArray();

        $assignedCaregroups = Shift::where('shift_date', $date)
            ->pluck('caregroup')
            ->toArray();

        $employees = Employee::with('user')
            ->whereNotIn('emp_id', $assignedCaregivers)
            ->get();

        $allCaregroups = ['A', 'B', 'C', 'D'];

        return view('shifts.create', compact('employees', 'allCaregroups', 'date'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'shift_date' => 'required|date',
            'shift_start' => 'required|date',
            'shift_end' => 'required|date|after:shift_start',
            'caregroup' => 'nullable|string',
            'emp_id' => [
                'required',
                'exists:employees,emp_id',
                function ($attribute, $value, $fail) use ($request) {
                    $employee = Employee::with('user')->where('emp_id', $value)->first();
                    if ($employee) {
                        // Check if the employee is already scheduled for a different care group on the same day
                        $exists = Shift::where('shift_date', $request->shift_date)
                            ->where('emp_id', $value)
                            ->exists();
                        if ($exists) {
                            $fail('This employee is already scheduled for a shift on this date.');
                        }
                    }
                },
            ],
            'caregroup' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) use ($request) {
                    // Check if the care group is already assigned on the same day
                    $exists = Shift::where('shift_date', $request->shift_date)
                        ->where('caregroup', $value)
                        ->exists();
                    if ($exists) {
                        $fail('This care group is already assigned on this date.');
                    }
                },
            ],
        ]);

        Shift::create($request->all());

        return redirect()->route('shifts.index')->with('success', 'Shift created successfully.');
    }
}
// namespace App\Http\Controllers;

// use App\Models\User;
// use App\Models\Shift;
// use App\Models\Employee;
// use Illuminate\Http\Request;

// class ShiftController extends Controller
// {
//     public function index(Request $request){
//         $query = Shift::with('employee.user');
    
//         if ($request->has('date')) {
//             $date = $request->input('date');
//             $query->whereDate('shift_start', $date);
//         }
    
//         $shifts = $query->orderBy('shift_start', 'asc')->get();
    
//         return view('shifts.index', compact('shifts'));
//     }

//     public function create(){
//         $assignedCaregivers = Shift::where('shift_date', now()->toDateString())
//             ->whereHas('employee.user', function ($query) {
//                 $query->where('role', 'Caregiver');
//             })
//             ->pluck('emp_id')
//             ->toArray();

//         $assignedCaregroups = Shift::where('shift_date', now()->toDateString())
//             ->pluck('caregroup')
//             ->toArray();

//         $employees = Employee::with('user')
//             ->whereNotIn('emp_id', $assignedCaregivers)
//             ->get();

//         $allCaregroups = ['A', 'B', 'C', 'D'];
//         $availableCaregroups = array_diff($allCaregroups, $assignedCaregroups);

//         return view('shifts.create', compact('employees', 'availableCaregroups'));
//     }

//     public function store(Request $request){ //for a new shift
//         $request->validate([
//             'shift_date' => 'required|date',
//             'shift_start' => 'required|date',
//             'shift_end' => 'required|date|after:shift_start',
//             'caregroup' => 'nullable|string',
//             'emp_id' => [
//                 'required',
//                 'exists:employees,emp_id',
//                 function ($attribute, $value, $fail) use ($request) {
//                     $employee = Employee::with('user')->where('emp_id', $value)->first();
//                     if ($employee) {
//                         // checking if the employee is already scheduled for a different care group on the same day
//                         $exists = Shift::where('shift_date', $request->shift_date)
//                             ->where('emp_id', $value)
//                             ->where('caregroup', '<>', $request->caregroup)
//                             ->exists();
//                         if ($exists) {
//                             $fail('This employee is already scheduled for a different care group on this date.');
//                         }
    
//                         // Checking if the care group is already assigned on the same day
//                         $caregroupExists = Shift::where('shift_date', $request->shift_date)
//                             ->where('caregroup', $request->caregroup)
//                             ->exists();
//                         if ($caregroupExists) {
//                             $fail('This care group is already assigned to another caregiver on this date.');
//                         }
//                     }
//                 },
//             ],
//         ]);
    
//         Shift::create($request->all());
    
//         return redirect()->route('shifts.index')->with('success', 'Shift created successfully.');
//     }

//     public function edit($id){ //accessing the information to edit/then update
//         $shift = Shift::findOrFail($id);

//         $assignedCaregivers = Shift::where('shift_date', $shift->shift_date)
//             ->where('id', '<>', $id)
//             ->whereHas('employee.user', function ($query) {
//                 $query->where('role', 'Caregiver');
//             })
//             ->pluck('emp_id')
//             ->toArray();

//         $assignedCaregroups = Shift::where('shift_date', $shift->shift_date)
//             ->where('id', '<>', $id)
//             ->pluck('caregroup')
//             ->toArray();

//         $employees = Employee::with('user')
//             ->whereNotIn('emp_id', $assignedCaregivers)
//             ->get();

//         $allCaregroups = ['A', 'B', 'C', 'D'];
//         $availableCaregroups = array_diff($allCaregroups, $assignedCaregroups);

//         return view('shifts.edit', compact('shift', 'employees', 'availableCaregroups'));
//     }
    
//     public function update(Request $request, $id){ //for checking an edited shift
//         $request->validate([
//             'shift_date' => 'required|date',
//             'shift_start' => 'required|date',
//             'shift_end' => 'required|date|after:shift_start',
//             'caregroup' => 'nullable|string',
//             'emp_id' => [
//                 'required',
//                 'exists:employees,emp_id',
//                 function ($attribute, $value, $fail) use ($request, $id) {
//                     $employee = Employee::with('user')->where('emp_id', $value)->first();
//                     if ($employee) {
//                         // this will check if the employee is already scheduled for a different care group on this same date
//                         $exists = Shift::where('shift_date', $request->shift_date)
//                             ->where('emp_id', $value)
//                             ->where('caregroup', '<>', $request->caregroup)
//                             ->where('id', '<>', $id) // will exclude the current shift
//                             ->exists();
//                         if ($exists) {
//                             $fail('This employee is already scheduled for a different care group on this date.');
//                         }
    
//                         // checking if the care group is already assigned on the same day
//                         $caregroupExists = Shift::where('shift_date', $request->shift_date)
//                             ->where('caregroup', $request->caregroup)
//                             ->where('id', '<>', $id)
//                             ->exists();
//                         if ($caregroupExists) {
//                             $fail('This care group is already assigned to another caregiver on this date.');
//                         }
//                     }
//                 },
//             ],
//         ]);
    
//         $shift = Shift::findOrFail($id);
//         $shift->update($request->all());
    
//         $employee = Employee::with('user')->where('emp_id', $request->emp_id)->first();
//         if ($employee->user->role !== 'Caregiver') {
//             $shift->caregroup = null;
//             $shift->save();
//         }
    
//         return redirect()->route('shifts.index')->with('success', 'Shift updated successfully.');
//     }
// }

