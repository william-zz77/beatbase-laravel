<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSessionExpiry
{
    public function handle(Request $request, Closure $next): Response
    {
        // Skip middleware jika user belum login
        if (!auth()->check()) {
            return $next($request);
        }

        // Skip middleware untuk route login & logout
        if ($request->routeIs('login', 'login.post', 'logout', 'register', 'register.post')) {
            return $next($request);
        }

        $expireTime = session('expire_time');

        // Jika expire_time belum ada, set dulu (fallback)
        if (!$expireTime) {
            session([
                'login_time'    => time(),
                'expire_time'   => time() + (60),
                'last_activity' => time(),
            ]);
            return $next($request);
        }

        // Jika session sudah expired
        if (time() > $expireTime) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login', ['expired' => 1]);
        }

        // Perbarui expire_time setiap ada aktivitas
        session([
            'last_activity' => time(),
            'expire_time'   => time() + (60),
        ]);

        return $next($request);
    }
}