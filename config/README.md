# Database configuration

`database.php` defines the MySQL connection and the shared `db()` function using PHP PDO.

For a local XAMPP setup, the default database is `studyshelf`. Connection values may be supplied with the environment variables `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, and `DB_PASS`.

Import `database/studyshelf.sql` before running the website. Do not store real passwords or production credentials in this repository.
