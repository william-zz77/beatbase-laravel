<?php
use App\Http\Middleware\CheckSessionExpiry;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web:      __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health:   '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role'           => RoleMiddleware::class,
            'session.expiry' => CheckSessionExpiry::class,
        ]);

        // Exclude logout dari CSRF verification
        $middleware->validateCsrfTokens(except: [
            'logout',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Redirect ke login jika 419 (CSRF expired)
        $exceptions->respond(function (\Illuminate\Http\Response $response) {
            if ($response->getStatusCode() === 419) {
                return redirect()->route('login')
                    ->with('error', 'Sesi Anda telah berakhir. Silakan login kembali.');
            }
            return $response;
        });
    })->create();