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
('Чи можна купити ідеальний сон і що насправді змушує нас висипатися', 'Сьогодні на ринку товарів для гарного сну можна знайти матраци та ліжка, вартість яких дорівнює ціні преміальної квартири..', 'Анаствсія'),
('Культура буття: як Citronelle та Saint Bar будують власний всесвіт', 'Заснування ресторану Citronelle та бару Saint Bar свого часу стало сміливим викликом для київського гастрономічного та культурного ландшафту..', 'Віолета');
