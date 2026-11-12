<?php
$pdo = require_once 'db.php';
require_once 'articles.php';

$id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
$article = getArticle($pdo, $id);
if (!$article) {
    http_response_code(404);
    exit('Статтю не знайдено. <a href="index.php">Назад</a>');
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title   = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $author  = trim($_POST['author'] ?? '');

    if ($title === '' || $content === '' || $author === '') {
        $error = 'Заповніть усі поля.';
        $article = ['id' => $id, 'title' => $title, 'content' => $content, 'author' => $author];
    } else {
        updateArticle($pdo, $id, $title, $content, $author);
        header('Location: index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="uk">
<head><meta charset="UTF-8"><title>Редагування статті</title></head>
<body>
<h1>Редагування статті #<?= (int) $article['id'] ?></h1>
<?php if ($error): ?><p style="color:red"><?= e($error) ?></p><?php endif; ?>
<form method="post">
    <input type="hidden" name="id" value="<?= (int) $article['id'] ?>">
    <p><label>Заголовок<br><input type="text" name="title" size="60" value="<?= e($article['title']) ?>"></label></p>
    <p><label>Зміст<br><textarea name="content" rows="8" cols="60"><?= e($article['content']) ?></textarea></label></p>
    <p><label>Автор<br><input type="text" name="author" value="<?= e($article['author']) ?>"></label></p>
    <button>Зберегти</button> <a href="index.php">Скасувати</a>
</form>
</body>
</html>
