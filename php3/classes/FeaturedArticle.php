<?php
declare(strict_types=1);

require_once __DIR__ . '/Article.php';

/**
 * Похідний клас: рекомендована стаття (з банером і пріоритетом).
 */
class FeaturedArticle extends Article
{
    private string $bannerImage;
    private int $priority;

    public function __construct(
        string $title,
        string $content,
        string $author,
        string $publishedAt,
        string $bannerImage,
        int $priority
    ) {
        // Спочатку ініціалізуємо успадковані властивості через батьківський конструктор
        parent::__construct($title, $content, $author, $publishedAt);
        $this->bannerImage = $bannerImage;
        $this->priority = $priority;
    }

    public function getBannerImage(): string
    {
        return $this->bannerImage;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    // Перевизначений метод: беремо опис батька і доповнюємо його
    public function getInfo(): string
    {
        return parent::getInfo() . " | ★ рекомендована, пріоритет: {$this->priority}, банер: {$this->bannerImage}";
    }
}
