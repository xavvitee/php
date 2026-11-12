<?php
$pdo = require_once 'db.php';
require_once 'articles.php';

if (isset($_GET['author']) && $_GET['author'] !== '') {
    $rows = findByAuthor($pdo, $_GET['author']);
} elseif (isset($_GET['recent'])) {
    $rows = listRecent($pdo, (int) $_GET['recent']);
} else {
    $rows = listAll($pdo);
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Блог</title>
    <style>
        body { font-family: sans-serif; margin: 2rem; }
        table { border-collapse: collapse; }
        th, td { border: 1px solid #999; padding: 6px 10px; vertical-align: top; }
        form.inline { display: inline; }
    </style>
</head>
<body>
<h1>Статті</h1>

<form method="get">
    <input type="text" name="author" placeholder="Автор" value="<?= e($_GET['author'] ?? '') ?>">
    <button>Знайти за автором</button>
    <a href="?recent=5">5 останніх</a> | <a href="index.php">Усі</a>
</form>
<p><a href="add.php">+ Додати статтю</a></p>

<table>
    <tr><th>ID</th><th>Заголовок</th><th>Зміст</th><th>Автор</th><th>Дата</th><th>Дії</th></tr>
    <?php foreach ($rows as $r): ?>
        <tr>
            <td><?= (int) $r['id'] ?></td>
            <td><?= e($r['title']) ?></td>
            <td><?= nl2br(e($r['content'])) ?></td>
            <td><?= e($r['author']) ?></td>
            <td><?= e($r['published_at']) ?></td>
            <td>
                <a href="edit.php?id=<?= (int) $r['id'] ?>">Редагувати</a>
                <form class="inline" method="post" action="delete.php"
                      onsubmit="return confirm('Видалити статтю?');">
                    <input type="hidden" name="id" value="<?= (int) $r['id'] ?>">
                    <button>Видалити</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    <?php if (!$rows): ?>
        <tr><td colspan="6">Записів немає</td></tr>
    <?php endif; ?>
</table>
</body>
</html>
