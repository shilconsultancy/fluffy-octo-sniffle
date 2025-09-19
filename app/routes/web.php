<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;

// Publicly accessible routes
Route::get('/', function () {
    return view('welcome');
});

// Routes that require authentication
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes (using the modern resource controller approach)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Settings routes
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/company', [SettingsController::class, 'updateCompanySettings'])->name('settings.company.update');
    Route::post('/settings/profile', [SettingsController::class, 'updateProfileSettings'])->name('settings.profile.update');
    Route::post('/settings/financial', [SettingsController::class, 'updateFinancialSettings'])->name('settings.financial.update');
    
    // Item resource routes
    Route::resource('items', ItemController::class);
});

// This line correctly includes all the necessary authentication routes
// (login, register, logout, password reset, etc.) from the auth.php file.
require __DIR__.'/auth.php';