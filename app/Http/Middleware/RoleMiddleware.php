<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Role;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$accessLevels
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$accessLevels)
    {
        if (!auth()->check()) {
            return redirect('/'); // Redirect to login or homepage
        }

        $user = auth()->user();
        $role = Role::where('role', $user->role)->first(); // Retrieve the Role model based on the role string

        if (!$role) {
            abort(403, 'Role not found.'); // Return error if role is not found
        }

        if (!in_array($role->access_level, $accessLevels)) {
            abort(403, 'Unauthorized access.'); // Return error if access levels don't match
        }

        return $next($request);
    }
}
