<?php
// Home page with featured listings and category links.
require_once __DIR__ . '/includes/bootstrap.php';
$page_title = 'Find study essentials';
$active_page = 'home';
$categories = get_categories();
$latest_items = get_latest_items(6);
require __DIR__ . '/includes/header.php';
?>
<section class="hero">
    <div class="container hero-grid">
        <div class="hero-copy">
            <span class="eyebrow">MADE FOR CAMPUS LIFE</span>
            <h1>Everything you need for a better <em>study day.</em></h1>
            <p>Find textbooks, calculators, notes, and everyday study essentials in one simple place. Save your favorite items and ask us about them.</p>
            <div class="hero-actions"><a class="btn btn-primary" href="<?= e(url('catalog.php')) ?>">Explore items &rarr;</a><a class="btn btn-outline" href="<?= e(url('about.php')) ?>">How it works</a></div>
            <div class="hero-note"><span class="note-dot"></span> A university project for students, by students</div>
        </div>
        <div class="hero-art">
            <div class="decor decor-one"></div><div class="decor decor-two"></div>
            <div class="illustration-card"><img src="<?= e(url('assets/images/hero-study.svg')) ?>" alt="Illustration of books, laptop, and study supplies on a desk" width="570" height="450"></div>
        </div>
    </div>
</section>
<section class="section" aria-labelledby="category-heading">
    <div class="container">
        <div class="section-top"><div><span class="eyebrow">QUICK START</span><h2 id="category-heading">Browse by category</h2><p>Pick the type of study material you need.</p></div></div>
        <div class="category-grid">
            <?php foreach ($categories as $category): ?>
                <a class="category-tile" href="<?= e(url('catalog.php?category=' . (int)$category['id'])) ?>">
                    <span class="category-circle" aria-hidden="true"><?= e(substr($category['name'], 0, 1)) ?></span>
                    <strong><?= e($category['name']) ?></strong><small><?= (int)$category['item_count'] ?> items</small>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<section class="section section-muted" aria-labelledby="items-heading">
    <div class="container">
        <div class="section-top"><div><span class="eyebrow">CAMPUS PICKS</span><h2 id="items-heading">Recently added</h2><p>Browse a few of the items available right now.</p></div><a class="text-link" href="<?= e(url('catalog.php')) ?>">Browse all &rarr;</a></div>
        <div class="items-grid">
            <?php foreach ($latest_items as $item): ?><?php require __DIR__ . '/includes/item_card.php'; ?><?php endforeach; ?>
        </div>
        <?php if (!$latest_items): ?><p class="empty-state">No items yet. An admin can add items from the dashboard.</p><?php endif; ?>
    </div>
</section>
<section class="section"><div class="container feature-band"><div><span class="eyebrow">WHY STUDYSHELF?</span><h2>Less searching. More studying.</h2><p>Simple categories, clear item descriptions, and a quick way to ask questions about what you need.</p></div><a class="btn btn-light" href="<?= e(url('contact.php')) ?>">Send us a message</a></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
