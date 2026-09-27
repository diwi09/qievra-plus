<?php

// 1. Siapkan folder temporer di /tmp
$baseTmp = '/tmp/storage';
$subDirs = [
    $baseTmp . '/framework/views',
    $baseTmp . '/framework/cache/data',
    $baseTmp . '/framework/sessions',
    $baseTmp . '/logs',
    $baseTmp . '/app/public',
];

foreach ($subDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
}

// 2. Set environment fallback agar getDefaultDriver() tidak pernah null
putenv('APP_ENV=production');
putenv('APP_DEBUG=true');
putenv('VERCEL=1');
putenv('SESSION_DRIVER=cookie');
putenv('CACHE_STORE=array');
putenv('FILESYSTEM_DISK=local');
putenv('VIEW_COMPILED_PATH=' . $baseTmp . '/framework/views');

// Hindari pemanggilan cache konfigurasi read-only
putenv('APP_CONFIG_CACHE=');
putenv('APP_SERVICES_CACHE=');
putenv('APP_PACKAGES_CACHE=');
putenv('APP_ROUTES_CACHE=');
putenv('APP_EVENTS_CACHE=');

// 3. Muat aplikasi Laravel
require __DIR__ . '/../public/index.php';
