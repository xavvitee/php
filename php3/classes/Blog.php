<?php
declare(strict_types=1);

require_once __DIR__ . '/Article.php';

/**
 * Клас-менеджер: зберігає колекцію статей і вміє з нею працювати.
 */
class Blog
{
    /** @var Article[] */
    private array $articles = [];

    // Додає статтю (приймає і Article, і FeaturedArticle, бо вона - нащадок Article)
    public function addArticle(Article $article): void
    {
        $this->articles[] = $article;
    }

    // Повертає усі статті
    public function getAll(): array
    {
        return $this->articles;
    }

    // Пошук статей за автором
    public function findByAuthor(string $author): array
    {
        $result = [];
        foreach ($this->articles as $article) {
            if (mb_strtolower($article->getAuthor()) === mb_strtolower($author)) {
                $result[] = $article;
            }
        }
        return $result;
    }

    // Найновіші статті (за датою публікації, від нових до старих)
    public function listRecent(int $limit = 3): array
    {
        $sorted = $this->articles;
        usort($sorted, fn(Article $a, Article $b) => strcmp($b->getPublishedAt(), $a->getPublishedAt()));
        return array_slice($sorted, 0, $limit);
    }
}
