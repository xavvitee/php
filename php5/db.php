<?php
// Приклад: використовуйте власний db.php з практикуму №4
$pdo = new PDO(
    'mysql:host=localhost;dbname=practicum4;charset=utf8mb4',
    'root',
    '',
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]
);
