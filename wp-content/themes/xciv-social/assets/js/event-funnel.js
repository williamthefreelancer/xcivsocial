(function () {
  'use strict';

  var salesRoot = document.querySelector('[data-xciv-event-sales]');
  var broadcastRoot = document.querySelector('[data-xciv-event-broadcast]');

  function money(n) {
    return '$' + Math.round(n);
  }

  function initSales(root) {
    var linesEl = root.querySelector('[data-checkout-lines]');
    var totalEl = root.querySelector('[data-checkout-total]');
    var ticketInput = root.querySelector('[data-checkout-ticket]');
    var addonsInput = root.querySelector('[data-checkout-addons]');
    var upsellsInput = root.querySelector('[data-checkout-upsells]');
    var totalInput = root.querySelector('[data-checkout-total-input]');
    var form = root.querySelector('[data-checkout-form]');
    var copyBtn = root.querySelector('[data-copy-share]');
    var shareInput = root.querySelector('[data-share-url]');
    var copyStatus = root.querySelector('[data-copy-status]');

    function selectedTicket() {
      return root.querySelector('[data-ticket-id]:checked');
    }

    function checkedItems(selector) {
      return Array.prototype.slice.call(root.querySelectorAll(selector + ':checked'));
    }

    function renderCheckout() {
      var ticket = selectedTicket();
      var addons = checkedItems('[data-addon-id]');
      var upsells = checkedItems('[data-upsell-id]');
      var lines = [];
      var total = 0;

      if (ticket) {
        var tPrice = parseFloat(ticket.getAttribute('data-ticket-price') || '0') || 0;
        total += tPrice;
        lines.push({
          label: ticket.getAttribute('data-ticket-name') || 'Ticket',
          price: tPrice
        });
        if (ticketInput) ticketInput.value = ticket.getAttribute('data-ticket-id') || '';
      }

      var addonIds = [];
      addons.forEach(function (el) {
        var price = parseFloat(el.getAttribute('data-addon-price') || '0') || 0;
        total += price;
        addonIds.push(el.getAttribute('data-addon-id') || '');
        lines.push({
          label: el.getAttribute('data-addon-name') || 'Add-on',
          price: price
        });
      });
      if (addonsInput) addonsInput.value = addonIds.filter(Boolean).join(',');

      var upsellIds = [];
      upsells.forEach(function (el) {
        var price = parseFloat(el.getAttribute('data-upsell-price') || '0') || 0;
        total += price;
        upsellIds.push(el.getAttribute('data-upsell-id') || '');
        lines.push({
          label: el.getAttribute('data-upsell-name') || 'Upsell',
          price: price
        });
      });
      if (upsellsInput) upsellsInput.value = upsellIds.filter(Boolean).join(',');
      if (totalInput) totalInput.value = String(Math.round(total));
      if (totalEl) totalEl.textContent = money(total);

      if (linesEl) {
        linesEl.innerHTML = lines
          .map(function (line) {
            return (
              '<li><span>' +
              escapeHtml(line.label) +
              '</span><strong>' +
              (line.price > 0 ? money(line.price) : 'Free') +
              '</strong></li>'
            );
          })
          .join('');
      }
    }

    function escapeHtml(str) {
      return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
    }

    root.addEventListener('change', function (event) {
      if (
        event.target.matches('[data-ticket-id], [data-addon-id], [data-upsell-id]')
      ) {
        renderCheckout();
      }
    });

    if (form) {
      form.addEventListener('submit', function () {
        renderCheckout();
      });
    }

    if (copyBtn && shareInput) {
      copyBtn.addEventListener('click', function () {
        var value = shareInput.value;
        var done = function () {
          if (!copyStatus) return;
          copyStatus.hidden = false;
          copyStatus.textContent = 'Sales link copied — send it when you’re ready to sell.';
          window.setTimeout(function () {
            copyStatus.hidden = true;
          }, 2800);
        };

        if (navigator.clipboard && navigator.clipboard.writeText) {
          navigator.clipboard.writeText(value).then(done).catch(function () {
            shareInput.select();
            document.execCommand('copy');
            done();
          });
        } else {
          shareInput.select();
          document.execCommand('copy');
          done();
        }
      });
    }

    renderCheckout();
  }

  function initBroadcast(root) {
    var attendee = root.getAttribute('data-attendee') || 'Guest';
    var tabs = root.querySelectorAll('[data-tab]');
    var panels = root.querySelectorAll('[data-panel]');
    var pollForm = root.querySelector('[data-poll]');
    var feedForm = root.querySelector('[data-feed-form]');
    var feedList = root.querySelector('[data-feed-list]');
    var feedInput = root.querySelector('[data-feed-input]');
    var qaForm = root.querySelector('[data-qa-form]');
    var qaList = root.querySelector('[data-qa-list]');
    var qaInput = root.querySelector('[data-qa-input]');

    tabs.forEach(function (tab) {
      tab.addEventListener('click', function () {
        var id = tab.getAttribute('data-tab');
        tabs.forEach(function (t) {
          var on = t === tab;
          t.classList.toggle('is-active', on);
          t.setAttribute('aria-selected', on ? 'true' : 'false');
        });
        panels.forEach(function (panel) {
          var on = panel.getAttribute('data-panel') === id;
          panel.classList.toggle('is-active', on);
          panel.hidden = !on;
        });
      });
    });

    if (pollForm) {
      pollForm.addEventListener('submit', function (event) {
        event.preventDefault();
        var chosen = pollForm.querySelector('input[name="poll_option"]:checked');
        var status = pollForm.querySelector('[data-poll-status]');
        if (!chosen) {
          if (status) {
            status.hidden = false;
            status.textContent = 'Pick an option first.';
          }
          return;
        }

        var optionId = chosen.getAttribute('data-option-id');
        var counts = {};
        var total = 0;
        pollForm.querySelectorAll('[data-poll-count]').forEach(function (el) {
          var id = el.getAttribute('data-poll-count');
          var votes = parseInt(el.getAttribute('data-votes') || '0', 10) || 0;
          if (id === optionId) votes += 1;
          counts[id] = votes;
          total += votes;
          el.setAttribute('data-votes', String(votes));
        });

        Object.keys(counts).forEach(function (id) {
          var pct = total > 0 ? Math.round((counts[id] / total) * 100) : 0;
          var countEl = pollForm.querySelector('[data-poll-count="' + id + '"]');
          var bar = pollForm.querySelector('[data-poll-bar="' + id + '"]');
          if (countEl) countEl.textContent = pct + '%';
          if (bar) bar.style.setProperty('--poll-pct', pct + '%');
        });

        pollForm.querySelectorAll('input[name="poll_option"]').forEach(function (input) {
          input.disabled = true;
        });
        var submit = pollForm.querySelector('button[type="submit"]');
        if (submit) {
          submit.disabled = true;
          submit.textContent = 'Voted';
        }
        if (status) {
          status.hidden = false;
          status.textContent = 'Thanks — vote recorded for this session.';
        }
      });
    }

    function nowLabel() {
      try {
        return new Date().toLocaleTimeString([], { hour: 'numeric', minute: '2-digit' });
      } catch (e) {
        return '';
      }
    }

    if (feedForm && feedList && feedInput) {
      feedForm.addEventListener('submit', function (event) {
        event.preventDefault();
        var text = (feedInput.value || '').trim();
        if (!text) return;
        var li = document.createElement('li');
        li.className = 'xciv-live-feed__item';
        li.innerHTML =
          '<strong></strong><span class="xciv-muted"></span><p></p>';
        li.querySelector('strong').textContent = attendee;
        li.querySelector('.xciv-muted').textContent = nowLabel();
        li.querySelector('p').textContent = text;
        feedList.appendChild(li);
        feedInput.value = '';
        feedList.scrollTop = feedList.scrollHeight;
      });
    }

    if (qaList) {
      qaList.addEventListener('click', function (event) {
        var btn = event.target.closest('[data-qa-vote]');
        if (!btn || btn.classList.contains('is-voted')) return;
        var votesEl = btn.querySelector('[data-qa-votes]');
        if (!votesEl) return;
        var n = parseInt(votesEl.textContent || '0', 10) || 0;
        votesEl.textContent = String(n + 1);
        btn.classList.add('is-voted');
        sortQa();
      });
    }

    function sortQa() {
      if (!qaList) return;
      var items = Array.prototype.slice.call(qaList.querySelectorAll('.xciv-qa__item'));
      items.sort(function (a, b) {
        var av = parseInt((a.querySelector('[data-qa-votes]') || {}).textContent || '0', 10) || 0;
        var bv = parseInt((b.querySelector('[data-qa-votes]') || {}).textContent || '0', 10) || 0;
        return bv - av;
      });
      items.forEach(function (item) {
        qaList.appendChild(item);
      });
    }

    if (qaForm && qaList && qaInput) {
      qaForm.addEventListener('submit', function (event) {
        event.preventDefault();
        var text = (qaInput.value || '').trim();
        if (!text) return;
        var li = document.createElement('li');
        li.className = 'xciv-qa__item';
        li.innerHTML =
          '<button type="button" class="xciv-qa__vote" data-qa-vote aria-label="Upvote question">' +
          '<span aria-hidden="true">▲</span><span data-qa-votes>1</span></button>' +
          '<div><p></p><span class="xciv-muted"></span></div>';
        li.querySelector('p').textContent = text;
        li.querySelector('.xciv-muted').textContent = attendee;
        qaList.insertBefore(li, qaList.firstChild);
        qaInput.value = '';
        sortQa();
      });
    }
  }

  if (salesRoot) initSales(salesRoot);
  if (broadcastRoot) initBroadcast(broadcastRoot);
})();
