# CMPS246 final submission checklist

Based on the three-page **CMPS246 - Final Project** brief (Fall 2026/2027).

| Requirement from the brief | Where to show it | Status |
| --- | --- | --- |
| Responsive HTML/CSS/JavaScript pages | Home, Browse, Details, About, Contact; `assets/css/style.css` | Implemented - verify in browser |
| Responsive admin page | `admin/` pages and CSS media queries | Implemented - verify in browser |
| MySQL tables/keys/constraints/SQL script | `database/studyshelf.sql`, `DATABASE_DESIGN.md` | Implemented - import in XAMPP |
| PHP backend connected to MySQL | `config/database.php`, `includes/`, all PHP pages | Implemented - verify database connection |
| Organized separate PHP files | `config/`, `includes/`, `admin/` | Implemented |
| Registration/login with sessions | `register.php`, `login.php`, `logout.php` | Implemented - functional test needed |
| Database-driven categories/items | Home, Browse, Details, admin pages | Implemented - functional test needed |
| Search | `catalog.php` | Implemented - functional test needed |
| Contact form | `contact.php`, `messages` table | Implemented - functional test needed |
| Client-side validation | `assets/js/main.js` | Implemented - functional test needed |
| Server-side validation | Register, login, contact, admin item/category forms | Implemented - functional test needed |
| Admin dashboard (recommended) | `admin/index.php` | Included |
| Valid, properly linked HTML/CSS | External CSS in `assets/css/style.css` | Check in real browser/validator |
| Original design elements | Local hand-drawn SVG illustrations in `assets/images/` | Included |
| Legal media and no copyright violations | All artwork is original, no third-party pictures | Included |
| No broken links, missing images or console errors | `tests/check_project.py` + manual browser tests | Browser verification required |
| Images with alt attributes | Main page and item-card `<img alt>` attributes | Included |
| Accessible color contrast | High-contrast palette; focus styles, labels, skip link | Check in real browser |
| One ZIP including source and SQL | Downloadable ZIP deliverable | Prepare at final step |
| README: team, setup, test admin, roles | `README.md` | Fill in actual team info |
| Each member can explain their contribution | `PRESENTATION_GUIDE.md` | Practice required |
| Three weekly checkpoints | README timeline | Attend checkpoints in person |
| Final live demo | `PRESENTATION_GUIDE.md` | Must be done in lab |

## Last steps before handing in

1. Import the SQL and test it on your own XAMPP environment.
2. Complete the test cases and fix any failures.
3. Replace the team placeholders with actual members and work divisions.
4. Attend the Lab TA checkpoints and confirm the final deadline.
5. Upload the full ZIP and SQL as instructed.

There is no official numeric grade rubric in the uploaded PDF. The checklist maximizes coverage but cannot guarantee a full mark.
