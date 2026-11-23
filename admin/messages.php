<?php
require_once __DIR__ . '/../includes/bootstrap.php';
require_admin();
$page_title = 'Contact messages';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    $id = safe_id($_POST['id'] ?? 0);
    $action = (string)($_POST['action'] ?? '');
    if ($id && $action === 'read') {
        $stmt = db()->prepare("UPDATE messages SET status = 'Read' WHERE id = ?");
        $stmt->execute([$id]);
        set_flash('success', 'Message marked as read.');
    } elseif ($id && $action === 'delete') {
        $stmt = db()->prepare('DELETE FROM messages WHERE id = ?');
        $stmt->execute([$id]);
        set_flash('success', 'Message deleted.');
    }
    redirect('admin/messages.php');
}
$messages = db()->query('SELECT m.*, i.title AS item_title FROM messages m LEFT JOIN items i ON i.id = m.item_id ORDER BY m.created_at DESC, m.id DESC')->fetchAll();
require __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/admin_nav.php';
?>
<section class="section admin-section"><div class="container"><div class="section-top"><div><span class="eyebrow">CONTACT FORM</span><h1>Messages</h1><p>See messages saved through the public contact form.</p></div></div>
<?php if (!$messages): ?><div class="empty-state">There are no messages yet.</div><?php endif; ?>
<div class="messages-grid"><?php foreach ($messages as $msg): ?><article class="message-card"><div class="message-top"><span class="pill"><?= e($msg['status']) ?></span><small><?= e(date('M j, Y', strtotime($msg['created_at']))) ?></small></div><h2><?= e($msg['subject']) ?></h2><p><strong>From:</strong> <?= e($msg['sender_name']) ?> &lt;<?= e($msg['sender_email']) ?>&gt;</p><?php if ($msg['item_title']): ?><p><strong>Item:</strong> <?= e($msg['item_title']) ?></p><?php endif; ?><p class="message-content"><?= nl2br(e($msg['message'])) ?></p><div class="form-actions"><?php if ($msg['status'] === 'New'): ?><form method="post" action="<?= e(url('admin/messages.php')) ?>"><?= csrf_field() ?><input type="hidden" name="id" value="<?= (int)$msg['id'] ?>"><input type="hidden" name="action" value="read"><button class="btn btn-small btn-outline" type="submit">Mark read</button></form><?php endif; ?><form method="post" action="<?= e(url('admin/messages.php')) ?>" data-confirm="Delete this message?"><?= csrf_field() ?><input type="hidden" name="id" value="<?= (int)$msg['id'] ?>"><input type="hidden" name="action" value="delete"><button class="btn btn-small btn-danger" type="submit">Delete</button></form></div></article><?php endforeach; ?></div>
</div></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
