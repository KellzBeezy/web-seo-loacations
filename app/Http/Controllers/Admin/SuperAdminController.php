<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AppTenant; // Assuming you have a Tenant model
use Illuminate\Support\Facades\DB;

class SuperAdminController extends Controller
{
    /**
     * Display the Global Dashboard Overview.
     */
    public function index()
    {
        // Fetching data for the stats cards in the dashboard
        $stats = [
            'total_tenants' => AppTenant::count(),
            'active_users' => User::count(),
            // 'total_revenue' => DB::table('payments')->sum('amount'), // Example logic
            'total_revenue' => 55.90,
            // 'pending_tickets' => DB::table('maintenance_requests')->where('status', 'open')->count(),
            'pending_tickets' => 4,
        ];

        // Passing the stats and the authenticated admin to the view
        return view('admin.dashboard', [
            'user' => auth()->user(),
            'stats' => (object) $stats
        ]);
    }

    /**
     * List all tenants in the system.
     */
    public function manageTenants()
    {
        // $tenants = AppTenant::with('owner')->latest()->paginate(10);
        $tenants = AppTenant::latest()->paginate(10);

        return view('admin.tenants.index', [
            'tenants' => $tenants,
            'user' => auth()->user()
        ]);
    }

    /**
     * View System Health and Logs.
     */
    public function logs()
    {
        // This is a placeholder for log viewing logic
        // You could use a package like 'spatie/laravel-activitylog'
        return view('admin.logs', ['user' => auth()->user()]);
    }
}