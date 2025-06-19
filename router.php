<?php
/**
 * Router script for PHP built-in server to support EspoCRM
 * This handles URL rewriting similar to Apache mod_rewrite
 */

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Serve existing files directly (css, js, images, etc.)
if ($uri !== '/' && file_exists(__DIR__ . '/public' . $uri)) {
    return false;
}

// Handle client directory
if (strpos($uri, '/client/') === 0 && file_exists(__DIR__ . $uri)) {
    return false;
}

// Route everything else through public/index.php
$_SERVER['SCRIPT_NAME'] = '/index.php';
$_SERVER['PHP_SELF'] = '/index.php';

// Handle install
if (strpos($uri, '/install') === 0) {
    chdir(__DIR__ . '/install');
    require 'index.php';
    return true;
}

// Handle everything else
chdir(__DIR__ . '/public');
require 'index.php';
return true;