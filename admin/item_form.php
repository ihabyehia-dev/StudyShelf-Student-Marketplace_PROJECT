<?php
require_once __DIR__ . '/../includes/bootstrap.php';
require_admin();
$id = safe_id($_GET['id'] ?? $_POST['id'] ?? 0);
$existing = $id ? get_item($id) : null;
if ($id && !$existing) { set_flash('error', 'Item not found.'); redirect('admin/items.php'); }
$page_title = $id ? 'Edit item' : 'Add item';
$categories = get_categories();
$conditions = ['New', 'Like New', 'Good', 'Fair'];
$images = available_images();
$data = [
    'title' => $existing['title'] ?? '',
    'description' => $existing['description'] ?? '',
    'price' => $existing['price'] ?? '',
    'category_id' => $existing['category_id'] ?? '',
    'item_condition' => $existing['item_condition'] ?? 'Good',
    'image_file' => $existing['image_file'] ?? 'book-blue.svg',
    'is_available' => $existing['is_available'] ?? 1
];
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    $data = [
        'title' => trim((string)($_POST['title'] ?? '')),
        'description' => trim((string)($_POST['description'] ?? '')),
        'price' => trim((string)($_POST['price'] ?? '')),
        'category_id' => safe_id($_POST['category_id'] ?? 0),
        'item_condition' => (string)($_POST['item_condition'] ?? ''),
        'image_file' => (string)($_POST['image_file'] ?? ''),
        'is_available' => isset($_POST['is_available']) ? 1 : 0
    ];
    if (strlen($data['title']) < 3 || strlen($data['title']) > 140) { $errors[] = 'Title must be between 3 and 140 characters.'; }
    if (strlen($data['description']) < 10 || strlen($data['description']) > 2000) { $errors[] = 'Description must be between 10 and 2000 characters.'; }
    if (!is_numeric($data['price']) || (float)$data['price'] < 0 || (float)$data['price'] > 9999999.99) { $errors[] = 'Enter a valid non-negative price.'; }
    if (!in_array($data['item_condition'], $conditions, true)) { $errors[] = 'Select a valid item condition.'; }
    if (!array_key_exists($data['image_file'], $images)) { $errors[] = 'Select a valid image.'; }
    $category_ids = array_map(fn($c) => (int)$c['id'], $categories);
    if (!in_array($data['category_id'], $category_ids, true)) { $errors[] = 'Choose a category.'; }
    if (!$errors) {
        if ($id) {
            $statement = db()->prepare('UPDATE items SET category_id=?, title=?, description=?, price=?, item_condition=?, image_file=?, is_available=? WHERE id=?');
            $statement->execute([$data['category_id'], $data['title'], $data['description'], $data['price'], $data['item_condition'], $data['image_file'], $data['is_available'], $id]);
            set_flash('success', 'Item updated successfully.');
        } else {
            $statement = db()->prepare('INSERT INTO items (category_id, created_by, title, description, price, item_condition, image_file, is_available) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
            $statement->execute([$data['category_id'], current_user()['id'], $data['title'], $data['description'], $data['price'], $data['item_condition'], $data['image_file'], $data['is_available']]);
            set_flash('success', 'Item added successfully.');
        }
        redirect('admin/items.php');
    }
}
require __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/admin_nav.php';
?>
<section class="section admin-section"><div class="container narrow-container"><a class="back-link" href="<?= e(url('admin/items.php')) ?>">&larr; Back to items</a><h1><?= $id ? 'Edit item' : 'Add new item' ?></h1><p class="intro-text">Complete all the required item details below.</p>
<div class="form-card">
<?php if ($errors): ?><div class="alert alert-error" role="alert"><ul><?php foreach ($errors as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
<form method="post" action="<?= e(url('admin/item_form.php' . ($id ? '?id=' . $id : ''))) ?>" data-validate="item" novalidate><?= csrf_field() ?><input type="hidden" name="id" value="<?= (int)$id ?>">
    <div class="form-group"><label for="title">Item name *</label><input id="title" name="title" value="<?= e((string)$data['title']) ?>" required minlength="3" maxlength="140"></div>
    <div class="form-group"><label for="description">Description *</label><textarea id="description" name="description" rows="5" required minlength="10" maxlength="2000"><?= e((string)$data['description']) ?></textarea></div>
    <div class="two-fields"><div class="form-group"><label for="category_id">Category *</label><select name="category_id" id="category_id" required><option value="">Choose a category</option><?php foreach ($categories as $cat): ?><option value="<?= (int)$cat['id'] ?>" <?= (int)$data['category_id'] === (int)$cat['id'] ? 'selected' : '' ?>><?= e($cat['name']) ?></option><?php endforeach; ?></select></div>
    <div class="form-group"><label for="price">Price (USD) *</label><input type="number" name="price" id="price" value="<?= e((string)$data['price']) ?>" step="0.01" min="0" max="9999999.99" required></div></div>
    <div class="two-fields"><div class="form-group"><label for="item_condition">Condition *</label><select name="item_condition" id="item_condition"><?php foreach ($conditions as $condition): ?><option value="<?= e($condition) ?>" <?= $data['item_condition'] === $condition ? 'selected' : '' ?>><?= e($condition) ?></option><?php endforeach; ?></select></div>
    <div class="form-group"><label for="image_file">Illustration *</label><select name="image_file" id="image_file"><?php foreach ($images as $filename => $label): ?><option value="<?= e($filename) ?>" <?= $data['image_file'] === $filename ? 'selected' : '' ?>><?= e($label) ?></option><?php endforeach; ?></select></div></div>
    <label class="checkbox-label"><input type="checkbox" name="is_available" value="1" <?= (int)$data['is_available'] === 1 ? 'checked' : '' ?>> Item is available on the public website</label>
    <div class="client-errors" data-form-errors aria-live="polite"></div><div class="form-actions"><button class="btn btn-primary" type="submit"><?= $id ? 'Save changes' : 'Add item' ?></button><a class="btn btn-outline" href="<?= e(url('admin/items.php')) ?>">Cancel</a></div>
</form></div></div></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
