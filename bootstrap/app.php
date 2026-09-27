<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

// Pastikan storage path selalu dialihkan ke /tmp saat di Vercel
if (isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL']) || getenv('VERCEL')) {
    $storagePath = '/tmp/storage';
    if (!is_dir($storagePath)) {
        @mkdir($storagePath . '/framework/views', 0777, true);
        @mkdir($storagePath . '/framework/cache/data', 0777, true);
        @mkdir($storagePath . '/framework/sessions', 0777, true);
        @mkdir($storagePath . '/logs', 0777, true);
        @mkdir($storagePath . '/app/public', 0777, true);
    }
    $app->useStoragePath($storagePath);
}

return $app;
