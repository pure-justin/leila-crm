<?php
/**
 * Router script for PHP built-in server to support EspoCRM
 * This handles URL rewriting similar to Apache mod_rewrite
 */

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Handle static files
if ($uri !== '/' && file_exists(__DIR__ . $uri)) {
    return false;
}

// Handle EspoCRM routing
$_GET['route'] = $uri;

// Handle install path
if (strpos($uri, '/install') === 0) {
    require_once __DIR__ . '/install/index.php';
    return true;
}

// Handle API routes
if (strpos($uri, '/api/') === 0) {
    require_once __DIR__ . '/public/api/v1/index.php';
    return true;
}

// Default to index.php
require_once __DIR__ . '/index.php';
return true;