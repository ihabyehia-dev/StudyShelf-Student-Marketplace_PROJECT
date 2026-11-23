<?php
require_once __DIR__ . '/../includes/bootstrap.php';
require_admin();
$page_title = 'Manage items';
$items = db()->query('SELECT i.*, c.name AS category_name FROM items i JOIN categories c ON c.id = i.category_id ORDER BY i.id DESC')->fetchAll();
require __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/admin_nav.php';
?>
<section class="section admin-section"><div class="container"><div class="section-top"><div><span class="eyebrow">ITEMS MANAGEMENT</span><h1>Manage items</h1><p>Add, edit, hide, or delete listings.</p></div><a class="btn btn-primary" href="<?= e(url('admin/item_form.php')) ?>">+ Add item</a></div>
<div class="admin-panel"><div class="table-scroll"><table><thead><tr><th scope="col">Item</th><th scope="col">Category</th><th scope="col">Price</th><th scope="col">Condition</th><th scope="col">Availability</th><th scope="col">Actions</th></tr></thead><tbody>
<?php foreach ($items as $item): ?><tr><td><strong><?= e($item['title']) ?></strong></td><td><?= e($item['category_name']) ?></td><td><?= money($item['price']) ?></td><td><?= e($item['item_condition']) ?></td><td><?= (int)$item['is_available'] ? '<span class="table-status">Available</span>' : 'Hidden' ?></td><td class="actions-cell"><a class="btn btn-small btn-outline" href="<?= e(url('admin/item_form.php?id=' . (int)$item['id'])) ?>">Edit</a><form method="post" action="<?= e(url('admin/item_delete.php')) ?>" data-confirm="Delete this item permanently?"><?= csrf_field() ?><input type="hidden" name="id" value="<?= (int)$item['id'] ?>"><button type="submit" class="btn btn-small btn-danger">Delete</button></form></td></tr><?php endforeach; ?>
</tbody></table></div><?php if (!$items): ?><p class="empty-state">No items yet. Click Add item.</p><?php endif; ?></div>
</div></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
