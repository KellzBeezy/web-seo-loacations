<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Tenant\User;
use App\Models\Tenant\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // Check if user has permission to view users
        // This assumes your User model has a hasPermission() method
        if (!auth()->user()->hasPermission('view_users')) {
            abort(403, 'Unauthorized action.');
        }

        $users = User::with('roles')->latest()->paginate(10);
        $roles = Role::all(); // For the "Add User" modal
        $user = auth()->user(); // Get the currently authenticated user 


        // dd(
        //     auth()->user()->load('roles.permissions')->hasPermission('view-location')
        // );

        return view('tenant.users.index', ['users' => $users, 'roles' => $roles, 'user' => $user]);
    }

    public function store(Request $request)
    {
        // 1. Validation (This will redirect back automatically if email exists)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role_id' => 'required|exists:roles,id',
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'tenant_id' => auth()->user()->tenant_id,
                'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            ]);


            $user->roles()->attach($request->role_id);

            return back()->with('success', 'User created successfully!');

        } catch (\Exception $e) {
            // REMOVE THIS dd() AFTER TESTING:
            // it will stop the "silent" failure so you can see the error.
            dd($e->getMessage());

            return back()->with('error', 'Critical Error: ' . $e->getMessage());
        }
    }
}