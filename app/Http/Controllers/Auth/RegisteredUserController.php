<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create()
    {
        $roles = Role::all();
        return view('auth.register', compact('roles'));
    }
    

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
            'role' => 'required|string',
            'phone' => 'nullable|string|max:15',
            'date_of_birth' => 'nullable|date',
            'family_code' => 'nullable|string|max:255',
            'emergency_contact' => 'nullable|string|max:255',
            'relation_emergency_contact' => 'nullable|string|max:255',// changed from relation_contact to relation_emergency_contact -serena
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'role' => $request->role,
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'family_code' => $request->family_code,
            'emergency_contact' => $request->emergency_contact,
            'relation_emergency_contact' => $request->relation_emergency_contact,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => 'pending',
        ]);

        event(new Registered($user));

        // RouteServiceProvider::setHomeRoute();
        // return redirect(RouteServiceProvider::$HOME);
        return redirect(RouteServiceProvider::HOME);//(need to changed redirect????? based off of status[cant login at all if they're denied/pending] / redirect to different pages for each role)
    }
}
