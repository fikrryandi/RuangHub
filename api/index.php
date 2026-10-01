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

// Forward Vercel requests to normal index.php
require __DIR__ . '/../public/index.php';
