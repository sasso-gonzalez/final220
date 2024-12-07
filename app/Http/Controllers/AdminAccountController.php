<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee; //was missing this :| -serena
use App\Models\Patient; //was missing this :| -serena
use App\Models\Role;
use Illuminate\Http\Request;

class AdminAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:1,2')->only(['index', 'approve', 'deny', 'adminList']);
        $this->middleware('role:1')->only(['submitSalary']);
    }

    public function index()
    {
        $pendingUsers = User::where('status', 'pending')->get();

        return view('pending_accounts', ['pendingUsers' => $pendingUsers]); //changed from admin.pending_accounts to pending_accounts -serena
    }
//approving a user
    public function approve($id)
    {
        $user = User::findOrFail($id);
        $role = Role::where('role', $user->role)->first();
    
        if (!$role) {
            return redirect()->back()->withErrors(['error' => 'Role not found for this user.']);
        }
    
        $user->status = 'approved';
        $user->save();
    
        if ($role->access_level <= 4) { // used $role->access_level instead of $user->access_level
            $existingEmployee = Employee::where('user_id', $user->id)->first(); 
            if (!$existingEmployee) {
                Employee::create([
                    'user_id' => $user->id, 
                    'salary' => $this->calculateSalary($role->access_level),
                ]);
            }
        }
        else if ($role->access_level == 5) { // used $role->access_level instead of $user->access_level
            $existingPatient = Patient::where('user_id', $user->id)->first(); 
            if (!$existingPatient) {
                Patient::create([
                    'user_id' => $user->id, 
                    'family_code' => $user->family_code,
                    'caregroup' => null,
                    'amount_due'=> 0,
                    'payment_date' => null,
                    'admission_date' => null,
                ]);
            }
        }
    
        return redirect()->back()->with('success', 'User Approved.');
    }
    
    public function deny($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
    
        return redirect()->back()->with('success', 'User Denied...Deleting from database.');
    }
    
    public function calculateSalary($accessLevel) //changed to public
    {
        //salaries for different access levels
        $salaries = [
            1 => 150000,
            2 => 100000,
            3 => 75000,
            4 => 50000,
        ];
    
        return $salaries[$accessLevel] ?? 0;
    }

    public function adminHome()
    {
        return view('adminHome');
    }
    //handling filter and returning all patient info
    public function adminPatientList(Request $request)
    {
        $query = User::where('status', 'approved')->whereHas('role', function ($q) {
            $q->where('access_level', 5); //access level for patient
        });
    
        if ($request->filled('patient_id')) {
            $query->whereHas('patient', function ($q) use ($request) {
                $q->where('patient_id', $request->patient_id);
            });
        }
    
        if ($request->filled('name')) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->name . '%')
                  ->orWhere('last_name', 'like', '%' . $request->name . '%');
            });
        }
    
        if ($request->filled('age')) {
            $query->whereRaw('TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) = ?', [$request->age]);
        }
    
        if ($request->filled('emergency_contact')) {
            $query->where('emergency_contact', 'like', '%' . $request->emergency_contact . '%');
        }
    
        if ($request->filled('relation_emergency_contact')) {
            $query->where('relation_emergency_contact', 'like', '%' . $request->relation_emergency_contact . '%');
        }
    
        if ($request->filled('admission_date')) {
            $query->whereHas('patient', function ($q) use ($request) {
                $q->whereDate('admission_date', $request->admission_date);
            });
        }
    
        if ($request->filled('additionalInfo')) {
            $query->whereHas('patient', function ($q) use ($request) {
                $q->where('caregroup', 'like', '%' . $request->additionalInfo . '%');
            });
        }
    
        $adminPatientList = $query->get();
        $patientDetails = Patient::all();
    
        return view('patientList', [
            'adminPatientList' => $adminPatientList,
            'patientDetails' => $patientDetails,
        ]);
    }
    //handling filter and returning all employee info
    public function adminEmployeeList(Request $request)
    {
        $query = User::where('status', 'approved')->whereHas('role', function ($q) {
            $q->whereIn('access_level', [2, 3, 4]);
        });
    
        if ($request->filled('employee_id')) {
            $query->whereHas('employee', function ($q) use ($request) {
                $q->where('emp_id', $request->employee_id);
            });
        }
    
        if ($request->filled('name')) {
            $query->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->name . '%')
                  ->orWhere('last_name', 'like', '%' . $request->name . '%');
            });
        }
    
        if ($request->filled('role')) {
            $query->where('role', 'like', '%' . $request->role . '%');
        }
    
        if ($request->filled('salary')) {
            $query->whereHas('employee', function ($q) use ($request) {
                $q->where('salary', $request->salary); //decided exact salary was best here instead of using 'like'
            });
        }
    
        $adminEmployeeList = $query->get();
    
        return view('employeeList', [
            'adminEmployeeList' => $adminEmployeeList,
        ]);
    }
    
    public function submitSalary(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $authUser = auth()->user();
        $role = Role::where('role', $authUser->role)->first();
        
        if ($role->access_level !== 1) { //making sure only admin can change salary
            return redirect()->route('adminList')->withErrors(['error' => "Supervisors can't edit the salary."]);
        }
    
        $request->validate([
            'salary' => 'required|numeric|min:0',
        ]);
    
        $employee->salary = $request->input('salary');
        $employee->save();
    
        return redirect()->back()->with('success', 'Salary was submitted successfully!');
    }
}
