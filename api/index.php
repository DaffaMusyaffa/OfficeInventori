<?php

/**
 * Entry point untuk Vercel PHP runtime.
 *
 * Filesystem Vercel bersifat read-only KECUALI direktori /tmp.
 * Laravel butuh menulis compiled views, cache, dan log, jadi kita
 * arahkan semua ke /tmp (lihat env VIEW_COMPILED_PATH & LOG_CHANNEL=stderr).
 */
$writableDirs = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
    '/tmp/bootstrap/cache',
];

foreach ($writableDirs as $dir) {
    if (! is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }
}

// Teruskan request ke front controller Laravel.
require __DIR__ . '/../public/index.php';
