CREATE DATABASE IF NOT EXISTS practicum4 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE practicum4;

CREATE TABLE IF NOT EXISTS articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    author VARCHAR(100) NOT NULL,
    published_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO articles (title, content, author) VALUES
('Перша стаття', 'Вітаємо в нашому блозі!', 'Іван'),
('Про PDO', 'PDO надає єдиний інтерфейс до різних СУБД.', 'Олена');
