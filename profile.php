<?php
// Student profile and account information.
require_once __DIR__ . '/includes/bootstrap.php';
require_login();
$page_title = 'My account';
$profile = db()->prepare('SELECT id, full_name, email, role, created_at FROM users WHERE id = ?');
$profile->execute([current_user()['id']]);
$user = $profile->fetch();
if (!$user) { unset($_SESSION['user']); redirect('login.php'); }
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    $name = trim((string)($_POST['full_name'] ?? ''));
    if (strlen($name) < 2 || strlen($name) > 100) { $errors[] = 'Name must be 2-100 characters long.'; }
    if (!$errors) {
        $stmt = db()->prepare('UPDATE users SET full_name = ? WHERE id = ?');
        $stmt->execute([$name, $user['id']]);
        $_SESSION['user']['name'] = $name;
        set_flash('success', 'Your name was updated.');
        redirect('profile.php');
    }
}
$saved_stmt = db()->prepare('SELECT COUNT(*) FROM favorites WHERE user_id = ?');
$saved_stmt->execute([$user['id']]);
$saved_count = (int)$saved_stmt->fetchColumn();
require __DIR__ . '/includes/header.php';
?>
<section class="page-intro"><div class="container"><span class="eyebrow">MY STUDYSHELF</span><h1>Hello, <?= e($user['full_name']) ?></h1><p>Manage your basic account details and saved items.</p></div></section>
<section class="section"><div class="container profile-grid"><div class="form-card"><h2>Account details</h2><?php if ($errors): ?><div class="alert alert-error" role="alert"><?= e(implode(' ', $errors)) ?></div><?php endif; ?>
<form method="post" action="<?= e(url('profile.php')) ?>"><?= csrf_field() ?><div class="form-group"><label for="full_name">Full name</label><input id="full_name" name="full_name" value="<?= e($user['full_name']) ?>" required maxlength="100"></div><div class="form-group"><label for="account_email">Email address</label><input id="account_email" value="<?= e($user['email']) ?>" disabled><small>Email cannot be changed in this demo.</small></div><div class="form-group"><label>Account type</label><p class="pill inline-pill"><?= e(ucfirst($user['role'])) ?></p></div><button class="btn btn-primary" type="submit">Save changes</button></form></div>
<div class="profile-summary"><h2>Your account</h2><p>You have <strong><?= $saved_count ?></strong> saved item<?= $saved_count === 1 ? '' : 's' ?>.</p><a class="btn btn-outline" href="<?= e(url('favorites.php')) ?>">View favorites</a><?php if (is_admin()): ?><hr><p>Admin access is enabled for this account.</p><a class="btn btn-primary" href="<?= e(url('admin/index.php')) ?>">Open admin dashboard</a><?php endif; ?></div></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
