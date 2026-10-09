<?php
declare(strict_types=1);

// Підключаємо бібліотеку функцій і класи 
require_once __DIR__ . '/lib/functions.php';
require_once __DIR__ . '/classes/Article.php';
require_once __DIR__ . '/classes/FeaturedArticle.php';
require_once __DIR__ . '/classes/Blog.php';

// Створюємо менеджер
$blog = new Blog();

// Звичайні статті (базовий клас)
$blog->addArticle(new Article(
    'Date Night! Dua Lipa and Callum Turner Cheer on the Yankees',
    'Take me out to the ball game. . . and that’s precisely what Dua Lipa and Callum Turner did last night.',
    'Christian Allaire',
    '2026-09-10'
));
$blog->addArticle(new Article(
    'Zendaya Combines Two Controversial Shoe Trends in Paris',
    'Zendaya, an ardent tabi fab herself, is on a quest to funk up her collection.',
    'Hannah Jackson',
    '2026-09-25'
));

// Рекомендовані статті (похідний клас)
$blog->addArticle(new FeaturedArticle(
    'An Art Lover’s Guide to the South of France',
    'Sure, Paris has the Louvre, but the South of France should be on every art lovers radar.',
    'Hannah Jackson',
    '2026-10-02',
    'banner-php.jpg',
    1
));
$blog->addArticle(new FeaturedArticle(
    'Найкращі книги 2026',
    'We’re starting to winnow down our favorites—at least two editors have cast votes for books published this fall.',
    'Chloe Schama',
    '2026-10-05',
    'banner-structure.jpg',
    2
));
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Блог — ООП у PHP</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Блог: список статей</h1>

<h2>Усі статті</h2>
<table>
    <tr>
        <th>Тип</th>
        <th>Заголовок</th>
        <th>Slug</th>
        <th>Автор</th>
        <th>Дата</th>
        <th>Початок тексту</th>
        <th>getInfo()</th>
    </tr>
    <?php foreach ($blog->getAll() as $article): ?>
        <?php $isFeatured = $article instanceof FeaturedArticle; ?>
        <tr class="<?= $isFeatured ? 'featured' : '' ?>">
            <td>
                <?php if ($isFeatured): ?>
                    <span class="badge star">Рекомендована</span>
                <?php else: ?>
                    <span class="badge">Звичайна</span>
                <?php endif; ?>
            </td>
            <td><?= e($article->getTitle()) ?></td>
            <td><code><?= e(makeSlug($article->getTitle())) ?></code></td>
            <td><?= e($article->getAuthor()) ?></td>
            <td><?= e(formatDate($article->getPublishedAt())) ?></td>
            <td><?= e(truncateText($article->getContent(), 50)) ?></td>
            <td><?= e($article->getInfo()) ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<h2>Останні 3 статті</h2>
<div class="box">
    <ol>
        <?php foreach ($blog->listRecent(3) as $article): ?>
            <li><?= e(formatDate($article->getPublishedAt())) ?> — <?= e($article->getTitle()) ?></li>
        <?php endforeach; ?>
    </ol>
</div>

<h2>Статті автора «Hannah Jackson»</h2>
<div class="box">
    <ul>
        <?php foreach ($blog->findByAuthor('Hannah Jackson') as $article): ?>
            <li><?= e($article->getTitle()) ?></li>
        <?php endforeach; ?>
    </ul>
</div>
</body>
</html>
