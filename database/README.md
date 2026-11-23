# MySQL database

`studyshelf.sql` creates and fills the sample database for the catalog.

The main tables are `users`, `categories`, `items`, `favorites`, and `messages`. Foreign keys connect listings, saved items, and inquiries with the relevant records.

To set up locally, start MySQL in XAMPP, open phpMyAdmin, and import `studyshelf.sql`.

**Important:** the setup script resets the demo tables. Re-import it only when you want a fresh sample database.

For relationship explanations, see `DATABASE_DESIGN.md` in the project root.
