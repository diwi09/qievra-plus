<?php

// 1. Buat direktori temporer di /tmp
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

// 2. Set environment runtime
putenv('VERCEL=1');
$_ENV['VERCEL'] = '1';
$_SERVER['VERCEL'] = '1';

putenv('VIEW_COMPILED_PATH=' . $baseTmp . '/framework/views');
putenv('SESSION_DRIVER=cookie');
putenv('CACHE_STORE=array');
putenv('FILESYSTEM_DISK=local');

// 3. Jalankan entrypoint Laravel
require __DIR__ . '/../public/index.php';
