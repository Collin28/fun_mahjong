<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->alias([
            'admin' => function (Request $request, $next) {
            // Validasi: Harus login DAN rolenya admin
            if (Auth::check() && Auth::user()->role === 'admin') {
                return $next($request);
            }

            // Jika bukan admin, lempar balik ke user home
            return redirect()->route('user.dashboard')->with('error', 'Akses khusus Admin!');
        }
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();