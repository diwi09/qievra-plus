<?php

// 1. Definisikan folder penyimpanan serverless di /tmp
$baseTmp = '/tmp/storage';
$subDirs = [
    $baseTmp . '/framework/views',
    $baseTmp . '/framework/cache/data',
    $baseTmp . '/framework/sessions',
    $baseTmp . '/logs',
    $baseTmp . '/app/public',
    '/tmp/bootstrap/cache'
];

foreach ($subDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
}

// 2. Set environment runtime
putenv('VERCEL=1');
$_ENV['VERCEL'] = '1';
$_SERVER['VERCEL'] = '1';

putenv('VIEW_COMPILED_PATH=' . $baseTmp . '/framework/views');
putenv('APP_SERVICES_CACHE=/tmp/bootstrap/cache/services.php');
putenv('APP_PACKAGES_CACHE=/tmp/bootstrap/cache/packages.php');
putenv('SESSION_DRIVER=cookie');
putenv('CACHE_STORE=array');

// 3. Jalankan index publik Laravel
require __DIR__ . '/../public/index.php';
