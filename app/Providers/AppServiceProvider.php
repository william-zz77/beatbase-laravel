<?php
namespace App\Providers;

use App\Models\Pembayaran;
use App\Models\Reservasi;
use App\Models\Studio;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Route::bind('reservasi', function ($value) {
            return Reservasi::where('id_reservasi', $value)->firstOrFail();
        });

        Route::bind('studio', function ($value) {
            return Studio::where('id_studio', $value)->firstOrFail();
        });

        Route::bind('user', function ($value) {
            return User::where('id_user', $value)->firstOrFail();
        });
    }
}