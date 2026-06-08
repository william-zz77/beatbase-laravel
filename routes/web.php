<?php
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

// ── Guest (belum login) ─────────────────────────────────
Route::get('/', [AuthController::class, 'showLogin'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',    [AuthController::class, 'login'])->name('login.post');
    Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// ── Logout (auth saja, tanpa session.expiry) ────────────
Route::middleware('auth')->post('/logout', [AuthController::class, 'logout'])->name('logout');

// ── Authenticated + Session Expiry ─────────────────────
Route::middleware(['auth', 'session.expiry'])->group(function () {

    // Admin
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::resource('studio', \App\Http\Controllers\Admin\StudioController::class);
        Route::resource('user',   \App\Http\Controllers\Admin\UserController::class);
        Route::get('/reservasi',                      [\App\Http\Controllers\Admin\ReservasiController::class, 'index'])->name('reservasi.index');
        Route::patch('/reservasi/{reservasi}/status', [\App\Http\Controllers\Admin\ReservasiController::class, 'updateStatus'])->name('reservasi.status');
        Route::delete('/reservasi/{reservasi}',       [\App\Http\Controllers\Admin\ReservasiController::class, 'destroy'])->name('reservasi.destroy');
        Route::get('/pengaturan',  [\App\Http\Controllers\Admin\PengaturanController::class, 'index'])->name('pengaturan.index');
        Route::put('/pengaturan',  [\App\Http\Controllers\Admin\PengaturanController::class, 'update'])->name('pengaturan.update');
        Route::get('/report/pdf',   [\App\Http\Controllers\ReportController::class, 'adminPdf'])->name('report.pdf');
        Route::get('/report/excel', [\App\Http\Controllers\ReportController::class, 'adminExcel'])->name('report.excel');
        Route::get('/chart/data',   [\App\Http\Controllers\Admin\DashboardController::class, 'chartData'])->name('chart.data');
    });

    // Owner
    Route::middleware('role:owner')->prefix('owner')->name('owner.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Owner\DashboardController::class, 'index'])->name('dashboard');
        Route::resource('studio', \App\Http\Controllers\Owner\StudioController::class);
        Route::get('/reservasi',                      [\App\Http\Controllers\Owner\ReservasiController::class, 'index'])->name('reservasi.index');
        Route::patch('/reservasi/{reservasi}/status', [\App\Http\Controllers\Owner\ReservasiController::class, 'updateStatus'])->name('reservasi.status');
        Route::get('/report/pdf',   [\App\Http\Controllers\ReportController::class, 'ownerPdf'])->name('report.pdf');
        Route::get('/report/excel', [\App\Http\Controllers\ReportController::class, 'ownerExcel'])->name('report.excel');
        Route::get('/chart/data',   [\App\Http\Controllers\Owner\DashboardController::class, 'chartData'])->name('chart.data');
    });

    // Customer
    Route::middleware('role:customer')->prefix('customer')->name('customer.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Customer\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/booking',   [\App\Http\Controllers\Customer\BookingController::class, 'index'])->name('booking.index');
        Route::post('/booking',  [\App\Http\Controllers\Customer\BookingController::class, 'store'])->name('booking.store');
        Route::post('/booking/hitung', [\App\Http\Controllers\Customer\BookingController::class, 'hitungHarga'])->name('booking.hitung');
        Route::get('/riwayat',                     [\App\Http\Controllers\Customer\RiwayatController::class, 'index'])->name('riwayat.index');
        Route::patch('/riwayat/{reservasi}/batal', [\App\Http\Controllers\Customer\RiwayatController::class, 'batal'])->name('riwayat.batal');
        Route::get('/pembayaran/{reservasi}',      [\App\Http\Controllers\Customer\PembayaranController::class, 'show'])->name('pembayaran.show');
        Route::post('/pembayaran/{reservasi}',     [\App\Http\Controllers\Customer\PembayaranController::class, 'store'])->name('pembayaran.store');
        Route::get('/jadwal', [\App\Http\Controllers\Customer\JadwalController::class, 'index'])->name('jadwal.index');
    });
});