<?php
declare(strict_types=1);

/**
 * Базовий клас: звичайна стаття блогу.
 */
class Article
{
    private string $title;          // доступна лише всередині Article
    private string $content;        // доступна лише всередині Article
    protected string $author;       // доступна в Article і в нащадках
    protected string $publishedAt;  // дата публікації у форматі РРРР-ММ-ДД

    public function __construct(string $title, string $content, string $author, string $publishedAt)
    {
        $this->title = $title;
        $this->content = $content;
        $this->author = $author;
        $this->publishedAt = $publishedAt;
    }

    // Геттери: дозволяють прочитати значення приватних властивостей
    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function getPublishedAt(): string
    {
        return $this->publishedAt;
    }

    // Текстовий опис статті
    public function getInfo(): string
    {
        return "«{$this->title}», автор: {$this->author}, опубліковано: {$this->publishedAt}";
    }
}
