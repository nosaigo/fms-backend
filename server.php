<?php

/**
 * Laravel router script for PHP built-in server.
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? ''
);

// Serve static files directly from public/ if they exist
if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}

// Otherwise route everything through Laravel's index.php
require_once __DIR__.'/public/index.php';