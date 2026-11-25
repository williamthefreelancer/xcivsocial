(function () {
  'use strict';

  var page = document.querySelector('[data-xciv-feed-page]');
  var root = document.querySelector('[data-xciv-feed]');
  var publishBtn = document.querySelector('[data-publish]');
  var body = document.querySelector('[data-composer-body]');
  var charCount = document.querySelector('[data-char-count]');
  var empty = document.querySelector('[data-feed-empty]');
  var typeButtons = document.querySelectorAll('[data-post-type]');
  var filterButtons = document.querySelectorAll('[data-filter]');
  var refreshBtn = document.querySelector('[data-feed-refresh]');

  if (!page || !root || !publishBtn || !body) return;

  var selectedType = 'idea';
  var activeFilter = 'all';
  var labels = {
    idea: 'Idea',
    introduction: 'Introduction',
    opportunity: 'Opportunity'
  };

  var user = window.xcivSocial || {};
  var displayName = user.displayName || 'You';
  var initial = (displayName.charAt(0) || 'Y').toUpperCase();

  function setType(type) {
    selectedType = type;
    typeButtons.forEach(function (btn) {
      var on = btn.getAttribute('data-post-type') === type;
      btn.classList.toggle('is-active', on);
      btn.setAttribute('aria-pressed', on ? 'true' : 'false');
    });
  }

  function updateCount() {
    if (!charCount) return;
    charCount.textContent = body.value.length + ' / 1200';
  }

  function applyFilter(filter) {
    activeFilter = filter;
    filterButtons.forEach(function (btn) {
      var on = btn.getAttribute('data-filter') === filter;
      btn.classList.toggle('is-active', on);
      btn.setAttribute('aria-pressed', on ? 'true' : 'false');
    });

    var visible = 0;
    root.querySelectorAll('.xciv-feed-item').forEach(function (item) {
      var type = item.getAttribute('data-type') || '';
      var show = filter === 'all' || type === filter;
      item.hidden = !show;
      if (show) visible += 1;
    });

    if (empty) empty.hidden = visible > 0;
  }

  function escapeHtml(text) {
    return String(text)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#39;');
  }

  function buildPost(text, type) {
    var article = document.createElement('article');
    article.className = 'xciv-feed-item is-new';
    article.setAttribute('data-type', type);
    article.setAttribute('data-post-id', 'local-' + Date.now());

    var profileUrl = (user.homeUrl || '/') + 'profile/';
    var safeText = escapeHtml(text).replace(/\n/g, '<br>');

    article.innerHTML =
      '<header class="xciv-feed-item__head">' +
        '<a class="xciv-avatar" href="' + profileUrl + '" aria-hidden="true"><span>' + escapeHtml(initial) + '</span></a>' +
        '<div class="xciv-feed-item__meta">' +
          '<div class="xciv-feed-item__byline">' +
            '<a class="xciv-feed-item__name" href="' + profileUrl + '">' + escapeHtml(displayName) + '</a>' +
            '<span class="xciv-feed-item__badge" data-type-label>' + escapeHtml(labels[type] || 'Idea') + '</span>' +
          '</div>' +
          '<p class="xciv-muted xciv-feed-item__sub">' +
            'Just now · Draft preview — not persisted yet' +
          '</p>' +
        '</div>' +
      '</header>' +
      '<div class="xciv-feed-item__body"><p>' + safeText + '</p></div>' +
      '<footer class="xciv-feed-item__actions">' +
        '<button type="button" class="xciv-feed-action" data-appreciate>' +
          '<span data-appreciate-label>Appreciate</span>' +
          '<span class="xciv-feed-action__count" data-appreciate-count>0</span>' +
        '</button>' +
        '<button type="button" class="xciv-feed-action" data-comment>Comment <span class="xciv-feed-action__count">0</span></button>' +
        '<button type="button" class="xciv-feed-action" data-introduce>Offer intro</button>' +
      '</footer>';

    return article;
  }

  typeButtons.forEach(function (btn) {
    btn.addEventListener('click', function () {
      setType(btn.getAttribute('data-post-type') || 'idea');
    });
  });

  filterButtons.forEach(function (btn) {
    btn.addEventListener('click', function () {
      applyFilter(btn.getAttribute('data-filter') || 'all');
    });
  });

  body.addEventListener('input', updateCount);

  publishBtn.addEventListener('click', function () {
    var text = (body.value || '').trim();
    if (!text) {
      body.focus();
      return;
    }

    // Placeholder until createPost GraphQL mutation exists.
    var item = buildPost(text, selectedType);
    root.prepend(item);
    body.value = '';
    updateCount();
    applyFilter(activeFilter);

    window.setTimeout(function () {
      item.classList.remove('is-new');
    }, 1400);
  });

  root.addEventListener('click', function (event) {
    var appreciate = event.target.closest('[data-appreciate]');
    if (appreciate) {
      var countEl = appreciate.querySelector('[data-appreciate-count]');
      var labelEl = appreciate.querySelector('[data-appreciate-label]');
      var count = parseInt((countEl && countEl.textContent) || '0', 10) || 0;
      var on = !appreciate.classList.contains('is-active');
      appreciate.classList.toggle('is-active', on);
      appreciate.setAttribute('aria-pressed', on ? 'true' : 'false');
      if (countEl) countEl.textContent = String(on ? count + 1 : Math.max(0, count - 1));
      if (labelEl) labelEl.textContent = on ? 'Appreciated' : 'Appreciate';
      return;
    }

    var introduce = event.target.closest('[data-introduce]');
    if (introduce) {
      introduce.classList.add('is-active');
      introduce.textContent = introduce.textContent.indexOf('Request') === 0 ? 'Requested' : 'Intro offered';
      introduce.disabled = true;
    }
  });

  if (refreshBtn) {
    refreshBtn.addEventListener('click', function () {
      root.querySelectorAll('.xciv-feed-item').forEach(function (item, index) {
        item.style.animation = 'none';
        // Force reflow so staggered rise can replay.
        void item.offsetWidth;
        item.style.animation = 'xciv-rise 0.45s ease ' + (index * 0.05) + 's both';
      });
    });
  }

  updateCount();
  applyFilter('all');
})();
