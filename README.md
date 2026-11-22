# StudyShelf - CMPS246 Web Programming Final Project

**University:** Beirut Arab University (BAU)  
**Course:** CMPS246 - Web Programming  
**Semester:** Fall 2026/2027  
**Project topic:** StudyShelf - Student Book Exchange / Study Materials Catalog  
**Student:** Ihab Yehia (update team details below before submission)

## 1. About the project

StudyShelf is a simple and responsive web application where students can browse study-related items, register or log in, save favorites, and send questions to the admin. The admin can add, edit, and delete items; manage categories; view registered users; and read contact messages. This is a **university demonstration**, not a real store or payment system.

### Technology used

- Front end: HTML5, external CSS3, and plain JavaScript
- Back end: plain PHP 8.1 or newer (no frameworks)
- Database: MySQL 8+ or MariaDB 10.4+
- Local server: XAMPP (Apache and MySQL)
- Integrations: None. Third-party REST APIs are optional in the course instructions.

## 2. Installation with XAMPP (Windows)

1. Download and install XAMPP (with Apache, MySQL/MariaDB, PHP, and phpMyAdmin).
2. Extract the ZIP and copy the **CMPS246_StudyShelf** folder to `C:\xampp\htdocs\CMPS246_StudyShelf`.
3. Open the XAMPP Control Panel and start **Apache** and **MySQL**.
4. In the browser, open `http://localhost/phpmyadmin/`.
5. Go to **Import**, select `database/studyshelf.sql`, then click **Import/Go**. It creates the database and sample content automatically.
6. Check `config/database.php` if your MySQL username/password are not the standard local XAMPP values (`root` / empty password).
7. Open `http://localhost/CMPS246_StudyShelf/` to use the website.
8. To open the dashboard, log in as the sample admin account below and click **Admin**.

**Important:** Importing `studyshelf.sql` again deletes and recreates all tables. You will lose any data entered after the previous import. Import it only for the initial setup or when you deliberately want to reset the demo.

### Test accounts

| Role | Email | Password |
| --- | --- | --- |
| Administrator | `admin@studyshelf.test` | `Admin123!` |
| Student | `student@studyshelf.test` | `Student123!` |

The passwords are intentionally simple **test credentials only**. Do not use these accounts or passwords on a public server. In production you must create different accounts and secure the configuration.

## 3. Available pages

| Page | File | Purpose |
| --- | --- | --- |
| Home | `index.php` | Main landing page, categories, latest items |
| Browse | `catalog.php` | Search, filter by category, sort by price/date |
| Details | `item.php` | Description, condition, price, related items, save item |
| About | `about.php` | Project overview and how it works |
| Contact | `contact.php` | Form that stores messages in MySQL |
| Register | `register.php` | New account and password hashing |
| Login/logout | `login.php` and `logout.php` | PHP session authentication |
| Account | `profile.php` | User details, update name |
| Favorites | `favorites.php`, `toggle_favorite.php` | Saved items for each logged-in user |
| Admin dashboard | `admin/index.php` | Counts and latest item listing |
| Admin items | `admin/items.php`, `admin/item_form.php`, `admin/item_delete.php` | Create/read/update/delete items |
| Admin categories | `admin/categories.php` | Create/read/update/delete categories (deletion protected) |
| Admin messages | `admin/messages.php` | Read, mark as read, delete messages |
| Admin users | `admin/users.php` | View registered accounts |

## 4. Project directory

```text
CMPS246_StudyShelf/
|-- index.php, catalog.php, item.php, about.php, contact.php
|-- register.php, login.php, logout.php, profile.php, favorites.php
|-- toggle_favorite.php
|-- admin/
|   |-- index.php, items.php, item_form.php, item_delete.php
|   |-- categories.php, messages.php, users.php
|-- config/database.php
|-- includes/bootstrap.php, functions.php, header.php
|-- includes/footer.php, item_card.php, admin_nav.php
|-- database/studyshelf.sql
|-- assets/css/style.css
|-- assets/js/main.js
|-- assets/images/*.svg
|-- tests/check_project.py
|-- README.md, DATABASE_DESIGN.md, TEST_CASES.md
|-- PRESENTATION_GUIDE.md, SUBMISSION_CHECKLIST.md
```

