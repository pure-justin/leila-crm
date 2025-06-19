<?php
/**
 * Development server for EspoCRM
 * Handles URL rewriting for PHP built-in server
 */

$uri = $_SERVER['REQUEST_URI'];
$path = parse_url($uri, PHP_URL_PATH);

// Remove query string
if (($pos = strpos($path, '?')) !== false) {
    $path = substr($path, 0, $pos);
}

// Static files in root
if ($path !== '/' && file_exists(__DIR__ . $path) && is_file(__DIR__ . $path)) {
    // Check if it's a PHP file (should not be served as static)
    if (substr($path, -4) !== '.php') {
        return false; // Let PHP serve the file
    }
}

// All requests go through public/index.php
$_SERVER['SCRIPT_NAME'] = '/public/index.php';
require __DIR__ . '/public/index.php';