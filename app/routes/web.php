<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CustomerController; // <-- ADD THIS
use Illuminate\Support\Facades\Route;

// Publicly accessible routes
Route::get('/', function () {
    return view('welcome');
});

// Routes that require authentication
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Settings routes
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/company', [SettingsController::class, 'updateCompanySettings'])->name('settings.company.update');
    Route::post('/settings/profile', [SettingsController::class, 'updateProfileSettings'])->name('settings.profile.update');
    Route::post('/settings/financial', [SettingsController::class, 'updateFinancialSettings'])->name('settings.financial.update');
    
    // Resource routes
    Route::resource('items', ItemController::class);
    Route::resource('customers', CustomerController::class); // <-- ADD THIS

});

require __DIR__.'/auth.php';