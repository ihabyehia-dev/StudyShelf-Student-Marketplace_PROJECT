<?php
require_once __DIR__ . '/../includes/bootstrap.php';
require_admin();
$page_title = 'Manage categories';
$edit_id = safe_id($_GET['edit'] ?? 0);
$editing = null;
if ($edit_id) {
    $stmt = db()->prepare('SELECT * FROM categories WHERE id = ?');
    $stmt->execute([$edit_id]);
    $editing = $stmt->fetch() ?: null;
}
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    $action = (string)($_POST['action'] ?? '');
    $posted_id = safe_id($_POST['id'] ?? 0);
    if ($action === 'delete' && $posted_id) {
        $check = db()->prepare('SELECT COUNT(*) FROM items WHERE category_id = ?');
        $check->execute([$posted_id]);
        if ((int)$check->fetchColumn() > 0) {
            set_flash('error', 'You cannot delete a category that still contains items. Move or delete those items first.');
        } else {
            $stmt = db()->prepare('DELETE FROM categories WHERE id = ?');
            $stmt->execute([$posted_id]);
            set_flash('success', 'Category deleted.');
        }
        redirect('admin/categories.php');
    }
    if ($action === 'save') {
        $name = trim((string)($_POST['name'] ?? ''));
        $description = trim((string)($_POST['description'] ?? ''));
        if (strlen($name) < 2 || strlen($name) > 80) { $errors[] = 'Name must be 2-80 characters.'; }
        if (strlen($description) > 255) { $errors[] = 'Description must be under 256 characters.'; }
        if (!$errors) {
            try {
                if ($posted_id) {
                    $stmt = db()->prepare('UPDATE categories SET name = ?, description = ? WHERE id = ?');
                    $stmt->execute([$name, $description, $posted_id]);
                    set_flash('success', 'Category updated.');
                } else {
                    $stmt = db()->prepare('INSERT INTO categories (name, description) VALUES (?, ?)');
                    $stmt->execute([$name, $description]);
                    set_flash('success', 'Category added.');
                }
                redirect('admin/categories.php');
            } catch (PDOException $exception) {
                $errors[] = 'This category name may already exist.';
            }
        }
        $editing = ['id' => $posted_id, 'name' => $name, 'description' => $description];
    }
}
$categories = get_categories();
require __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/admin_nav.php';
?>
<section class="section admin-section"><div class="container"><div class="section-top"><div><span class="eyebrow">CATEGORIES MANAGEMENT</span><h1>Manage categories</h1><p>Create and edit categories used by item listings.</p></div></div>
<div class="admin-two-column"><div class="form-card"><h2><?= $editing ? 'Edit category' : 'Add category' ?></h2><?php if ($errors): ?><div class="alert alert-error" role="alert"><ul><?php foreach ($errors as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
<form method="post" action="<?= e(url('admin/categories.php')) ?>"><?= csrf_field() ?><input type="hidden" name="action" value="save"><input type="hidden" name="id" value="<?= (int)($editing['id'] ?? 0) ?>"><div class="form-group"><label for="name">Category name *</label><input id="name" name="name" required minlength="2" maxlength="80" value="<?= e($editing['name'] ?? '') ?>"></div><div class="form-group"><label for="description">Description</label><textarea id="description" name="description" maxlength="255" rows="3"><?= e($editing['description'] ?? '') ?></textarea></div><button class="btn btn-primary" type="submit"><?= $editing ? 'Save category' : 'Add category' ?></button><?php if ($editing): ?> <a class="btn btn-outline" href="<?= e(url('admin/categories.php')) ?>">Cancel</a><?php endif; ?></form></div>
<div class="admin-panel"><div class="table-scroll"><table><thead><tr><th scope="col">Category</th><th scope="col">Items</th><th scope="col">Actions</th></tr></thead><tbody><?php foreach ($categories as $category): ?><tr><td><strong><?= e($category['name']) ?></strong><br><small><?= e($category['description']) ?></small></td><td><?= (int)$category['item_count'] ?></td><td class="actions-cell"><a class="btn btn-small btn-outline" href="<?= e(url('admin/categories.php?edit=' . (int)$category['id'])) ?>">Edit</a><form method="post" action="<?= e(url('admin/categories.php')) ?>" data-confirm="Delete this empty category?"><?= csrf_field() ?><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int)$category['id'] ?>"><button type="submit" class="btn btn-small btn-danger" <?= (int)$category['item_count'] > 0 ? 'disabled title="Remove its items first"' : '' ?>>Delete</button></form></td></tr><?php endforeach; ?></tbody></table></div></div></div>
</div></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
