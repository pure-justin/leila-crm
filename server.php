<?php
/**
 * EspoCRM Development Server Router
 * For PHP built-in server
 */

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Static files that should be served directly
$staticExtensions = ['css', 'js', 'jpg', 'jpeg', 'png', 'gif', 'ico', 'svg', 'woff', 'woff2', 'ttf', 'eot', 'map'];
$extension = pathinfo($uri, PATHINFO_EXTENSION);

if (in_array($extension, $staticExtensions)) {
    $file = __DIR__ . $uri;
    if (file_exists($file)) {
        return false;
    }
}

// Handle client directory
if (strpos($uri, '/client/') === 0) {
    $file = __DIR__ . $uri;
    if (file_exists($file) && is_file($file)) {
        return false;
    }
}

// Handle API routes directly through index.php
if (strpos($uri, '/api/') === 0) {
    chdir(__DIR__);
    require 'index.php';
    return true;
}

// Handle install
if ($uri === '/install' || strpos($uri, '/install/') === 0) {
    chdir(__DIR__);
    require 'install/index.php';
    return true;
}

// Everything else goes through index.php
chdir(__DIR__);
require 'index.php';
return true;