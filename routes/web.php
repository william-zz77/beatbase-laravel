<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudioController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\PengaturanJamController;

// Public routes
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('dashboard');
    Route::resource('studio', StudioController::class);
    Route::resource('reservasi', ReservasiController::class);
    Route::get('pengaturan-jam', [PengaturanJamController::class, 'index'])->name('pengaturan-jam');
    Route::put('pengaturan-jam', [PengaturanJamController::class, 'update'])->name('pengaturan-jam.update');
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