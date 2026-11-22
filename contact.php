<?php
require_once __DIR__ . '/includes/bootstrap.php';
$page_title = 'Contact';
$active_page = 'contact';
$user = current_user();
$item_id = safe_id($_POST['item_id'] ?? $_GET['item'] ?? 0);
$item = $item_id ? get_item($item_id) : null;
if (!$item) { $item_id = 0; }
$name = trim((string)($_POST['sender_name'] ?? $user['name'] ?? ''));
$email = trim((string)($_POST['sender_email'] ?? $user['email'] ?? ''));
$subject = trim((string)($_POST['subject'] ?? ($item ? 'Question about ' . $item['title'] : '')));
$message = trim((string)($_POST['message'] ?? ''));
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf();
    if (strlen($name) < 2 || strlen($name) > 100) { $errors[] = 'Enter a name between 2 and 100 characters.'; }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 150) { $errors[] = 'Enter a valid email address.'; }
    if (strlen($subject) < 3 || strlen($subject) > 160) { $errors[] = 'The subject must be 3-160 characters.'; }
    if (strlen($message) < 10 || strlen($message) > 2000) { $errors[] = 'The message must be 10-2000 characters.'; }
    if (!$errors) {
        $statement = db()->prepare('INSERT INTO messages (user_id, item_id, sender_name, sender_email, subject, message) VALUES (?, ?, ?, ?, ?, ?)');
        $statement->execute([$user['id'] ?? null, $item_id ?: null, $name, $email, $subject, $message]);
        set_flash('success', 'Thanks! Your message was saved and can be seen by the admin.');
        redirect('contact.php');
    }
}
require __DIR__ . '/includes/header.php';
?>
<section class="page-intro"><div class="container"><span class="eyebrow">SAY HELLO</span><h1>Contact us</h1><p>Have a question about an item? Send us a message using the form below.</p></div></section>
<section class="section"><div class="container contact-grid"><div><span class="eyebrow">WE ARE HERE TO HELP</span><h2>We would love to hear from you.</h2><p>Fill in the form and your message will be stored in the database for the website administrator to read.</p><div class="contact-note"><strong>StudyShelf</strong><p>Beirut, Lebanon</p><p>University demonstration project</p></div></div><div class="form-card">
    <?php if ($errors): ?><div class="alert alert-error" role="alert"><ul><?php foreach ($errors as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
    <form method="post" data-validate="contact" action="<?= e(url('contact.php')) ?>" novalidate><?= csrf_field() ?><input type="hidden" name="item_id" value="<?= (int)$item_id ?>">
        <div class="two-fields"><div class="form-group"><label for="sender_name">Full name *</label><input id="sender_name" name="sender_name" value="<?= e($name) ?>" required minlength="2" maxlength="100" autocomplete="name"></div><div class="form-group"><label for="sender_email">Email *</label><input id="sender_email" name="sender_email" type="email" value="<?= e($email) ?>" required maxlength="150" autocomplete="email"></div></div>
        <div class="form-group"><label for="subject">Subject *</label><input id="subject" name="subject" value="<?= e($subject) ?>" required minlength="3" maxlength="160"></div>
        <div class="form-group"><label for="message">Message *</label><textarea id="message" name="message" rows="6" required minlength="10" maxlength="2000" placeholder="Write your question here..."><?= e($message) ?></textarea></div>
        <p class="form-help">* Required fields. This demo stores messages but does not send email.</p><div class="client-errors" data-form-errors aria-live="polite"></div><button class="btn btn-primary" type="submit">Send message</button>
    </form>
</div></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
