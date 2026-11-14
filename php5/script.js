const results = document.getElementById('results');
const searchInput = document.getElementById('search');
const form = document.getElementById('add-form');

function escapeHtml(str) {
  const div = document.createElement('div');
  div.textContent = str;
  return div.innerHTML;
}

function articleHtml(a) {
  return `<article>
    <h3>${escapeHtml(a.title)}</h3>
    <small>${escapeHtml(a.author)} · ${escapeHtml(a.published_at)}</small>
    <p>${escapeHtml(a.content)}</p>
  </article>`;
}

function render(list) {
  results.innerHTML = list.length
    ? list.map(articleHtml).join('')
    : '<p>Нічого не знайдено.</p>';
}

function showError(message) {
  results.innerHTML = `<p class="error">${escapeHtml(message)}</p>`;
}

async function loadList(term = '') {
  try {
    const response = await fetch('api_list.php?q=' + encodeURIComponent(term));
    if (!response.ok) {
      throw new Error('Помилка сервера: ' + response.status);
    }
    render(await response.json());
  } catch (err) {
    showError(err.message || 'Помилка мережі');
  }
}

// Завантаження при відкритті сторінки
loadList();

// Живий пошук
searchInput.addEventListener('input', () => loadList(searchInput.value));

form.addEventListener('submit', async (event) => {
  event.preventDefault();
  const payload = Object.fromEntries(new FormData(form));

  try {
    const response = await fetch('api_add.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload),
    });
    const data = await response.json();
    if (!response.ok) {
      throw new Error(data.error || 'Помилка сервера: ' + response.status);
    }

    form.reset();
    if (searchInput.value.trim() === '') {
      
      if (results.querySelector('article')) {
        results.insertAdjacentHTML('afterbegin', articleHtml(data));
      } else {
        render([data]);
      }
    } else {
      searchInput.value = '';
      loadList();
    }
  } catch (err) {
    showError(err.message || 'Помилка мережі');
  }
});
