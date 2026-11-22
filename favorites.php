<?php
require_once __DIR__ . '/includes/bootstrap.php';
require_login();
$page_title = 'My favorites';
$statement = db()->prepare('SELECT i.*, c.name AS category_name FROM favorites f JOIN items i ON i.id = f.item_id JOIN categories c ON c.id = i.category_id WHERE f.user_id = ? ORDER BY f.created_at DESC');
$statement->execute([current_user()['id']]);
$items = $statement->fetchAll();
require __DIR__ . '/includes/header.php';
?>
<section class="page-intro"><div class="container"><span class="eyebrow">YOUR SAVED ITEMS</span><h1>My favorites</h1><p>Your personal list of interesting study materials.</p></div></section>
<section class="section"><div class="container"><?php if ($items): ?><div class="items-grid"><?php foreach ($items as $item): ?><?php require __DIR__ . '/includes/item_card.php'; ?><?php endforeach; ?></div><?php else: ?><div class="empty-state"><h2>No favorites yet</h2><p>Open an item and click Save to favorites.</p><a class="btn btn-primary" href="<?= e(url('catalog.php')) ?>">Browse items</a></div><?php endif; ?></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
