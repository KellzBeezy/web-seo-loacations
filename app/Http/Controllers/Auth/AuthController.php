<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Use the standard User model or your specific Tenant User

class AuthController extends Controller
{
    /**
     * Show Tenant Login
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Tenant Login Logic
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // dd(config('auth.guards.tenant'));
        // dd(Auth::guard('tenant')->attempt($credentials));

        // Explicitly use the 'tenant' guard
        if (Auth::guard('tenant')->attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::guard('tenant')->user();
            // Use a direct route to avoid "intended" logic loops during debugging
            return redirect()->route('tenant.dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Show Super Admin Login
     */
    public function showAdminLogin()
    {
        return view('auth.login', ['isAdmin' => true]); // Create this view or use the tenant one
    }

    /**
     * Super Admin Login Logic
     */
    // public function adminLogin(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'email' => ['required', 'email'],
    //         'password' => ['required'],
    //     ]);

    //     if (Auth::attempt($credentials)) {
    //         // Check if the user actually has admin privileges
    //         if (Auth::user()->is_admin) {
    //             $request->session()->regenerate();
    //             return redirect()->route('admin.dashboard');
    //         }

    //         // If not admin, log them out and kick back
    //         Auth::logout();
    //         return back()->with('error', 'You do not have administrative access.');
    //     }

    //     return back()->with('error', 'Invalid admin credentials');
    // }

    /**
     * Super Admin Login Logic
     */
    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // This uses the 'web' guard which points to the Landlord model/table
        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->with('error', 'Invalid admin credentials');
    }

    /**
     * Logout for all users
     */

    public function logout(Request $request)
    {
        // 1. Determine which login page to return to BEFORE clearing the session
        // This checks if the current URL contains 'super-admin'
        $isAdminRequest = $request->is('admin/*') || $request->is('admin');

        // 2. Log out of specific guards
        Auth::guard('web')->logout();
        Auth::guard('tenant')->logout();

        // 3. Destroy session and CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 4. Redirect based on where they logged out from
        if ($isAdminRequest) {
            return redirect()->route('admin.login');
        }

        return redirect()->route('login');
    }
}