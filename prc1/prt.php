<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$articles = [
    [
        'title' => 'How to Behave Yourself at the US Open',
        'author' => 'Corey Seymour',
        'publishedAt' => '2026-09-04',
        'views' => 245
    ],
    [
        'title' => 'First, End Your Marriage. Then, Cook Rice.',
        'author' => 'Carla Lalli',
        'publishedAt' => '2026-08-31',
        'views' => 87
    ],
    [
        'title' => 'On ‘Furious’ and the Potent Fantasy of Female Revenge',
        'author' => 'Rachel Hills',
        'publishedAt' => '2026-09-05',
        'views' => 156
    ],
    [
        'title' => 'An Excerpt From Gloria Steinem’s New Memoir',
        'author' => 'Gloria Steinem',
        'publishedAt' => '2026-09-04',
        'views' => 66
    ],
    [
        'title' => '57 Thoughts I Had While Watching Spa Weekend',
        'author' => 'Emma Specter',
        'publishedAt' => '2026-08-28',
        'views' => 312
    ],
    [
        'title' => 'On the Road With Hilary Duff',
        'author' => 'Keaton Bell',
        'publishedAt' => '2026-09-06',
        'views' => 105
    ]
];

// Функція форматує назву статті та ім'я автора
function formatArticle(array $article): string
{
    return "{$article['title']} — {$article['author']}";
}

// Обчислення загальної кількості переглядів
$totalViews = 0;

foreach ($articles as $article) {
    $totalViews += $article['views'];
}

?>

<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Блог CMS</title>

    <link rel="stylesheet" href="st.css">
</head>

<body>

<div class="container">

    <h1>Блог / CMS для статей</h1>

    <p class="description">
        Список статей блогу та статистика їх переглядів
    </p>

    <table>
        <thead>
            <tr>
                <th>Стаття та автор</th>
                <th>Дата публікації</th>
                <th>Перегляди</th>
                <th>Статус</th>
            </tr>
        </thead>

        <tbody>

        <?php foreach ($articles as $article): ?>

            <?php
            // Визначення статусу статті
            if ($article['views'] > 100) {
                $status = 'Популярна';
            } else {
                $status = 'Звичайна';
            }
            ?>

            <tr>
                <td>
                    <?= htmlspecialchars(formatArticle($article)) ?>
                </td>

                <td>
                    <?= htmlspecialchars($article['publishedAt']) ?>
                </td>

                <td>
                    <?= $article['views'] ?>
                </td>

                <td>
                    <?= htmlspecialchars($status) ?>
                </td>
            </tr>

        <?php endforeach; ?>

        </tbody>
    </table>

    <div class="total">

        <h2>Статистика</h2>

        <p>
            Сумарна кількість переглядів  усіх статей:
            <strong><?= $totalViews ?></strong>
        </p>

    </div>

</div>

</body>
</html>
