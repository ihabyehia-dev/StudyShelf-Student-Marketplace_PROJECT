<?php
// Shared application setup for every public and admin page.
if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_httponly' => true,
        'cookie_samesite' => 'Lax',
        'use_strict_mode' => true
    ]);
}

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/functions.php';

// These pages live either at project root or in /admin.
// This keeps links working even when the folder is renamed in htdocs.
$folder = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '/index.php'));
if (str_ends_with($folder, '/admin')) {
    $folder = substr($folder, 0, -6);
}
$folder = rtrim($folder, '/');
define('BASE_URL', ($folder === '' ? '/' : $folder . '/'));
