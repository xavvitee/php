<?php
require_once 'db.php';
header('Content-Type: application/json; charset=utf-8');

try {
    $q = trim($_GET['q'] ?? '');
    if ($q !== '') {
        $stmt = $pdo->prepare(
            'SELECT id, title, content, author, published_at
             FROM articles WHERE title LIKE :q
             ORDER BY published_at DESC, id DESC'
        );
        $stmt->execute(['q' => '%' . $q . '%']);
    } else {
        $stmt = $pdo->query(
            'SELECT id, title, content, author, published_at
             FROM articles ORDER BY published_at DESC, id DESC'
        );
    }
    echo json_encode($stmt->fetchAll(), JSON_UNESCAPED_UNICODE);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Помилка бази даних']);
}
