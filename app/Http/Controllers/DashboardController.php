<?php

namespace App\Http\Controllers;

use App\Models\Tenant\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = User::find(session('tenant_user_id'));

        return view('dashboard.index', compact('user'));
    }
}
