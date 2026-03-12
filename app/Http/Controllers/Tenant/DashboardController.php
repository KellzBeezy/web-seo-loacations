<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth; // Essential import
use App\Models\Tenant\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Retrieves the user from the tenant-specific session/database
        $user = Auth::guard('tenant')->user();

        return view('tenant.dashboard', compact('user'));
    }
}