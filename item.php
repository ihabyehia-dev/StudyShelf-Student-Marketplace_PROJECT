<?php
// Item details with related study materials.
require_once __DIR__ . '/includes/bootstrap.php';
$id = safe_id($_GET['id'] ?? null);
$item = $id ? get_item($id) : null;
if (!$item) {
    http_response_code(404);
    $page_title = 'Item not found';
    require __DIR__ . '/includes/header.php';
    echo '<section class="section container"><div class="empty-state"><h1>Item not found</h1><p>It may have been removed.</p><a class="btn btn-primary" href="' . e(url('catalog.php')) . '">Return to catalog</a></div></section>';
    require __DIR__ . '/includes/footer.php';
    exit;
}
$page_title = $item['title'];
$active_page = 'catalog';
$favorite = is_favorite($id);
$related_stmt = db()->prepare('SELECT i.*, c.name AS category_name FROM items i JOIN categories c ON c.id = i.category_id WHERE i.category_id = ? AND i.id != ? AND i.is_available = 1 ORDER BY i.id DESC LIMIT 3');
$related_stmt->execute([(int)$item['category_id'], $id]);
$related_items = $related_stmt->fetchAll();
require __DIR__ . '/includes/header.php';
?>
<section class="section"><div class="container">
    <nav class="breadcrumbs" aria-label="Breadcrumb"><a href="<?= e(url('index.php')) ?>">Home</a> / <a href="<?= e(url('catalog.php')) ?>">Catalog</a> / <?= e($item['title']) ?></nav>
    <div class="detail-grid">
        <div class="detail-image"><img src="<?= e(image_path($item['image_file'])) ?>" alt="Illustration of <?= e($item['title']) ?>" width="550" height="430"></div>
        <div class="detail-copy"><span class="pill"><?= e($item['category_name']) ?></span><h1><?= e($item['title']) ?></h1><p class="detail-price"><?= money($item['price']) ?></p>
            <p class="status-text <?= (int)$item['is_available'] === 1 ? 'available' : 'unavailable' ?>"><?= (int)$item['is_available'] === 1 ? 'Available' : 'Not available' ?></p>
            <div class="detail-details"><p><strong>Condition:</strong> <?= e($item['item_condition']) ?></p><p><strong>Listed by:</strong> <?= e($item['listed_by']) ?></p></div>
            <h2>About this item</h2><p><?= nl2br(e($item['description'])) ?></p>
            <div class="detail-actions"><a class="btn btn-primary" href="<?= e(url('contact.php?item=' . $id)) ?>">Ask about this item</a>
            <?php if (is_logged_in()): ?><form method="post" action="<?= e(url('toggle_favorite.php')) ?>"><?= csrf_field() ?><input type="hidden" name="item_id" value="<?= $id ?>"><button class="btn btn-outline" type="submit"><?= $favorite ? 'Remove from favorites' : 'Save to favorites' ?></button></form>
            <?php else: ?><a class="btn btn-outline" href="<?= e(url('login.php')) ?>">Log in to save</a><?php endif; ?></div>
        </div>
    </div>
</div></section>
<?php if ($related_items): ?><section class="section section-muted"><div class="container"><div class="section-top"><div><span class="eyebrow">YOU MAY ALSO LIKE</span><h2>Similar items</h2></div></div><div class="items-grid"><?php foreach ($related_items as $item): ?><?php require __DIR__ . '/includes/item_card.php'; ?><?php endforeach; ?></div></div></section><?php endif; ?>
<?php require __DIR__ . '/includes/footer.php'; ?>
