<?php

declare(strict_types=1);

$errors = [];
$success = false;
$title = '';
$content = '';
$tagsRaw = '';
$tags = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim((string) ($_POST['title'] ?? ''));
    $content = trim((string) ($_POST['content'] ?? ''));
    $tagsRaw = trim((string) ($_POST['tags'] ?? ''));

    // title: від 5 до 100 символів
    $titleLen = preg_match_all('/./us', $title);
    if ($title === '') {
        $errors['title'] = 'Заголовок обов\'язковий.';
    } elseif ($titleLen < 5 || $titleLen > 100) {
        $errors['title'] = "Заголовок має містити від 5 до 100 символів (зараз: $titleLen).";
    }

    // content: не менше 20 символів
    $contentLen = preg_match_all('/./us', $content);
    if ($content === '') {
        $errors['content'] = 'Текст статті обов\'язковий.';
    } elseif ($contentLen < 20) {
        $errors['content'] = "Текст має містити щонайменше 20 символів (зараз: $contentLen).";
    }

    // tags
    if ($tagsRaw !== '') {
        $tags = array_values(array_filter(array_map('trim', explode(',', $tagsRaw)), fn($t) => $t !== ''));
        if (count($tags) > 10) {
            $errors['tags'] = 'Можна вказати не більше 10 тегів.';
        } else {
            foreach ($tags as $t) {
                if (!preg_match('/^[\p{L}\p{N}_\- ]{2,30}$/u', $t)) {
                    $errors['tags'] = 'Тег має містити 2-30 символів: літери, цифри, пробіл, "-" або "_".';
                    break;
                }
            }
        }
    }

    $success = empty($errors);
}

// Безпечний вивід значень
function e(string $s): string
{
    return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Нова стаття</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Нова стаття</h1>

<?php if ($success): ?>
    <div class="result">
        <h2 class="ok">Статтю прийнято!</h2>
        <p><strong>Заголовок:</strong> <?= e($title) ?></p>
        <p><strong>Текст:</strong></p>
        <pre><?= e($content) ?></pre>
        <p><strong>Теги:</strong>
            <?php if ($tags): foreach ($tags as $t): ?>
                <span class="tag"><?= e($t) ?></span>
            <?php endforeach; else: ?>
                <span class="hint">не вказано</span>
            <?php endif; ?>
        </p>
        <p><a href="form.php">Написати ще одну статтю</a></p>
    </div>
    <script>

        localStorage.removeItem('article_draft');
    </script>
<?php else: ?>
    <form id="articleForm" method="post" action="form.php">
        <label for="title">Заголовок <span class="hint">(5-100 символів)</span></label>
        <input type="text" id="title" name="title" required minlength="5" maxlength="100"
               value="<?= e($title) ?>" class="<?= isset($errors['title']) ? 'invalid' : '' ?>">
        <div class="error" id="err-title"><?= isset($errors['title']) ? e($errors['title']) : '' ?></div>

        <label for="content">Текст статті <span class="hint">(мінімум 20 символів)</span>
            <span class="status" id="draftStatus"></span></label>
        <textarea id="content" name="content" required minlength="20"
                  class="<?= isset($errors['content']) ? 'invalid' : '' ?>"><?= e($content) ?></textarea>
        <div class="error" id="err-content"><?= isset($errors['content']) ? e($errors['content']) : '' ?></div>

        <label for="tags">Теги <span class="hint">(через кому, необов'язково)</span></label>
        <input type="text" id="tags" name="tags" value="<?= e($tagsRaw) ?>"
               class="<?= isset($errors['tags']) ? 'invalid' : '' ?>" placeholder="php, веб, навчання">
        <div class="error" id="err-tags"><?= isset($errors['tags']) ? e($errors['tags']) : '' ?></div>

        <button type="submit">Опублікувати</button>
    </form>

    <script>
        const form = document.getElementById('articleForm');
        const fields = {
            title: document.getElementById('title'),
            content: document.getElementById('content'),
            tags: document.getElementById('tags')
        };
        const status = document.getElementById('draftStatus');
        const DRAFT_KEY = 'article_draft';

        // Клієнтська валідація
        function setError(name, message) {
            document.getElementById('err-' + name).textContent = message;
            fields[name].classList.toggle('invalid', message !== '');
        }
        
        form.addEventListener('submit', (event) => {
            let hasError = false;
            const titleLen = fields.title.value.trim().length;
            const contentLen = fields.content.value.trim().length;

            if (titleLen < 5 || titleLen > 100) {
                setError('title', 'Заголовок має містити від 5 до 100 символів (зараз: ' + titleLen + ').');
                hasError = true;
            } else {
                setError('title', '');
            }

            if (contentLen < 20) {
                setError('content', 'Текст має містити щонайменше 20 символів (зараз: ' + contentLen + ').');
                hasError = true;
            } else {
                setError('content', '');
            }

            if (hasError) {
                event.preventDefault(); // невідправлення форми
            }
        });

        // Автозбереження чернетки 
        function saveDraft() {
            const draft = {
                title: fields.title.value,
                content: fields.content.value,
                tags: fields.tags.value
            };
            localStorage.setItem(DRAFT_KEY, JSON.stringify(draft));
            status.textContent = 'Чернетку збережено ' + new Date().toLocaleTimeString();
        }

        function restoreDraft() {
            const saved = localStorage.getItem(DRAFT_KEY);
            if (!saved) return;
            try {
                const draft = JSON.parse(saved);
                let restored = false;

                for (const name of Object.keys(fields)) {
                    if (fields[name].value === '' && draft[name]) {
                        fields[name].value = draft[name];
                        restored = true;
                    }
                }
                if (restored) status.textContent = 'Чернетку відновлено';
            } catch (e) {
                localStorage.removeItem(DRAFT_KEY); // пошкоджені дані
            }
        }

        restoreDraft();
        for (const name of Object.keys(fields)) {
            fields[name].addEventListener('input', saveDraft);
        }
    </script>
<?php endif; ?>
</body>
</html>