<?php

use App\Http\Controllers\AmenityController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\Landlord\PropertyController as LandlordPropertyController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\Tenant\PropertyController as TenantPropertyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::prefix('landlord')->middleware('role:landlord')->name('landlord.')->group(function () {
        Route::resource('properties', LandlordPropertyController::class);
    });

    Route::prefix('tenant')->middleware('role:landlord')->group(function () {});

    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::resource('locations', LocationController::class);
        Route::resource('amenities', AmenityController::class);
        Route::resource('properties', PropertyController::class);
        Route::resource('contracts', ContractController::class);
        Route::resource('invoices', InvoiceController::class);
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('tenant')->name('tenant.')->group(function () {
    Route::resource('properties', TenantPropertyController::class);
});


require __DIR__ . '/auth.php';
