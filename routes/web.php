<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudioController;
use App\Http\Controllers\ReservasiController;
use App\Http\Controllers\PengaturanJamController;

// Public routes
Route::get('/', function () {
    return view('welcome');
});
