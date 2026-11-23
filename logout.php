<?php
// Logout request and session cleanup.
require_once __DIR__ . '/includes/bootstrap.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    header('Allow: POST');
    exit('Use the Log out button.');
}
require_csrf();
unset($_SESSION['user'], $_SESSION['csrf_token']);
session_regenerate_id(true);
set_flash('success', 'You have been logged out.');
redirect('index.php');
