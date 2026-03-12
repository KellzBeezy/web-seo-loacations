<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});




Route::middleware('tenant')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin']);
    Route::get('/admin', [AuthController::class, 'admin']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
