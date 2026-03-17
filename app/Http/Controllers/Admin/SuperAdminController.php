<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AppTenant;
use App\Models\Activity;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Services\TenantProvisioningService;

class SuperAdminController extends Controller
{
    /**
     * Display the Global Dashboard Overview.
     */
    public function index()
    {
        $stats = [
            'total_tenants' => AppTenant::count(),
            'active_users' => User::count(),
            'total_revenue' => 59.40,
            'pending_tickets' => 4,
        ];

        return view('admin.dashboard', [
            'user' => auth()->user(),
            'tenants' => AppTenant::latest()->take(5)->get(),
            'activities' => Activity::with('user')->latest()->take(7)->get(),
            'stats' => (object) $stats
        ]);
    }

    /**
     * List all tenants in the system.
     */
    public function manageTenants()
    {
        // Eager load the owner to avoid N+1 query issues in your table
        $tenants = AppTenant::latest()->paginate(10);

        return view('admin.tenants.index', [
            'tenants' => $tenants,
            'user' => auth()->user()
        ]);
    }

    /**
     * Store a newly created tenant and its owner via the stepper form.
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'tenant_name' => 'required|string|max:255',
    //         'domain' => 'required|string|unique:app_tenants,domain',
    //         'db_name' => 'required|string|unique:app_tenants,db_name',
    //         'owner_name' => 'required|string|max:255',
    //         'owner_email' => 'required|email|unique:users,email',
    //         'owner_password' => 'required|string|min:8',
    //     ]);

    //     try {
    //         DB::beginTransaction();

    //         // 1. Create the Owner in the central 'users' table
    //         $owner = User::create([
    //             'name' => $request->owner_name,
    //             'email' => $request->owner_email,
    //             'password' => Hash::make($request->owner_password),
    //             // Add a 'role' here if you have one, e.g., 'role' => 'owner'
    //         ]);

    //         // // 2. Create the Tenant record
    //         // AppTenant::create([
    //         //     'name' => $request->tenant_name,
    //         //     'domain' => $request->domain,
    //         //     'db_name' => $request->db_name,
    //         //     'db_host' => '127.0.0.1', // Default or dynamic
    //         //     'db_username' => env('DB_USERNAME'), // Usually shared in basic setups
    //         //     'db_password' => env('DB_PASSWORD'),
    //         // ]);

    //         $tenantService = app(TenantProvisioningService::class);

    //         $tenant = $tenantService->createTenant([
    //             'name' => $request->tenant_name,
    //             'domain' => $request->domain . request()->getHttpHost(), // Assuming you want to append a base domain
    //             'db_name' => $request->db_name,
    //             'db_host' => '127.0.0.1',
    //             'db_username' => env('DB_USERNAME'),
    //             'db_password' => env('DB_PASSWORD'),
    //             'owner_name' => $request->owner_name,
    //             'owner_email' => $request->owner_email,
    //             'owner_password' => $request->owner_password,
    //         ]);

    //         return redirect()->route('admin.tenants')
    //             ->with('success', "Tenant '{$tenant->domain}' created successfully!");

    //     } catch (\Exception $e) {
    //         DB::rollBack();

    //         return back()
    //             ->withInput()
    //             ->with('error', 'Failed to create tenant: ' . $e->getMessage());
    //     }
    // }

    public function store(Request $request)
    {
        // 1. Validation - If this fails, Laravel automatically redirects back 
        // with an $errors bag that your Blade file can already see.
        $request->validate([
            'tenant_name' => 'required|string|max:255',
            'domain' => 'required|string|unique:app_tenants,domain',
            'db_name' => 'required|string|unique:app_tenants,db_name',
            'owner_name' => 'required|string|max:255',
            'owner_email' => 'required|email|unique:users,email',
            'owner_password' => 'required|string|min:8',
        ]);

        try {
            // REMOVED DB::beginTransaction() - It conflicts with CREATE DATABASE
            DB::beginTransaction();

            $tenantService = app(TenantProvisioningService::class);

            $tenant = $tenantService->createTenant([
                'name' => $request->tenant_name,
                'domain' => $request->domain . '.' . explode(':', $request->getHttpHost())[0],
                'db_name' => $request->db_name,
                'db_host' => env('DB_HOST') ?? '127.0.0.1',
                'db_username' => env('DB_USERNAME'),
                'db_password' => env('DB_PASSWORD'),
                'owner_name' => $request->owner_name,
                'owner_email' => $request->owner_email,
                'owner_password' => $request->owner_password,
            ]);

            return redirect()->route('admin.tenants')
                ->with('success', "Tenant '{$tenant->name}' created successfully!");

        } catch (\Exception $e) {
            // Log the error for the developer
            \Log::error("Tenant Creation Failed: " . $e->getMessage());

            dd($e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Critical Error: ' . $e->getMessage());
        }
    }

    /**
     * View System Health and Logs.
     */
    public function logs()
    {
        return view('admin.logs', ['user' => auth()->user()]);
    }

    // SuperAdminController.php

    public function update(Request $request, $id)
    {
        $tenant = AppTenant::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $tenant->update([
            'name' => $request->name,
        ]);

        return back()->with('success', 'Tenant updated successfully.');
    }

    public function destroy($id)
    {
        $tenant = AppTenant::findOrFail($id);

        // We only delete the central record to prevent accidental data loss of the tenant DB
        $tenant->delete();

        return redirect()->route('admin.tenants')
            ->with('success', 'Tenant record removed.');


    }
}