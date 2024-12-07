<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

use App\Models\Role;


class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }


    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $user = auth()->user();
        if ($user->status === 'N/A') {
            // should continue on past the else if, if true...-serena
        }
        else if ($user->status !== "approved") {
            auth()->logout();
            return back()->withErrors([
                'email' => __('Your account is not yet approved. Please contact support.'),
            ]);
        }

        // prevents session fixation
        $request->session()->regenerate();

        // after authentication... will check the user's role and redirect acording to access level -serena
        $user = auth()->user();
        $role = Role::findOrFail($user->role);
        $level = $role->access_level;

        switch ($level) {
            case 1:
                return redirect()->route('adminHome');
            case 2:
                return redirect()->route('supervisorHome');
            case 3:
                return redirect()->route('doctorHome');
            case 4:
                return redirect()->route('caregiverHome', ['id' => $user->id]);
            case 5:
                return redirect()->route('patientHome', ['id' => $user->id]);
            case 6:
                return redirect()->route('familyHome', ['id' => $user->id]);
            // default:
            //     throw new \Exception('Invalid role level');
        }
    }


    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}