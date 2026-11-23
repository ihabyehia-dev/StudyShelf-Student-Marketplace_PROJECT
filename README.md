# StudyShelf — Student Study Materials Catalog

A responsive **PHP and MySQL web application** for students to browse textbooks, notes, calculators, and other study supplies. Built as a CMPS246 Web Programming project at Beirut Arab University.

This is a **catalog and inquiry system**, not a payment-processing store.

## Features

**For students**
- Browse items by category, search by keyword, and sort results
- View item details, prices, descriptions, and related listings
- Register, log in, and manage a personal profile
- Save or remove favorite items
- Send questions through the contact form

**For administrators**
- View a simple dashboard
- Add, edit, hide, or delete listings
- Manage item categories
- View registered users
- Read and manage contact messages

## Technology

| Part | Technology |
| --- | --- |
| Frontend | HTML5, CSS3, vanilla JavaScript |
| Backend | PHP 8.1+ with PDO |
| Database | MySQL / MariaDB |
| Local development | XAMPP (Apache + MySQL) |

No PHP frameworks are used, so the code is easy to follow.

## Getting started on Windows (XAMPP)

1. Download this repository using **Code → Download ZIP** on GitHub, and extract it.
2. Rename the extracted folder to `CMPS246_StudyShelf`.
3. Put it inside `C:\xampp\htdocs\`, so you have `C:\xampp\htdocs\CMPS246_StudyShelf\index.php`.
4. Start **Apache** and **MySQL** in XAMPP.
5. Open `http://localhost/phpmyadmin/`, choose **Import**, and select `database/studyshelf.sql` from the project folder.
6. If your MySQL login differs from the default XAMPP settings, update `config/database.php` or the documented environment variables.
7. Open `http://localhost/CMPS246_StudyShelf/` in your browser.

**Note:** Re-importing `studyshelf.sql` deletes and recreates the demo tables. Only import it on a fresh setup or when you want to reset demo content.

### Demo accounts (local testing only)

| Role | Email | Password |
| --- | --- | --- |
| Admin | `admin@studyshelf.test` | `Admin123!` |
| Student | `student@studyshelf.test` | `Student123!` |

These are sample accounts for a local academic demo. **Do not publish the site with these credentials.**

## Code organization

```text
admin/               Admin dashboard and management pages
assets/css/          Responsive stylesheet
assets/js/           Client-side interactions and validation
assets/images/       Original project illustrations (SVG)
config/database.php  PDO database connection
database/            SQL schema and sample data
includes/            Shared page layout and PHP functions
tests/               Static project checks
index.php            Home page
catalog.php          Search, filter, and sort
item.php             Item details
register.php         Student registration
login.php            Login with PHP sessions
contact.php          Contact and inquiry form
README.md            This guide
```

## Database and security basics

The project uses five connected tables: `users`, `categories`, `items`, `favorites`, and `messages`.

Key implementation details include:
- PDO **prepared statements** for database queries
- `password_hash()` and `password_verify()` for passwords
- PHP sessions and role checks for admin-only pages
- CSRF tokens on forms that change data
- Client- and server-side form validation
- Escaped output when displaying user-provided text

See [DATABASE_DESIGN.md](DATABASE_DESIGN.md) for the tables and relationships.

## Testing

Run the static checks from the project directory, with Python and PHP available:

```bash
python tests/check_project.py
```

The script checks required files, PHP syntax, SQL structure, and illustrations. It does **not** replace checking the website manually with Apache and MySQL running.

Manual scenarios are documented in [TEST_CASES.md](TEST_CASES.md). Extra academic documentation is available in [PRESENTATION_GUIDE.md](PRESENTATION_GUIDE.md) and [SUBMISSION_CHECKLIST.md](SUBMISSION_CHECKLIST.md).

## Scope

StudyShelf is a university learning project. It has no real payments, shipping system, or production deployment. It is intended to demonstrate full-stack fundamentals rather than operate as a commercial service.
