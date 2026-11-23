<?php
// Catalog results with category filters, keyword search and sorting.
require_once __DIR__ . '/includes/bootstrap.php';
$page_title = 'Browse items';
$active_page = 'catalog';
$categories = get_categories();
$search = trim((string)($_GET['q'] ?? ''));
$category_id = safe_id($_GET['category'] ?? 0);
$sort = (string)($_GET['sort'] ?? 'newest');
$sort_options = ['newest' => 'Newest first', 'price_low' => 'Price: low to high', 'price_high' => 'Price: high to low'];
if (!array_key_exists($sort, $sort_options)) { $sort = 'newest'; }
$where = ['i.is_available = 1'];
$params = [];
if ($search !== '') {
    $where[] = '(i.title LIKE :search_title OR i.description LIKE :search_description)';
    $params['search_title'] = '%' . $search . '%';
    $params['search_description'] = '%' . $search . '%';
}
if ($category_id > 0) {
    $where[] = 'i.category_id = :category_id';
    $params['category_id'] = $category_id;
}
$order_sql = match ($sort) {
    'price_low' => 'i.price ASC, i.id DESC',
    'price_high' => 'i.price DESC, i.id DESC',
    default => 'i.created_at DESC, i.id DESC'
};
$sql = 'SELECT i.*, c.name AS category_name FROM items i JOIN categories c ON c.id = i.category_id WHERE '
    . implode(' AND ', $where) . ' ORDER BY ' . $order_sql;
$statement = db()->prepare($sql);
$statement->execute($params);
$items = $statement->fetchAll();
require __DIR__ . '/includes/header.php';
?>
<section class="page-intro"><div class="container"><span class="eyebrow">STUDYSHELF MARKET</span><h1>Browse study essentials</h1><p>Search by name, explore categories, or sort by price.</p></div></section>
<section class="section"><div class="container">
    <form class="filter-panel" method="get" action="<?= e(url('catalog.php')) ?>" role="search">
        <div class="form-group filter-search"><label for="q">Search items</label><input type="search" id="q" name="q" value="<?= e($search) ?>" maxlength="100" placeholder="Try Java, notebook, calculator..."></div>
        <div class="form-group"><label for="category">Category</label><select id="category" name="category"><option value="">All categories</option><?php foreach ($categories as $c): ?><option value="<?= (int)$c['id'] ?>" <?= $category_id === (int)$c['id'] ? 'selected' : '' ?>><?= e($c['name']) ?></option><?php endforeach; ?></select></div>
        <div class="form-group"><label for="sort">Sort by</label><select id="sort" name="sort"><?php foreach ($sort_options as $key => $label): ?><option value="<?= e($key) ?>" <?= $sort === $key ? 'selected' : '' ?>><?= e($label) ?></option><?php endforeach; ?></select></div>
        <button class="btn btn-primary filter-button" type="submit">Apply filters</button>
    </form>
    <div class="results-line"><strong><?= count($items) ?> item<?= count($items) === 1 ? '' : 's' ?> found</strong><?php if ($search !== '' || $category_id): ?><a href="<?= e(url('catalog.php')) ?>">Clear filters</a><?php endif; ?></div>
    <?php if ($items): ?><div class="items-grid"><?php foreach ($items as $item): ?><?php require __DIR__ . '/includes/item_card.php'; ?><?php endforeach; ?></div>
    <?php else: ?><div class="empty-state"><h2>No matching items</h2><p>Try a shorter search or a different category.</p><a class="btn btn-outline" href="<?= e(url('catalog.php')) ?>">See all items</a></div><?php endif; ?>
</div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
