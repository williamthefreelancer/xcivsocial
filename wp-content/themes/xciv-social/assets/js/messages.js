(function () {
  'use strict';

  var root = document.querySelector('[data-xciv-messages]');
  if (!root) return;

  var dm = root.querySelector('[data-dm]');
  var threadList = root.querySelector('[data-thread-list]');
  var threadTitle = root.querySelector('[data-thread-title]');
  var threadMeta = root.querySelector('[data-thread-meta]');
  var threadAvatar = root.querySelector('[data-thread-avatar] span');
  var onlineDot = root.querySelector('[data-thread-online-dot]');
  var messages = root.querySelector('[data-thread-messages]');
  var body = root.querySelector('[data-message-body]') || root.querySelector('#xciv-message-body');
  var sendBtn = root.querySelector('[data-send-message]');
  var search = root.querySelector('[data-inbox-search]');
  var backBtn = root.querySelector('[data-dm-back]');

  function escapeHtml(text) {
    return String(text)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;');
  }

  function renderMessages(list) {
    if (!messages) return;
    var html = '<div class="xciv-dm__day"><span>Today</span></div>';
    (list || []).forEach(function (msg) {
      var from =
        !msg.mine && msg.from
          ? '<span class="xciv-bubble__from">' + escapeHtml(msg.from) + '</span>'
          : '';
      html +=
        '<article class="xciv-bubble ' + (msg.mine ? 'xciv-bubble--mine' : 'xciv-bubble--theirs') + '">' +
          from +
          '<p>' + escapeHtml(msg.text || '') + '</p>' +
          '<small class="xciv-muted">' + escapeHtml(msg.time || '') + '</small>' +
        '</article>';
    });
    messages.innerHTML = html;
    messages.scrollTop = messages.scrollHeight;
  }

  function openThread(item, opts) {
    if (!item) return;
    opts = opts || {};

    threadList.querySelectorAll('.xciv-dm__thread').forEach(function (el) {
      el.classList.remove('is-active');
    });
    item.classList.add('is-active');
    item.classList.remove('has-unread');
    var badge = item.querySelector('.xciv-dm__badge');
    if (badge) badge.remove();

    var name = item.getAttribute('data-thread-name') || 'Conversation';
    var meta = item.getAttribute('data-thread-meta') || '';
    var online = item.getAttribute('data-thread-online') === '1';
    var initial = (name.charAt(0) || '?').toUpperCase();
    var id = item.getAttribute('data-thread-id') || '';

    if (threadTitle) threadTitle.textContent = name;
    if (threadMeta) threadMeta.textContent = (online ? 'Active now · ' : '') + meta;
    if (threadAvatar) threadAvatar.textContent = initial;
    if (onlineDot) onlineDot.hidden = !online;

    try {
      renderMessages(JSON.parse(item.getAttribute('data-thread-messages') || '[]'));
    } catch (err) {
      renderMessages([]);
    }

    if (dm) dm.classList.add('is-chat-open');

    if (id && window.history && window.history.replaceState) {
      var url = new URL(window.location.href);
      url.searchParams.set('chat', id);
      if (!opts.skipHistory) {
        window.history.replaceState({}, '', url.toString());
      }
    }
  }

  if (threadList) {
    threadList.addEventListener('click', function (event) {
      var item = event.target.closest('[data-thread-id]');
      if (!item) return;
      openThread(item);
    });
  }

  if (backBtn && dm) {
    backBtn.addEventListener('click', function () {
      dm.classList.remove('is-chat-open');
    });
  }

  if (search && threadList) {
    search.addEventListener('input', function () {
      var q = (search.value || '').trim().toLowerCase();
      threadList.querySelectorAll('.xciv-dm__thread').forEach(function (item) {
        var name = (item.getAttribute('data-thread-name') || '').toLowerCase();
        var preview = (item.querySelector('small') || {}).textContent || '';
        item.hidden = q && name.indexOf(q) === -1 && preview.toLowerCase().indexOf(q) === -1;
      });
    });
  }

  function sendMessage() {
    if (!body || !messages || !sendBtn) return;
    var text = (body.value || '').trim();
    if (!text) {
      body.focus();
      return;
    }

    var bubble = document.createElement('article');
    bubble.className = 'xciv-bubble xciv-bubble--mine';
    bubble.innerHTML = '<p></p><small class="xciv-muted">Just now</small>';
    bubble.querySelector('p').textContent = text;
    messages.appendChild(bubble);
    body.value = '';
    body.style.height = 'auto';
    messages.scrollTop = messages.scrollHeight;

    var active = threadList && threadList.querySelector('.xciv-dm__thread.is-active');
    if (active) {
      var preview = active.querySelector('small');
      var time = active.querySelector('time');
      if (preview) preview.textContent = text;
      if (time) time.textContent = 'now';

      try {
        var stored = JSON.parse(active.getAttribute('data-thread-messages') || '[]');
        stored.push({ mine: true, text: text, time: 'Just now' });
        active.setAttribute('data-thread-messages', JSON.stringify(stored));
      } catch (err) {
        // ignore local persistence errors
      }
    }
  }

  if (sendBtn && body) {
    sendBtn.addEventListener('click', sendMessage);
    body.addEventListener('keydown', function (event) {
      if (event.key === 'Enter' && !event.shiftKey) {
        event.preventDefault();
        sendMessage();
      }
    });
    body.addEventListener('input', function () {
      body.style.height = 'auto';
      body.style.height = Math.min(body.scrollHeight, 112) + 'px';
    });
  }

  var compose = root.querySelector('[data-compose]');
  if (compose) {
    compose.addEventListener('click', function () {
      if (search) {
        search.focus();
        search.placeholder = 'Search attendee chats…';
      }
    });
  }

  var params = new URLSearchParams(window.location.search);
  var chatId = params.get('chat');
  if (chatId && threadList) {
    var target = threadList.querySelector('[data-thread-id="' + chatId + '"]');
    if (target) {
      openThread(target, { skipHistory: true });
      if (dm) dm.classList.add('is-chat-open');
    }
  }
})();
