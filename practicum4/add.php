<?php
$pdo = require_once 'db.php';
require_once 'articles.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title   = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $author  = trim($_POST['author'] ?? '');

    if ($title === '' || $content === '' || $author === '') {
        $error = 'Заповніть усі поля.';
    } else {
        addArticle($pdo, $title, $content, $author);
        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="uk">
<head><meta charset="UTF-8"><title>Нова стаття</title></head>
<body>
<h1>Нова стаття</h1>
<?php if ($error): ?><p style="color:red"><?= e($error) ?></p><?php endif; ?>
<form method="post">
    <p><label>Заголовок<br><input type="text" name="title" size="60" value="<?= e($_POST['title'] ?? '') ?>"></label></p>
    <p><label>Зміст<br><textarea name="content" rows="8" cols="60"><?= e($_POST['content'] ?? '') ?></textarea></label></p>
    <p><label>Автор<br><input type="text" name="author" value="<?= e($_POST['author'] ?? '') ?>"></label></p>
    <button>Додати</button> <a href="index.php">Скасувати</a>
</form>
</body>
</html>
