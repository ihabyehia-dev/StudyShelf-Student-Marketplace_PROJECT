<?php
require_once __DIR__ . '/../includes/bootstrap.php';
require_admin();
$page_title = 'Admin dashboard';
$counts = [];
foreach (['items' => 'items', 'categories' => 'categories', 'users' => 'users', 'messages' => 'messages'] as $key => $table) {
    $counts[$key] = (int)db()->query('SELECT COUNT(*) FROM ' . $table)->fetchColumn();
}
$counts['unread'] = (int)db()->query("SELECT COUNT(*) FROM messages WHERE status = 'New'")->fetchColumn();
$recent = db()->query('SELECT i.id, i.title, i.price, i.is_available, i.created_at, c.name AS category_name FROM items i JOIN categories c ON c.id = i.category_id ORDER BY i.id DESC LIMIT 5')->fetchAll();
require __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/admin_nav.php';
?>
<section class="section admin-section"><div class="container"><div class="section-top"><div><span class="eyebrow">CONTROL CENTER</span><h1>Dashboard</h1><p>Manage the sample listings and messages in one place.</p></div><a class="btn btn-primary" href="<?= e(url('admin/item_form.php')) ?>">+ Add item</a></div>
<div class="stats-grid"><div class="stat-box"><span>Total items</span><strong><?= $counts['items'] ?></strong></div><div class="stat-box"><span>Categories</span><strong><?= $counts['categories'] ?></strong></div><div class="stat-box"><span>Registered users</span><strong><?= $counts['users'] ?></strong></div><div class="stat-box"><span>New messages</span><strong><?= $counts['unread'] ?></strong></div></div>
<div class="admin-panel"><div class="panel-heading"><h2>Latest items</h2><a class="text-link" href="<?= e(url('admin/items.php')) ?>">Manage all &rarr;</a></div><div class="table-scroll"><table><thead><tr><th scope="col">Item</th><th scope="col">Category</th><th scope="col">Price</th><th scope="col">Status</th></tr></thead><tbody><?php foreach ($recent as $item): ?><tr><td><a href="<?= e(url('admin/item_form.php?id=' . (int)$item['id'])) ?>"><?= e($item['title']) ?></a></td><td><?= e($item['category_name']) ?></td><td><?= money($item['price']) ?></td><td><?= (int)$item['is_available'] ? 'Available' : 'Hidden' ?></td></tr><?php endforeach; ?></tbody></table></div></div>
<div class="admin-tip"><strong>Tip:</strong> Add categories first, then add items to those categories. Messages from the public contact form appear under Messages.</div>
</div></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
