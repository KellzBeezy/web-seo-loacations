<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenant\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Invalid credentials');
        }

        session(['tenant_user_id' => $user->id]);

        return redirect('/dashboard');
    }

    public function admin()
    {
        $user = User::find(session('tenant_user_id'));

        if (!$user->hasPermission('Create Customer')) {
            abort(403);
        }

        return view('admin.admin', compact('user'));

    }

    public function logout()
    {
        session()->flush();
        return redirect('/login');
    }
}