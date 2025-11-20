<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // --- TAMBAHKAN ALIAS ANDA DI SINI ---
        $middleware->alias([
            'isAdmin' => \App\Http\Middleware\IsAdmin::class,
            // 'verified' => \App\Http\Middleware\EnsureEmailIsVerified::class, // (Contoh jika Anda butuh yang lain)
        ]);
        // -------------------------------------
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
