<?php
require_once 'db.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Дозволено лише POST']);
    exit;
}

// JSON-тіло або звичайна форма
$input = json_decode(file_get_contents('php://input'), true);
if (!is_array($input)) {
    $input = $_POST;
}

$title   = trim($input['title'] ?? '');
$content = trim($input['content'] ?? '');
$author  = trim($input['author'] ?? '');

if ($title === '' || $content === '' || $author === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Заповніть заголовок, текст і автора']);
    exit;
}

try {
    $stmt = $pdo->prepare(
        'INSERT INTO articles (title, content, author, published_at)
         VALUES (:title, :content, :author, NOW())'
    );
    $stmt->execute([
        'title' => $title,
        'content' => $content,
        'author' => $author,
    ]);

    $id = (int)$pdo->lastInsertId();
    $row = $pdo->prepare(
        'SELECT id, title, content, author, published_at FROM articles WHERE id = :id'
    );
    $row->execute(['id' => $id]);

    http_response_code(201);
    echo json_encode($row->fetch(), JSON_UNESCAPED_UNICODE);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Помилка бази даних']);
}
