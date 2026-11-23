<?php
// Admin list of registered student accounts.
require_once __DIR__ . '/../includes/bootstrap.php';
require_admin();
$page_title = 'Registered users';
$users = db()->query('SELECT u.id, u.full_name, u.email, u.role, u.created_at, (SELECT COUNT(*) FROM favorites f WHERE f.user_id = u.id) AS saved_count FROM users u ORDER BY u.id DESC')->fetchAll();
require __DIR__ . '/../includes/header.php';
require __DIR__ . '/../includes/admin_nav.php';
?>
<section class="section admin-section"><div class="container"><div class="section-top"><div><span class="eyebrow">ACCOUNT MANAGEMENT</span><h1>Registered users</h1><p>View registered student and admin accounts.</p></div></div><div class="admin-panel"><div class="table-scroll"><table><thead><tr><th scope="col">Name</th><th scope="col">Email</th><th scope="col">Role</th><th scope="col">Favorites</th><th scope="col">Registered</th></tr></thead><tbody><?php foreach ($users as $user): ?><tr><td><?= e($user['full_name']) ?></td><td><?= e($user['email']) ?></td><td><?= e(ucfirst($user['role'])) ?></td><td><?= (int)$user['saved_count'] ?></td><td><?= e(date('M j, Y', strtotime($user['created_at']))) ?></td></tr><?php endforeach; ?></tbody></table></div></div></div></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
