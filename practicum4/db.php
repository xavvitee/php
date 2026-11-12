<?php
// Файл підключення до БД. Повертає об'єкт PDO.
$dsn = 'mysql:host=localhost;dbname=practicum4;charset=utf8mb4';

return new PDO($dsn, 'root', '', [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);
