# Manual test cases - CMPS246 StudyShelf

Run these tests after importing the SQL script in XAMPP and starting Apache + MySQL. Fill in **Pass/Fail** after performing the actions; do not claim a test passed until you really checked it.

| ID | Test procedure | Expected result | Result |
| --- | --- | --- | --- |
| T01 | Load `index.php` | Home page and hero image display | Not run |
| T02 | Click logo, Home, Browse, About, Contact | Each page loads without broken links | Not run |
| T03 | Resize browser to 375 px wide | Navigation becomes menu, no horizontal overflow | Not run |
| T04 | View home page categories and latest items | Records show from MySQL | Not run |
| T05 | On Browse page search for `Java` | Related item(s) appear | Not run |
| T06 | Search for random nonsense text | Friendly empty state | Not run |
| T07 | Filter category `Textbooks` | Only textbooks appear | Not run |
| T08 | Sort by low/high price | Items appear in correct order | Not run |
| T09 | Open an item | Details, price, condition, and image display | Not run |
| T10 | Register a new account with valid input | Redirected to profile, password is hashed | Not run |
| T11 | Register using an existing email | Clear error without duplicate record | Not run |
| T12 | Register with unmatched passwords | Rejected by JavaScript and PHP | Not run |
| T13 | Log out and log in using correct password | Session works | Not run |
| T14 | Log in with incorrect password | Error message, no login | Not run |
| T15 | Log in as demo student, try `/admin/index.php` | Access denied | Not run |
| T16 | Save an item to favorites | Appears in favorites list | Not run |
| T17 | Remove saved item | Disappears from favorites list | Not run |
| T18 | As a guest, submit a valid contact form | Success message and new DB row | Not run |
| T19 | Submit contact form with invalid email/short message | Validation errors | Not run |
| T20 | Log in as admin and visit dashboard | Item, user, category, message counts appear | Not run |
| T21 | Admin adds a new category | It appears in category list and on home page | Not run |
| T22 | Admin edits an existing category | Updated name appears | Not run |
| T23 | Admin tries to delete category with items | Operation blocked with message | Not run |
| T24 | Admin adds a new item | Item appears in catalog and dashboard | Not run |
| T25 | Admin edits price/condition/availability | Changes appear; hidden item leaves catalog | Not run |
| T26 | Admin deletes an item | Item removed, no orphaned favorites | Not run |
| T27 | Admin reads contact message and marks it read | Status changes to Read | Not run |
| T28 | Admin views users | Student accounts are visible | Not run |
| T29 | Tab through forms and site nav | Inputs, links, and buttons are keyboard accessible | Not run |
| T30 | Inspect images / run browser DevTools console | No missing assets or JavaScript errors | Not run |
| T31 | Submit form without CSRF token | Server rejects POST | Not run |
| T32 | Test on Chrome and a phone-size screen | Readable text and usable layouts | Not run |

### Checking the PHP/backend tests

Open browser developer tools (F12). In the **Console** tab check for JavaScript errors. In the **Network** tab check that pages and local SVG assets load (not 404). You can also use phpMyAdmin to check the `users`, `items`, `favorites`, and `messages` tables after actions.

### Limitations

PHP syntax and file checks are automated with `python tests/check_project.py`. A real XAMPP + MySQL setup is still needed to complete the functionality tests above. Do not turn the 'Not run' values into 'Pass' without trying each feature.
