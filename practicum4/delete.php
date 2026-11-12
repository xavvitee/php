<?php
$pdo = require_once 'db.php';
require_once 'articles.php';

// Видалення тільки через POST (GET-посилання може спрацювати випадково або від пошукового бота)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    deleteArticle($pdo, (int) ($_POST['id'] ?? 0));
}
header('Location: index.php');
exit;
