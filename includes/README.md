# Shared PHP components

These PHP files are reused across public pages and the admin interface.

- `bootstrap.php` starts the session, loads database settings and common functions, and defines the application base URL.
- `functions.php` provides helpers for security, validation, and displaying data.
- `header.php` and `footer.php` contain shared page layout.
- `admin_nav.php` contains admin navigation links.
- `item_card.php` displays individual catalog listings.

A page normally loads `bootstrap.php` before calling helper functions or querying the database.
