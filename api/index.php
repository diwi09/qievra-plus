<?php

// Buat direktori dinamis di /tmp untuk cache & log Laravel
$tmpDirs = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
    '/tmp/views'
];

foreach ($tmpDirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Arahkan log error ke /tmp
ini_set('error_log', '/tmp/storage/logs/laravel.log');

// Jalankan file publik utama Laravel
require __DIR__ . '/../public/index.php';
