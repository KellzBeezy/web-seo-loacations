<?php

// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

// class EnsureUserIsSuperAdmin
// {
//     public function handle(Request $request, Closure $next)
//     {
//         // Check if user is logged in AND is an admin
//         if (Auth::check() && Auth::user()->is_admin) {
//             return $next($request);
//         }

//         // If not admin, kick them back to their tenant dashboard
//         return redirect()->route('tenant.dashboard')->with('error', 'Unauthorized access.');
//     }
// }



namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsSuperAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is logged in specifically via the 'web' (Landlord) guard
        if (Auth::guard('web')->check()) {
            return $next($request);
        }

        // If not a Landlord, but logged in as a Tenant, redirect to Tenant Dashboard
        if (Auth::guard('tenant')->check()) {
            return redirect()->route('tenant.dashboard')->with('error', 'Admins only.');
        }

        // If not logged in at all, send to Admin Login
        return redirect()->route('admin.login')->with('error', 'Please login as an Admin.');
    }
}