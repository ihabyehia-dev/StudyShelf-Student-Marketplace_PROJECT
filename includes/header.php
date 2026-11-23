<?php
// Shared page header and navigation layout.
$page_title = $page_title ?? 'StudyShelf - Campus Study Market';
$active_page = $active_page ?? '';
$flash_message = take_flash();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="StudyShelf - a student-run demo website for finding study materials on campus.">
    <title><?= e($page_title) ?> | StudyShelf</title>
    <link rel="icon" href="<?= e(url('assets/images/favicon.svg')) ?>" type="image/svg+xml">
    <link rel="stylesheet" href="<?= e(url('assets/css/style.css')) ?>">
    <script defer src="<?= e(url('assets/js/main.js')) ?>"></script>
</head>
<body>
<a class="skip-link" href="#main-content">Skip to content</a>
<header class="site-header">
    <div class="container header-inner">
        <a class="brand" href="<?= e(url('index.php')) ?>" aria-label="StudyShelf home">
            <img src="<?= e(url('assets/images/logo.svg')) ?>" alt="StudyShelf logo" width="39" height="39">
            <span>Study<span class="brand-accent">Shelf</span></span>
        </a>
        <button class="menu-toggle" type="button" data-menu-button aria-label="Open navigation" aria-controls="main-navigation" aria-expanded="false"><span></span><span></span><span></span></button>
        <nav class="main-nav" id="main-navigation" aria-label="Main navigation" data-menu>
            <a class="<?= $active_page === 'home' ? 'active' : '' ?>" href="<?= e(url('index.php')) ?>">Home</a>
            <a class="<?= $active_page === 'catalog' ? 'active' : '' ?>" href="<?= e(url('catalog.php')) ?>">Browse Items</a>
            <a class="<?= $active_page === 'about' ? 'active' : '' ?>" href="<?= e(url('about.php')) ?>">About</a>
            <a class="<?= $active_page === 'contact' ? 'active' : '' ?>" href="<?= e(url('contact.php')) ?>">Contact</a>
            <?php if (is_logged_in()): ?>
                <a href="<?= e(url('favorites.php')) ?>">Favorites</a>
                <?php if (is_admin()): ?><a href="<?= e(url('admin/index.php')) ?>">Admin</a><?php endif; ?>
                <a href="<?= e(url('profile.php')) ?>">My Account</a>
                <form class="logout-form" method="post" action="<?= e(url('logout.php')) ?>">
                    <?= csrf_field() ?>
                    <button type="submit" class="nav-logout">Log out</button>
                </form>
            <?php else: ?>
                <a href="<?= e(url('login.php')) ?>">Log in</a>
                <a href="<?= e(url('register.php')) ?>" class="nav-cta">Sign up</a>
            <?php endif; ?>
        </nav>
    </div>
</header>
<?php if ($flash_message): ?>
    <div class="container flash-wrapper"><div class="alert alert-<?= e($flash_message['type']) ?>" role="status"><?= e($flash_message['message']) ?></div></div>
<?php endif; ?>
<main id="main-content">
