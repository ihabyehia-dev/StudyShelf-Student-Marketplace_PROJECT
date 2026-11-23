-- StudyShelf - CMPS246 Web Programming (Fall 2026/2027)
-- CAUTION: Importing this file again RESETS ALL DATA in the studyshelf database.
-- Use MySQL 8+ or MariaDB 10.4+. Import with phpMyAdmin or mysql CLI.

CREATE DATABASE IF NOT EXISTS studyshelf CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE studyshelf;

SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE IF EXISTS favorites;
DROP TABLE IF EXISTS messages;
DROP TABLE IF EXISTS items;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS users;
SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('student', 'admin') NOT NULL DEFAULT 'student',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(80) NOT NULL UNIQUE,
    description VARCHAR(255) NOT NULL DEFAULT '',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    created_by INT NOT NULL,
    title VARCHAR(140) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(9,2) NOT NULL,
    item_condition ENUM('New', 'Like New', 'Good', 'Fair') NOT NULL DEFAULT 'Good',
    image_file VARCHAR(80) NOT NULL DEFAULT 'book-blue.svg',
    is_available TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_items_category FOREIGN KEY (category_id) REFERENCES categories(id)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT fk_items_user FOREIGN KEY (created_by) REFERENCES users(id)
        ON UPDATE CASCADE ON DELETE RESTRICT,
    CONSTRAINT check_items_price CHECK (price >= 0),
    INDEX idx_items_category (category_id),
    INDEX idx_items_available (is_available),
    INDEX idx_items_title (title)
) ENGINE=InnoDB;

CREATE TABLE favorites (
    user_id INT NOT NULL,
    item_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id, item_id),
    CONSTRAINT fk_favorites_user FOREIGN KEY (user_id) REFERENCES users(id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_favorites_item FOREIGN KEY (item_id) REFERENCES items(id)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    item_id INT NULL,
    sender_name VARCHAR(100) NOT NULL,
    sender_email VARCHAR(150) NOT NULL,
    subject VARCHAR(160) NOT NULL,
    message TEXT NOT NULL,
    status ENUM('New', 'Read') NOT NULL DEFAULT 'New',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_messages_user FOREIGN KEY (user_id) REFERENCES users(id)
        ON UPDATE CASCADE ON DELETE SET NULL,
    CONSTRAINT fk_messages_item FOREIGN KEY (item_id) REFERENCES items(id)
        ON UPDATE CASCADE ON DELETE SET NULL,
    INDEX idx_messages_status (status)
) ENGINE=InnoDB;

-- Test accounts. These are DEMO passwords only, not suitable for deployment.
-- admin@studyshelf.test   password: Admin123!
-- student@studyshelf.test password: Student123!
-- Password hashes were generated with PHP password_hash() (bcrypt).
INSERT INTO users (full_name, email, password_hash, role) VALUES
('StudyShelf Admin', 'admin@studyshelf.test', '$2y$12$Bqhuj0sXvyRajxLkKLJ6.OXgR5k8uo0FI8qpR1x3EG3JkPRGH6JIS', 'admin'),
('Demo Student', 'student@studyshelf.test', '$2y$12$qA1b3CI6o94l6xSbcBGi/.EySPhF2vWckNtjNOBDUbeLsi65QVASe', 'student');

INSERT INTO categories (name, description) VALUES
('Textbooks', 'Course textbooks for different subjects'),
('Lecture Notes', 'Organized study notes and revision material'),
('Stationery', 'Everyday stationery for class'),
('Calculators', 'Helpful tools for math and engineering'),
('Electronics', 'Technology for studying and assignments'),
('Accessories', 'Useful items for campus life');

-- All items are fictional demo listings with original vector artwork.
INSERT INTO items (category_id, created_by, title, description, price, item_condition, image_file, is_available) VALUES
(1, 1, 'Java Programming Guide', 'A beginner-friendly Java guide for OOP practice. Lightly used and in good condition.', 18.00, 'Good', 'book-blue.svg', 1),
(1, 1, 'Database Fundamentals Book', 'Covers tables, keys, relationships, SQL queries, and normalization.', 15.00, 'Like New', 'book-purple.svg', 1),
(1, 1, 'Calculus Study Textbook', 'A helpful textbook for derivatives, integrals, and practice exercises.', 12.00, 'Good', 'book-orange.svg', 1),
(2, 1, 'Data Structures Summary Notes', 'Printed summary sheets for stacks, queues, linked lists, and trees.', 6.00, 'Like New', 'notes.svg', 1),
(2, 1, 'Web Programming Study Notes', 'Study notes about HTML, CSS, JavaScript, PHP, and MySQL.', 5.00, 'New', 'notes.svg', 1),
(3, 1, 'Notebook and Pen Set', 'Three lined notebooks and five blue pens, ideal for class.', 9.00, 'New', 'stationery.svg', 1),
(3, 1, 'Highlighter Pack', 'A pack of colorful highlighters for revision sessions.', 4.50, 'New', 'stationery.svg', 1),
(4, 1, 'Scientific Calculator', 'A reliable scientific calculator for math and statistics coursework.', 20.00, 'Good', 'calculator.svg', 1),
(4, 1, 'Basic Desktop Calculator', 'Simple 12-digit calculator for daily calculations.', 7.00, 'Like New', 'calculator.svg', 1),
(5, 1, 'USB Flash Drive 32GB', 'Compact USB drive for documents, notes, and coursework files.', 10.00, 'New', 'electronics.svg', 1),
(5, 1, 'Wired Computer Mouse', 'Comfortable wired mouse suitable for assignments and browsing.', 8.00, 'Good', 'electronics.svg', 1),
(6, 1, 'Canvas Campus Tote Bag', 'Reusable everyday tote bag with room for books and a laptop.', 11.00, 'Like New', 'accessories.svg', 1);

INSERT INTO favorites (user_id, item_id) VALUES (2, 1), (2, 8);

-- Sample message shows that contact form submissions are saved in the database.
INSERT INTO messages (user_id, item_id, sender_name, sender_email, subject, message, status)
VALUES (2, 1, 'Demo Student', 'student@studyshelf.test', 'Question about a book', 'Hello, is the Java Programming Guide available for pickup on campus?', 'New');
