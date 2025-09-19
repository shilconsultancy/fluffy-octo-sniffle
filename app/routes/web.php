<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ItemController; // Add this line

// Welcome Route
Route::get('/', function () {
    return view('welcome');
});

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // Settings Routes
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/company', [SettingsController::class, 'updateCompanySettings'])->name('settings.company.update');
    Route::post('/settings/profile', [SettingsController::class, 'updateProfileSettings'])->name('settings.profile.update');
    Route::post('/settings/financial', [SettingsController::class, 'updateFinancialSettings'])->name('settings.financial.update');
    
    // Items Resource Route
    Route::resource('items', ItemController::class); // Add this line
});