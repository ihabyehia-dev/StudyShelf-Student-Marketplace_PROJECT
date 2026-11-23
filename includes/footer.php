<!-- Shared site footer and page closing markup. -->
</main>
<footer class="site-footer">
    <div class="container footer-grid">
        <div>
            <a class="brand footer-brand" href="<?= e(url('index.php')) ?>">
                <img src="<?= e(url('assets/images/logo.svg')) ?>" alt="StudyShelf logo" width="37" height="37">
                <span>Study<span class="brand-accent">Shelf</span></span>
            </a>
            <p>A simple campus marketplace for study essentials. Made as a CMPS246 university demo project.</p>
        </div>
        <div><h3>Explore</h3><a href="<?= e(url('catalog.php')) ?>">Browse items</a><a href="<?= e(url('about.php')) ?>">About us</a><a href="<?= e(url('contact.php')) ?>">Contact</a></div>
        <div><h3>Your account</h3><a href="<?= e(url('login.php')) ?>">Login</a><a href="<?= e(url('register.php')) ?>">Register</a><a href="<?= e(url('favorites.php')) ?>">Saved items</a></div>
    </div>
    <div class="container footer-bottom">&copy; <?= date('Y') ?> StudyShelf. Educational project - sample listings, no real purchases.</div>
</footer>
</body>
</html>
