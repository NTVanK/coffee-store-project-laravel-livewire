<?php

use App\Http\Middleware\AdminRedirect;
use App\Http\Middleware\CartRedirect;
use App\Http\Middleware\PaymentCheck;
use App\Http\Middleware\UserRedirect;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => AdminRedirect::class,
            'user' => UserRedirect::class,
            'cart' => CartRedirect::class,
            'payment-check' => PaymentCheck::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
