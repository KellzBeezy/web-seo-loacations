<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Location;
use Illuminate\Support\Facades\Auth; // Essential import
use App\Models\Tenant\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Retrieves the user from the tenant-specific session/database
        $user = Auth::guard('tenant')->user();
        $locations = Location::all();

        return view('tenant.dashboard', compact('user', 'locations'));
    }
}