# Database design - StudyShelf

**Database name:** `studyshelf`  
**DBMS:** MySQL / MariaDB  
**Source file:** `database/studyshelf.sql`

## Tables and relationships

```text
USERS                 CATEGORIES
-----                 ----------
id (PK)               id (PK)
full_name             name (UNIQUE)
email (UNIQUE)        description
password_hash         created_at
role                       |
created_at                 | (1-to-many)
    |                      v
    +---------------> ITEMS
       (1-to-many)    -----
                      id (PK)
                      category_id (FK -> categories.id)
                      created_by (FK -> users.id)
                      title
                      description
                      price
                      item_condition
                      image_file
                      is_available
                      created_at
                        |
                        | (1-to-many)
                        v
    USERS ------> FAVORITES <------ ITEMS
                  ---------
                  user_id (FK)
                  item_id (FK)
                  (user_id, item_id) = composite PK

    USERS ------> MESSAGES <------ ITEMS (optional)
                  --------
                  id (PK)
                  user_id (nullable FK)
                  item_id (nullable FK)
                  sender_name, sender_email
                  subject, message
                  status, created_at
```

## Table details

| Table | Important constraints | Why it exists |
| --- | --- | --- |
| users | Primary key on `id`, unique `email`, role restricted to student/admin | Login and admin permissions |
| categories | Primary key and unique name | Organizes items by topic |
| items | Primary key, foreign keys to categories and users, non-negative price | Stores each study listing |
| favorites | Composite primary key, two cascading foreign keys | Stops a user from saving the same item twice |
| messages | Primary key, optional foreign keys, status New/Read | Stores contact questions safely |

### Cardinality examples

- One category can have many items, but each item belongs to one category.
- One user can create many items (admin-created listings in this version).
- One user can favorite many items; one item can be favorited by many users.
- A message can optionally relate to one item and optionally to one signed-in user. Guests can also send messages.

### Foreign-key actions

- Deleting a category with items is **restricted**. The admin must first move or remove the items.
- Deleting an item also removes its favorites. Messages linked to a deleted item keep their text, but `item_id` becomes `NULL`.
- Deleting a user removes their favorites; linked messages remain available with `user_id` set to `NULL`.

### Example useful queries

```sql
-- Show items with category names
SELECT i.title, i.price, c.name AS category
FROM items i
JOIN categories c ON c.id = i.category_id;

-- Search for a word in titles
SELECT * FROM items WHERE title LIKE '%Java%';

-- Count saved items for the demo student
SELECT COUNT(*) AS favorites_count FROM favorites WHERE user_id = 2;

-- Show new contact messages
SELECT sender_name, subject, created_at FROM messages
WHERE status = 'New' ORDER BY created_at DESC;
```

## Setup notes

The SQL script is **self-contained**. It creates the database and all five tables, applies constraints and indexes, and adds fictional sample categories, sample listings, and sample accounts. Importing it again resets the data.
