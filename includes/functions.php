<?php
// Common helpers for escaping, sessions, user access and catalog actions.
function e(?string $text): string
{
    return htmlspecialchars($text ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function url(string $path = ''): string
{
    return BASE_URL . ltrim($path, '/');
}

function redirect(string $path): never
{
    header('Location: ' . url($path));
    exit;
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

function valid_csrf(): bool
{
    return isset($_POST['csrf_token']) && is_string($_POST['csrf_token'])
        && hash_equals(csrf_token(), $_POST['csrf_token']);
}

function require_csrf(): void
{
    if (!valid_csrf()) {
        http_response_code(400);
        exit('Invalid form token. Go back, refresh the page, and try again.');
    }
}

function set_flash(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function take_flash(): ?array
{
    $message = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);
    return $message;
}

function current_user(): ?array
{
    return $_SESSION['user'] ?? null;
}

function is_logged_in(): bool
{
    return current_user() !== null;
}

function is_admin(): bool
{
    return (current_user()['role'] ?? '') === 'admin';
}

function require_login(): void
{
    if (!is_logged_in()) {
        set_flash('error', 'Please log in to continue.');
        redirect('login.php');
    }
}

function require_admin(): void
{
    require_login();
    if (!is_admin()) {
        http_response_code(403);
        exit('Access denied. This page is for administrators only.');
    }
}

function get_categories(): array
{
    return db()->query('SELECT c.*, (SELECT COUNT(*) FROM items i WHERE i.category_id = c.id) AS item_count
                         FROM categories c ORDER BY c.name')->fetchAll();
}

function get_latest_items(int $limit = 6): array
{
    $statement = db()->prepare('SELECT i.*, c.name AS category_name FROM items i
        JOIN categories c ON c.id = i.category_id
        WHERE i.is_available = 1 ORDER BY i.created_at DESC, i.id DESC LIMIT :item_limit');
    $statement->bindValue(':item_limit', $limit, PDO::PARAM_INT);
    $statement->execute();
    return $statement->fetchAll();
}

function get_item(int $id): ?array
{
    $statement = db()->prepare('SELECT i.*, c.name AS category_name, u.full_name AS listed_by
        FROM items i JOIN categories c ON c.id = i.category_id
        JOIN users u ON u.id = i.created_by WHERE i.id = ?');
    $statement->execute([$id]);
    $item = $statement->fetch();
    return $item ?: null;
}

function money($amount): string
{
    return '$' . number_format((float) $amount, 2);
}

function available_images(): array
{
    return [
        'book-blue.svg' => 'Blue book',
        'book-purple.svg' => 'Purple book',
        'book-orange.svg' => 'Orange book',
        'notes.svg' => 'Study notes',
        'stationery.svg' => 'Stationery',
        'calculator.svg' => 'Calculator',
        'electronics.svg' => 'Electronics',
        'accessories.svg' => 'Accessories'
    ];
}

function image_path(string $file): string
{
    if (!array_key_exists($file, available_images())) {
        $file = 'book-blue.svg';
    }
    return url('assets/images/' . $file);
}

function is_favorite(int $itemId): bool
{
    if (!is_logged_in()) {
        return false;
    }
    $statement = db()->prepare('SELECT 1 FROM favorites WHERE user_id = ? AND item_id = ? LIMIT 1');
    $statement->execute([current_user()['id'], $itemId]);
    return (bool) $statement->fetchColumn();
}

function safe_id($value): int
{
    $id = filter_var($value, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    return $id === false ? 0 : (int) $id;
}
