<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
// Owner routes
Route::middleware(['auth', 'role:owner'])->prefix('owner')->name('owner.')->group(function () {
    Route::get('/dashboard', function () { return view('owner.dashboard'); })->name('dashboard');
    Route::resource('reservasi', ReservasiController::class)->only(['index', 'show']);
});

// Customer routes
Route::middleware(['auth', 'role:customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard', function () { return view('customer.dashboard'); })->name('dashboard');
    Route::resource('reservasi', ReservasiController::class)->only(['index', 'create', 'store']);
});