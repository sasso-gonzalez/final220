<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAccessLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();
            
            if (!$this->hasAccess($user, $request->route())) {
                return redirect()->route('unauthorized')->with('error', 'You do not have access to this page.');
            }
        } else {
            return redirect()->route('login')->with('error', 'Please log in to access this page.');
        }

        return $next($request);
    }

    /**
     * Determine if the user has access to the route.
     *
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Routing\Route  $route
     * @return bool
     */
    private function hasAccess($user, $route)
    {
        $routeName = $route->getName();

        $accessRules = [
            'admin.*' => 1,
            'user.*'  => 5,
        ];

        foreach ($accessRules as $pattern => $requiredLevel) {
            if (\Str::is($pattern, $routeName) && $user->access_level < $requiredLevel) {
                return false;
            }
        }

        return true;
    }
}
