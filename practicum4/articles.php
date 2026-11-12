<?php
// Функції роботи з таблицею articles.

function listAll(PDO $pdo): array
{
    return $pdo->query('SELECT * FROM articles ORDER BY id')->fetchAll();
}

function getArticle(PDO $pdo, int $id): ?array
{
    $stmt = $pdo->prepare('SELECT * FROM articles WHERE id = :id');
    $stmt->execute([':id' => $id]);
    return $stmt->fetch() ?: null;
}

function findByAuthor(PDO $pdo, string $author): array
{
    $stmt = $pdo->prepare('SELECT * FROM articles WHERE author = :author');
    $stmt->execute([':author' => $author]);
    return $stmt->fetchAll();
}

function listRecent(PDO $pdo, int $limit): array
{
    $stmt = $pdo->prepare('SELECT * FROM articles ORDER BY published_at DESC LIMIT :limit');
    // LIMIT потребує цілого числа, тому bindValue з PARAM_INT
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function addArticle(PDO $pdo, string $title, string $content, string $author): int
{
    $stmt = $pdo->prepare(
        'INSERT INTO articles (title, content, author) VALUES (:title, :content, :author)'
    );
    $stmt->execute([':title' => $title, ':content' => $content, ':author' => $author]);
    return (int) $pdo->lastInsertId();
}

function updateArticle(PDO $pdo, int $id, string $title, string $content, string $author): int
{
    $stmt = $pdo->prepare(
        'UPDATE articles SET title = :title, content = :content, author = :author WHERE id = :id'
    );
    $stmt->execute([':title' => $title, ':content' => $content, ':author' => $author, ':id' => $id]);
    return $stmt->rowCount();
}

function deleteArticle(PDO $pdo, int $id): int
{
    $stmt = $pdo->prepare('DELETE FROM articles WHERE id = :id');
    $stmt->execute([':id' => $id]);
    return $stmt->rowCount();
}

function e(string $s): string
{
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}
