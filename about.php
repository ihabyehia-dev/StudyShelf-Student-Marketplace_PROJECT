<?php
require_once __DIR__ . '/includes/bootstrap.php';
$page_title = 'About us';
$active_page = 'about';
require __DIR__ . '/includes/header.php';
?>
<section class="page-intro"><div class="container"><span class="eyebrow">OUR STORY</span><h1>Made for students, by students</h1><p>StudyShelf is a small university web project that makes browsing study materials easier.</p></div></section>
<section class="section"><div class="container about-grid"><div><img class="about-illustration" src="<?= e(url('assets/images/about-campus.svg')) ?>" alt="Illustration of a campus building with books and a backpack" width="500" height="390"></div><div><span class="eyebrow">WHO WE ARE</span><h2>A simple idea for campus life</h2><p>Sometimes students need a textbook, calculator, or notebook without spending hours looking for it. StudyShelf organizes sample study products into categories and lets you search and save items.</p><p>This is an educational demonstration created for CMPS246 Web Programming using HTML, CSS, JavaScript, PHP, and MySQL.</p><a class="btn btn-primary" href="<?= e(url('catalog.php')) ?>">Browse items</a></div></div></section>
<section class="section section-muted"><div class="container"><div class="section-top"><div><span class="eyebrow">THREE SIMPLE STEPS</span><h2>How the website works</h2></div></div><div class="steps-grid"><div class="step"><span>01</span><h3>Explore</h3><p>Use search and categories to find what you need.</p></div><div class="step"><span>02</span><h3>Save</h3><p>Create an account and bookmark your favorites.</p></div><div class="step"><span>03</span><h3>Ask</h3><p>Send a message to ask about any item you like.</p></div></div></div></section>
<?php require __DIR__ . '/includes/footer.php'; ?>
