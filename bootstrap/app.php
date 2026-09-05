<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',  //
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(\Illuminate\Http\Middleware\HandleCors::class);

        // Laravel 11 ships the `api` group without throttling, so every route in
        // routes/api.php was unlimited - that is how a bot fired repeat signups
        // seconds apart (see storage/logs/mail.log, 2026-08-30 and 2026-09-05).
        // Tune with API_RATE_LIMIT_PER_MINUTE; auth/OTP routes add tighter limits.
        $middleware->api(prepend: [
            \Illuminate\Routing\Middleware\ThrottleRequests::class . ':api',
        ]);
        $middleware->alias([
            'check.token' => App\Http\Middleware\CheckTokenMiddleware::class,
        ]);
        $middleware->append(App\Http\Middleware\LanguageMiddleware::class);
        $middleware->append(App\Http\Middleware\SecurityHeadersMiddleware::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
    
