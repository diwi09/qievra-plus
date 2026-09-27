<?php

// Pastikan VERCEL env terdeteksi
putenv('VERCEL=1');
$_ENV['VERCEL'] = '1';
$_SERVER['VERCEL'] = '1';

// Alihkan folder compiled views bawaan
putenv('VIEW_COMPILED_PATH=/tmp/storage/framework/views');

// Load index publik Laravel
require __DIR__ . '/../public/index.php';
