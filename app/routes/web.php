<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\SettingsController; // Make sure this is imported
use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;

// Publicly accessible routes
Route::get('/', function () {
    return view('welcome');
});

// Routes that require authentication
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Settings routes (FIX)
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings/company', [SettingsController::class, 'updateCompanySettings'])->name('settings.company.update');
    Route::post('/settings/profile', [SettingsController::class, 'updateProfileSettings'])->name('settings.profile.update');
    Route::post('/settings/financial', [SettingsController::class, 'updateFinancialSettings'])->name('settings.financial.update');
    
    // Resource routes
    Route::get('quotes/{quote}/print', [QuoteController::class, 'print'])->name('quotes.print');
    Route::resource('quotes', QuoteController::class);
    Route::resource('items', ItemController::class);
    Route::resource('customers', CustomerController::class);

    // Invoices routes
    Route::resource('invoices', InvoiceController::class);
});

require __DIR__.'/auth.php';