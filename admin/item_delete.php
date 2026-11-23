<?php
// Handles an administrator's item deletion request.
require_once __DIR__ . '/../includes/bootstrap.php';
require_admin();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); header('Allow: POST'); exit('Invalid request method.');
}
require_csrf();
$id = safe_id($_POST['id'] ?? null);
if ($id) {
    $stmt = db()->prepare('DELETE FROM items WHERE id = ?');
    $stmt->execute([$id]);
    set_flash('success', $stmt->rowCount() ? 'Item deleted successfully.' : 'Item was not found.');
}
redirect('admin/items.php');
