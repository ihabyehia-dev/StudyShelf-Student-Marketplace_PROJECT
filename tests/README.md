# Project checks

`check_project.py` performs simple checks on the StudyShelf source files.

From the project root, with Python and PHP CLI installed, run:

```bash
python tests/check_project.py
```

The script checks that expected files exist, validates PHP syntax, and confirms the sample SQL includes the main tables and relationships.

It does **not** replace testing the website in a browser with Apache and MySQL running. For manual feature checks, see `TEST_CASES.md` in the project root.
