<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudioController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\PengaturanJamController;

Route::get('/', fn() => redirect()->route('login'));

// Auth
Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',   [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register',[AuthController::class, 'register']);
Route::get('/logout',   [AuthController::class, 'logout'])->name('logout');

// Admin
Route::middleware(['auth','role:admin','session.timeout'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'admin'])->name('dashboard');
    Route::resource('studio', StudioController::class);
    Route::resource('reservasi', ReservasiController::class);
    Route::get('pengaturan-jam',  [PengaturanJamController::class, 'index'])->name('pengaturan-jam');
    Route::put('pengaturan-jam',  [PengaturanJamController::class, 'update'])->name('pengaturan-jam.update');
});

// Owner
Route::middleware(['auth','role:owner','session.timeout'])->prefix('owner')->name('owner.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'owner'])->name('dashboard');
    Route::get('reservasi',        [ReservasiController::class, 'index'])->name('reservasi.index');
    Route::get('reservasi/{id}',   [ReservasiController::class, 'show'])->name('reservasi.show');
});

// Customer
Route::middleware(['auth','role:customer','session.timeout'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/dashboard',         [App\Http\Controllers\DashboardController::class, 'customer'])->name('dashboard');
    Route::get('reservasi',          [ReservasiController::class, 'index'])->name('reservasi.index');
    Route::get('reservasi/create',   [ReservasiController::class, 'create'])->name('reservasi.create');
    Route::post('reservasi',         [ReservasiController::class, 'store'])->name('reservasi.store');
    Route::get('jadwal',             [ReservasiController::class, 'jadwal'])->name('jadwal');
});