<!-- Shared template for a catalog item card. -->
<?php // Requires $item array from the database. ?>
<article class="item-card">
    <a href="<?= e(url('item.php?id=' . (int) $item['id'])) ?>" class="item-image-link">
        <img src="<?= e(image_path($item['image_file'])) ?>" alt="Illustration for <?= e($item['title']) ?>" loading="lazy" width="340" height="230">
    </a>
    <div class="item-card-body">
        <div class="card-meta"><span class="pill"><?= e($item['category_name']) ?></span><span><?= e($item['item_condition']) ?></span></div>
        <h3><a href="<?= e(url('item.php?id=' . (int) $item['id'])) ?>"><?= e($item['title']) ?></a></h3>
        <p><?= e((strlen($item['description']) > 90 ? substr($item['description'], 0, 87) . '...' : $item['description'])) ?></p>
        <div class="card-bottom"><strong class="price"><?= money($item['price']) ?></strong><a class="text-link" href="<?= e(url('item.php?id=' . (int) $item['id'])) ?>">View details &rarr;</a></div>
    </div>
</article>
