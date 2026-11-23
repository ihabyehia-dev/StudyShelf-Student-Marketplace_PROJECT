# Administration pages

The `admin/` folder contains the management interface for StudyShelf.

- `index.php` shows overview numbers and recent listings.
- `items.php`, `item_form.php`, and `item_delete.php` manage catalog entries.
- `categories.php` manages product categories.
- `users.php` lists registered users.
- `messages.php` shows inquiries from the contact form.

These pages load the shared `includes/bootstrap.php` file and use `require_admin()` to restrict access. Sign in using a demo administrator account from the main README before opening the admin area.