## 5. Database model

The database has **five related tables**:

- `users` - accounts and role (`student` or `admin`)
- `categories` - category information
- `items` - listing information, linked to `categories` and `users`
- `favorites` - many-to-many relationship between students and items
- `messages` - contact form submissions, optionally linked to a user or item

See `DATABASE_DESIGN.md` for the relationship diagram and field descriptions. All forms that write to the database use PHP prepared statements, a CSRF token, and server-side input validation.

## 6. Client- and server-side validation

**JavaScript** checks required fields, formats, and matching passwords before submitting. **PHP** repeats the checks on the server because JavaScript can be disabled or bypassed. Registration stores passwords with `password_hash()`; login verifies with `password_verify()` and creates a PHP session. Admin pages check the session role. User-supplied text is escaped when displayed to prevent HTML injection.

## 7. Test the website before submission

The file `TEST_CASES.md` contains detailed test steps. At minimum, verify:

1. Home page, images, and navigation work at phone and desktop widths.
2. Category filtering, search, sorting, item details and related items work.
3. Register a new student, log out, then log in again.
4. Attempt incorrect login; an error message should appear.
5. A student cannot access `/admin/index.php`.
6. Save and unsave an item; favorites update correctly.
7. Send a contact message; it appears on the admin Messages page.
8. As admin, add/edit/delete an item and a category. Check that category deletion is blocked while it contains items.
9. Check there are no browser console errors or broken images.
10. Inspect keyboard navigation, form labels, contrast, and small-screen layouts.

### Automated syntax and file checks

If Python and PHP are available, from the project directory run:

```bash
python tests/check_project.py
```

This checks the PHP syntax and that expected images/files exist. It does **not** replace a full browser and MySQL integration test.

## 8. Team contribution plan (fill in with real names)

The course allows up to three team members and requires each to explain their portion. Register the actual team and topic with the Lab TA in Week 1.

| Member | Name | Proposed responsibility |
| --- | --- | --- |
| 1 | Ihab Yehia | Database, PHP integration, testing, and overall coordination |
| 2 | Add name if applicable | Front-end HTML/CSS, responsive design |
| 3 | Add name if applicable | JavaScript, validation, contact/admin pages |

**If working alone:** Keep only Member 1 and make sure your Lab TA permits a one-person team. Do not claim teammates or contributions that did not happen. Update this table after your actual team divides the work.

## 9. Suggested three-week plan

- **Week 1:** Choose/register topic and team; create database SQL, keys, constraints, and main responsive pages. Show these in the first lab checkpoint.
- **Week 2:** Show registration/login with PHP sessions, items/categories from MySQL, and the responsive admin page.
- **Week 3:** Finish search/contact, client/server validation, optional admin dashboard, accessibility, testing, README, and final live demo.

The original assignment sets the final submission in the **last lab week of Week 3**. Confirm the exact date with the Lab TA.

## 10. Before submitting

- Update the team names and responsibilities honestly.
- Demonstrate the site on **your own XAMPP computer** and capture screenshots if your TA wants them.
- Go through `TEST_CASES.md` and mark the results.
- Keep the source files and `database/studyshelf.sql` inside the project ZIP.
- Be ready to explain any function, SQL query, CSS rule, or JavaScript event handler.

All illustrations are original SVG drawings made for this project; they do not need third-party licenses. No external CSS frameworks, image CDN, or external APIs are required.

**Note:** No one can guarantee a particular mark. Final grading depends on how the working application performs during the TA's checkpoints and live demonstration.
