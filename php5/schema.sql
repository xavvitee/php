CREATE TABLE IF NOT EXISTS articles (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  content TEXT NOT NULL,
  author VARCHAR(100) NOT NULL,
  published_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) CHARACTER SET utf8mb4;

INSERT INTO articles (title, content, author) VALUES
('У Лондоні відбувся фестиваль Women and the World International Film Festival', 'Це кінофестиваль про жінок, їхні голоси та досвід у світі, зокрема під час воєн і конфліктів, організований українськими продюсерками..', 'Аліса'),
('Українка Катерина Садурська встановила новий світовий рекорд', '11 листопада на міжнародних змаганнях AIDA Blue Element November 2026 українка занурилася на 90 метрів..', 'Ангеліна');
