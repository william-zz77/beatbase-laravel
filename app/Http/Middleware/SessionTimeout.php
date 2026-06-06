<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionTimeout extends Controller
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (Auth::check()) {
            $timeout = 60 * 60; // 1 jam

            if (session()->has('login_time')) {
                if (time() - session('login_time') > $timeout) {
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    return redirect()->route('login')->withErrors([
                        'email' => 'Sesi Anda telah berakhir. Silakan login kembali.',
                    ]);
                }
            }

            // Refresh login_time setiap ada aktivitas
            session(['login_time' => time()]);
        }

        return $next($request);
    }
}