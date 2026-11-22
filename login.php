<?php
require_once __DIR__ . '/includes/bootstrap.php';
if (is_logged_in()) { redirect('profile.php'); }
$page_title = 'Log in';
$email = trim((string)($_POST['email'] ?? ''));
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    $password = (string)($_POST['password'] ?? '');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
        $error = 'Please enter a valid email and password.';
    } else {
        $stmt = db()->prepare('SELECT id, full_name, email, role, password_hash FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        if ($user && password_verify($password, $user['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['user'] = ['id' => (int)$user['id'], 'name' => $user['full_name'], 'email' => $user['email'], 'role' => $user['role']];
            set_flash('success', 'Logged in successfully. Welcome back!');
            redirect($user['role'] === 'admin' ? 'admin/index.php' : 'profile.php');
        }
        $error = 'Incorrect email or password.';
    }
}
require __DIR__ . '/includes/header.php';
?>
<section class="section auth-section"><div class="container"><div class="auth-card"><span class="eyebrow">NICE TO SEE YOU</span><h1>Log in</h1><p>Access your saved items and account details.</p>
    <?php if ($error): ?><div class="alert alert-error" role="alert"><?= e($error) ?></div><?php endif; ?>
    <form method="post" action="<?= e(url('login.php')) ?>" data-validate="login" novalidate><?= csrf_field() ?>
        <div class="form-group"><label for="email">Email address</label><input type="email" id="email" name="email" value="<?= e($email) ?>" required autocomplete="email"></div>
        <div class="form-group"><label for="password">Password</label><input type="password" id="password" name="password" required autocomplete="current-password"></div>
        <div class="client-errors" data-form-errors aria-live="polite"></div><button class="btn btn-primary btn-full" type="submit">Log in</button>
    </form><p class="auth-footer">New to StudyShelf? <a href="<?= e(url('register.php')) ?>">Create an account</a></p>
</div></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
