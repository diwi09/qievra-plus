<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Buat folder kerja di direktori /tmp Vercel
$storageDirs = [
    '/tmp/storage/app/public',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/views',
    '/tmp/storage/logs',
];

foreach ($storageDirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Muat Composer autoloader
require __DIR__ . '/../vendor/autoload.php';

// Inisialisasi aplikasi Laravel
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Alihkan path storage Laravel ke /tmp
$app->useStoragePath('/tmp/storage');

// Jalankan HTTP Kernel
$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
