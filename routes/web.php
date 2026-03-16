<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Tenant\DashboardController;
use App\Http\Controllers\Tenant\LocationController;
use App\Http\Controllers\Tenant\UserController;
use App\Http\Controllers\Admin\SuperAdminController;
use App\Http\Controllers\Admin\ActivityController;
use App\Models\AppTenant;
use App\Models\Activity;

/*
|--------------------------------------------------------------------------
| 1. Central / Super Admin Routes
|--------------------------------------------------------------------------
| These routes handle the Landlord/Central system.
*/
Route::prefix('admin')->group(function () {

    // Admin Guest Routes (Redirects to dashboard if already logged in)
    Route::middleware('guest:web')->group(function () {
        Route::get('/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
        Route::post('/login', [AuthController::class, 'adminLogin']);
    });

    // Admin Protected Routes
    // Using 'auth:web' ensures we check the Landlord database/guard
    Route::middleware(['auth:web', 'super_admin'])->group(function () {
        Route::get('/dashboard', [SuperAdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/tenants', [SuperAdminController::class, 'manageTenants'])->name('admin.tenants');
        Route::get('/system-logs', [SuperAdminController::class, 'logs'])->name('admin.logs');

        Route::post('/signed-up', [SuperAdminController::class, 'store'])->name('admin.tenants.store');

        // New Routes
        Route::put('/tenants/{id}', [SuperAdminController::class, 'update'])->name('admin.tenants.update');
        Route::delete('/tenants/{id}', [SuperAdminController::class, 'destroy'])->name('admin.tenants.destroy');

        // Page to view all logs
        Route::get('/admin/activities', [ActivityController::class, 'index'])->name('admin.activities.index');

        // Route to download logs as CSV
        Route::get('/admin/activities/download', [ActivityController::class, 'download'])->name('admin.activities.download');

        // Use the explicit logout route
        Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
    });
});


/*
|--------------------------------------------------------------------------
| 2. Tenant Specific Routes
|--------------------------------------------------------------------------
| Wrapped in 'tenant' middleware to handle dynamic database switching.
*/
Route::middleware('tenant')->group(function () {

    // Tenant Guest Routes
    // Using 'guest:tenant' prevents loops for logged-in tenant users
    Route::middleware('guest:tenant')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login']);
    });

    // Tenant Authenticated Routes
    // Using 'auth:tenant' ensures we check the dynamic Tenant database/guard
    Route::middleware(['auth:tenant'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('tenant.dashboard');
        Route::post('/logout', [AuthController::class, 'logout'])->name('tenant.logout');

        Route::get('/profile', [DashboardController::class, 'profile'])->name('tenant.profile');
        Route::get('/settings', [DashboardController::class, 'settings'])->name('tenant.settings');

        // Display the list and the form
        Route::get('/locations', [LocationController::class, 'index'])->middleware('permission:view_locations')->name('locations.index');

        // Handle the form submission
        Route::post('/locations', [LocationController::class, 'bulkStore'])->middleware('permission:add_location')->name('locations.store');

        Route::post('/locations/import', [LocationController::class, 'import'])->middleware('permission:add_location')->name('locations.import');

        Route::get('/locations/export-template', [LocationController::class, 'exportTemplate'])->name('locations.template');

        Route::put('/locations/{location}', [LocationController::class, 'update'])->middleware('permission:update_location')->name('locations.update');

        Route::delete('/locations/{location}', [LocationController::class, 'destroy'])->middleware('permission:delete_location')->name('locations.destroy');

        /* Optional: If you want to add delete or edit functionality later, 
           you can use a resource route instead:
           Route::resource('locations', LocationController::class);
        */

        // View Users List (Permission: view-users)
        Route::get('/users', [UserController::class, 'index'])->middleware('permission:view_users')->name('users.index');

        // Create New User (Role: admin)
        Route::post('/users', [UserController::class, 'store'])->middleware('role:admin')->name('users.store');

        /* If you want to add delete/edit later, you can expand this to:
           Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        */

    });
});

/*
|--------------------------------------------------------------------------
| 3. Global Landing Page
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});