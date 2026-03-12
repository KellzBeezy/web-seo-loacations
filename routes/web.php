<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Tenant\DashboardController;
use App\Http\Controllers\Admin\SuperAdminController;

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