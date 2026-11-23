<?php
// Save or remove a listing from the student's favorites.
require_once __DIR__ . '/includes/bootstrap.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); header('Allow: POST'); exit('Use the Save button.');
}
require_login();
require_csrf();
$item_id = safe_id($_POST['item_id'] ?? null);
$item = $item_id ? get_item($item_id) : null;
if (!$item || !(int)$item['is_available']) { set_flash('error', 'That item is not available.'); redirect('catalog.php'); }
$user_id = (int)current_user()['id'];
if (is_favorite($item_id)) {
    $stmt = db()->prepare('DELETE FROM favorites WHERE user_id = ? AND item_id = ?');
    $stmt->execute([$user_id, $item_id]);
    set_flash('success', 'Item removed from favorites.');
} else {
    $stmt = db()->prepare('INSERT IGNORE INTO favorites (user_id, item_id) VALUES (?, ?)');
    $stmt->execute([$user_id, $item_id]);
    set_flash('success', 'Item saved to favorites!');
}
redirect('item.php?id=' . $item_id);
