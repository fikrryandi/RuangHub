<?php

// Ensure storage directories exist in /tmp for Vercel
$storagePath = '/tmp/storage';
if (!is_dir($storagePath)) {
    mkdir($storagePath, 0777, true);
    mkdir($storagePath . '/app/public', 0777, true);
    mkdir($storagePath . '/framework/cache/data', 0777, true);
    mkdir($storagePath . '/framework/sessions', 0777, true);
    mkdir($storagePath . '/framework/testing', 0777, true);
    mkdir($storagePath . '/framework/views', 0777, true);
    mkdir($storagePath . '/logs', 0777, true);
}

// Create views compiled path
if (!is_dir('/tmp/views')) {
    mkdir('/tmp/views', 0777, true);
}

// Copy SQLite database to /tmp if not exists (it needs to be writable)
$dbSource = __DIR__ . '/../database/database.sqlite';
$dbDest = '/tmp/database.sqlite';
if (!file_exists($dbDest) && file_exists($dbSource)) {
    copy($dbSource, $dbDest);
}

try {
    require __DIR__ . '/../public/index.php';
} catch (\Throwable $e) {
    http_response_code(500);
    echo "<h1>Fatal Error in Vercel Deployment</h1>";
    echo "<pre>" . $e->getMessage() . "</pre>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
