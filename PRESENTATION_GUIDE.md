# Live demo guide - CMPS246 StudyShelf

This is a speaking outline, not a script you must memorize. Be ready to explain every file and query.

## 1. Introduction (about 20 seconds)

> Our project is called StudyShelf. It is a small web application for students to browse study items, create an account, save favorites, and contact the admin. We built it using HTML, CSS, JavaScript, PHP, and MySQL.

## 2. Database explanation (about 50 seconds)

Show phpMyAdmin and explain the five tables: users, categories, items, favorites, and messages. Show the primary keys, foreign keys, unique email constraint, item price check, and relationships. Explain why favorites needs two foreign keys and a composite key.

## 3. Public website demo (about 60 seconds)

- Open the Home page and resize browser to phone width.
- Open Browse and search for `Java`.
- Filter by `Textbooks`, change price sort, and open an item.
- Show the Contact form and a validation error.

## 4. Account demo (about 50 seconds)

- Log in as the demo student.
- Save an item, open Favorites, then remove it.
- Open My Account and show the user data.
- Explain PHP sessions and password hashing briefly.

## 5. Admin demo (about 70 seconds)

- Log out and log in as the demo admin.
- Show dashboard counts.
- Add a category; add an item with that category; edit the item; hide it.
- Send a contact message as a guest and show it in admin Messages.
- Explain that a normal student cannot open the admin panel.

## 6. Code explanation questions the TA might ask

**Q: Why separate PHP files?**  
A: Database configuration is in `config/database.php`; shared functions are in `includes/functions.php`; reusable header/footer are included on each page. This keeps code organized.

**Q: Where is data coming from?**  
A: MySQL. PHP uses prepared SQL queries to read and write records.

**Q: What is a session?**  
A: PHP saves a user's login information in `$_SESSION` after successful authentication, so they remain logged in across pages.

**Q: How are passwords stored?**  
A: `password_hash()` hashes new passwords, and `password_verify()` checks login passwords without saving them as plain text.

**Q: What do foreign keys do?**  
A: They connect records, for example an item belongs to a category. They prevent invalid references.

**Q: What validation do you use?**  
A: JavaScript warns the user right away; PHP validates again before writing to MySQL. Database constraints provide another layer.

**Q: Why use prepared statements?**  
A: They pass user input as SQL parameters, which helps prevent SQL injection.

**Q: What does the admin control?**  
A: Admins can manage items/categories, view users, and mark/read/delete contact messages. `require_admin()` blocks normal accounts.

**Q: How did you make it responsive?**  
A: CSS Grid, flexible widths, and media queries switch multi-column layouts into fewer columns on smaller devices. JavaScript controls the mobile menu.

**Q: Why no payment system or external API?**  
A: This is a study-material catalog and contact demo, not a store. The assignment says RESTful integrations are optional.

## 7. Contribution and checkpoints

Update the team members and responsibilities in `README.md` to reflect the people who actually worked on the project. The Lab TA expects Week 1 database/pages, Week 2 login/database/admin, and Week 3 validation/search/contact/testing. Each member needs to explain their own part and answer questions about the whole system.
