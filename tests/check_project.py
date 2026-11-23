"""Small static checks for the StudyShelf university project.

Run: python tests/check_project.py
Requires PHP CLI for the syntax checks. Does not need a MySQL connection.
"""
from pathlib import Path
import subprocess
import sys

ROOT = Path(__file__).resolve().parents[1]
expected = [
    'index.php','catalog.php','item.php','about.php','contact.php',
    'register.php','login.php','logout.php','profile.php','favorites.php','toggle_favorite.php',
    'admin/index.php','admin/items.php','admin/item_form.php','admin/item_delete.php',
    'admin/categories.php','admin/messages.php','admin/users.php',
    'assets/css/style.css','assets/js/main.js','assets/images/logo.svg',
    'assets/images/favicon.svg','assets/images/hero-study.svg','assets/images/about-campus.svg',
    'database/studyshelf.sql','config/database.php','README.md',
    'DATABASE_DESIGN.md','TEST_CASES.md','SUBMISSION_CHECKLIST.md'
]
missing = [x for x in expected if not (ROOT / x).exists()]
if missing:
    print('Missing expected files:', ', '.join(missing))
    sys.exit(1)
print(f'OK: All {len(expected)} required project files are present.')

php_files = sorted(ROOT.rglob('*.php'))
errors = []
for path in php_files:
    check = subprocess.run(['php','-l',str(path)],capture_output=True,text=True,check=False)
    if check.returncode != 0:
        errors.append((path.relative_to(ROOT),check.stdout+check.stderr))
if errors:
    for name,message in errors: print('FAILED:',name, message)
    sys.exit(1)
print(f'OK: All {len(php_files)} PHP files passed syntax checks.')

sql = (ROOT/'database/studyshelf.sql').read_text()
for table in ['users','categories','items','favorites','messages']:
    if f'CREATE TABLE {table}' not in sql:
        errors.append(('SQL',f'Missing table {table}'))
for word in ['FOREIGN KEY','PRIMARY KEY','UNIQUE','INSERT INTO items','INSERT INTO categories']:
    if word not in sql:
        errors.append(('SQL',f'Missing SQL item {word}'))
for filename in ['book-blue.svg','book-purple.svg','book-orange.svg','notes.svg','stationery.svg','calculator.svg','electronics.svg','accessories.svg']:
    if not (ROOT/'assets/images'/filename).exists():
        errors.append(('Image',filename))
if errors:
    for what,error in errors: print('FAILED:',what,error)
    sys.exit(1)
print('OK: SQL structure and all referenced illustrations are present.')
print('NOTE: Browser functionality and PHP-to-MySQL integration still need a running XAMPP server.')
