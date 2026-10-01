<?php

// ═══════════════════════════════════════════════════
// VERCEL BOOTSTRAP - Setup writable paths in /tmp
// ═══════════════════════════════════════════════════

$appPath = dirname(__DIR__);

// 1. Create storage directories
$dirs = [
    '/tmp/storage/app/public',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/testing',
    '/tmp/storage/framework/views',
    '/tmp/storage/logs',
    '/tmp/bootstrap/cache',
];
foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
}

// 2. Copy bootstrap/cache PHP files so service providers are discovered
$sourceCache = $appPath . '/bootstrap/cache';
if (is_dir($sourceCache)) {
    foreach (glob($sourceCache . '/*.php') as $file) {
        $dest = '/tmp/bootstrap/cache/' . basename($file);
        if (!file_exists($dest)) {
            copy($file, $dest);
        }
    }
}

// 3. Copy SQLite database to /tmp (must be writable)
$dbSource = $appPath . '/database/database.sqlite';
$dbDest = '/tmp/database.sqlite';
if (!file_exists($dbDest) && file_exists($dbSource)) {
    copy($dbSource, $dbDest);
}

// 4. Run the app
try {
    require $appPath . '/public/index.php';
} catch (\Throwable $e) {
    http_response_code(500);
    echo "<h2>Vercel Error</h2><pre>" . $e->getMessage() . "\n\n" . $e->getTraceAsString() . "</pre>";
}
