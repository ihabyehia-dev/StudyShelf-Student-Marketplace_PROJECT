<?php
// Database settings. Defaults work with a typical XAMPP installation.
// For another setup, edit these values or set the corresponding environment variables.
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_PORT', getenv('DB_PORT') ?: '3306');
define('DB_NAME', getenv('DB_NAME') ?: 'studyshelf');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') === false ? '' : getenv('DB_PASS'));

function db(): PDO
{
    static $connection = null;
    if ($connection !== null) {
        return $connection;
    }
    try {
        $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        $connection = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]);
        return $connection;
    } catch (PDOException $exception) {
        http_response_code(500);
        exit('Database connection failed. Please import database/studyshelf.sql and check config/database.php.');
    }
}
