<?php
require_once __DIR__ . '/includes/bootstrap.php';
if (is_logged_in()) { redirect('profile.php'); }
$page_title = 'Create an account';
$name = trim((string)($_POST['name'] ?? ''));
$email = trim((string)($_POST['email'] ?? ''));
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    $password = (string)($_POST['password'] ?? '');
    $confirm = (string)($_POST['confirm_password'] ?? '');
    if (strlen($name) < 2 || strlen($name) > 100) { $errors[] = 'Name must have 2-100 characters.'; }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 150) { $errors[] = 'Enter a valid email address.'; }
    if (strlen($password) < 8) { $errors[] = 'Password must contain at least 8 characters.'; }
    if ($password !== $confirm) { $errors[] = 'Passwords do not match.'; }
    if (!$errors) {
        $check = db()->prepare('SELECT id FROM users WHERE email = ?');
        $check->execute([$email]);
        if ($check->fetch()) { $errors[] = 'This email is already registered.'; }
    }
    if (!$errors) {
        try {
            $stmt = db()->prepare('INSERT INTO users (full_name, email, password_hash, role) VALUES (?, ?, ?, ?)');
            $stmt->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT), 'student']);
            session_regenerate_id(true);
            $_SESSION['user'] = ['id' => (int)db()->lastInsertId(), 'name' => $name, 'email' => $email, 'role' => 'student'];
            set_flash('success', 'Welcome to StudyShelf! Your account is ready.');
            redirect('profile.php');
        } catch (PDOException $exception) {
            $errors[] = 'Could not create your account. Check the information and try again.';
        }
    }
}
require __DIR__ . '/includes/header.php';
?>
<section class="section auth-section"><div class="container"><div class="auth-card"><span class="eyebrow">WELCOME TO STUDYSHELF</span><h1>Create your account</h1><p>Register to save favorite study materials.</p>
    <?php if ($errors): ?><div class="alert alert-error" role="alert"><ul><?php foreach ($errors as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
    <form method="post" action="<?= e(url('register.php')) ?>" data-validate="register" novalidate><?= csrf_field() ?>
        <div class="form-group"><label for="name">Full name *</label><input id="name" name="name" value="<?= e($name) ?>" required minlength="2" maxlength="100" autocomplete="name"></div>
        <div class="form-group"><label for="email">Email *</label><input type="email" id="email" name="email" value="<?= e($email) ?>" required maxlength="150" autocomplete="email"></div>
        <div class="form-group"><label for="password">Password *</label><input type="password" id="password" name="password" required minlength="8" autocomplete="new-password"><small>At least 8 characters.</small></div>
        <div class="form-group"><label for="confirm_password">Confirm password *</label><input type="password" id="confirm_password" name="confirm_password" required autocomplete="new-password"></div>
        <div class="client-errors" data-form-errors aria-live="polite"></div><button class="btn btn-primary btn-full" type="submit">Create account</button>
    </form><p class="auth-footer">Already have an account? <a href="<?= e(url('login.php')) ?>">Log in</a></p>
</div></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
