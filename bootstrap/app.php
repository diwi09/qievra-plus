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

// Alihkan folder storage ke /tmp jika berjalan di Vercel
if (isset($_ENV['VERCEL']) || isset($_SERVER['VERCEL']) || getenv('VERCEL')) {
    $storagePath = '/tmp/storage';

    $subDirs = [
        '/framework/views',
        '/framework/cache/data',
        '/framework/sessions',
        '/logs',
        '/app/public',
    ];

    foreach ($subDirs as $dir) {
        if (!is_dir($storagePath . $dir)) {
            @mkdir($storagePath . $dir, 0777, true);
        }
    }

    $app->useStoragePath($storagePath);
}

return $app;
