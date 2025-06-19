<?php
/**
 * Development server router for EspoCRM
 * Handles URL rewriting for PHP built-in server
 */

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Remove trailing slash except for root
if ($uri !== '/' && substr($uri, -1) === '/') {
    $uri = substr($uri, 0, -1);
}

// Static file handling
$staticFiles = [
    '/client', '/api', '/install', '/portal'
];

foreach ($staticFiles as $path) {
    if (strpos($uri, $path) === 0) {
        $file = __DIR__ . $uri;
        if (is_file($file)) {
            return false; // Let PHP handle the static file
        }
    }
}

// Check if it's a physical file
if ($uri !== '/' && file_exists(__DIR__ . $uri) && is_file(__DIR__ . $uri)) {
    return false;
}

// Route everything else through index.php
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['SCRIPT_FILENAME'] = __DIR__ . '/index.php';
$_SERVER['PHP_SELF'] = '/index.php';
$_SERVER['PATH_INFO'] = $uri;

// Set the route for EspoCRM
if ($uri && $uri !== '/') {
    $_GET['route'] = ltrim($uri, '/');
}

chdir(__DIR__);
require __DIR__ . '/index.php';