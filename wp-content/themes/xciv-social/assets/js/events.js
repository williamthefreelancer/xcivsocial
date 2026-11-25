(function () {
  'use strict';

  var calendar = document.querySelector('[data-xciv-events-calendar]');
  var list = document.querySelector('[data-xciv-events-list]');
  if (!calendar && !list) return;

  var catalog = (window.xcivEvents && window.xcivEvents.calendar) || {};
  var initialDate = (window.xcivEvents && window.xcivEvents.initialDate) || '';
  var waitlistCfg = window.xcivEvents || {};
  var dialog = document.querySelector('[data-waitlist-dialog]');
  var waitlistForm = document.querySelector('[data-waitlist-form]');
  var activeWaitlistBtn = null;

  function openWaitlist(opts) {
    if (!dialog || !waitlistForm) return;
    var titleEl = dialog.querySelector('[data-waitlist-title]');
    var seriesInput = dialog.querySelector('[data-waitlist-series]');
    var occurrenceInput = dialog.querySelector('[data-waitlist-occurrence]');
    var nameInput = dialog.querySelector('[data-waitlist-name]');
    var emailInput = dialog.querySelector('[data-waitlist-email]');
    var statusEl = dialog.querySelector('[data-waitlist-status]');
    var submitBtn = dialog.querySelector('[data-waitlist-submit]');

    if (titleEl) titleEl.textContent = opts.title ? ('Join waitlist · ' + opts.title) : 'Join the waitlist';
    if (seriesInput) seriesInput.value = opts.seriesId || '';
    if (occurrenceInput) occurrenceInput.value = opts.occurrenceId || '';
    if (nameInput && !nameInput.value && waitlistCfg.fullName) nameInput.value = waitlistCfg.fullName;
    if (emailInput && !emailInput.value && waitlistCfg.email) emailInput.value = waitlistCfg.email;
    if (statusEl) {
      statusEl.hidden = true;
      statusEl.textContent = '';
    }
    if (submitBtn) {
      submitBtn.disabled = false;
      submitBtn.textContent = 'Join waitlist';
    }

    activeWaitlistBtn = opts.button || null;
    if (typeof dialog.showModal === 'function') {
      dialog.showModal();
    } else {
      dialog.setAttribute('open', '');
    }
  }

  function closeWaitlist() {
    if (!dialog) return;
    if (typeof dialog.close === 'function') {
      dialog.close();
    } else {
      dialog.removeAttribute('open');
    }
    activeWaitlistBtn = null;
  }

  function markJoined(btn) {
    if (!btn) return;
    btn.classList.add('is-waitlisted');
    btn.setAttribute('aria-pressed', 'true');
    btn.textContent = 'On waitlist';
  }

  function handleWaitlistClick(event) {
    var join = event.target.closest('[data-waitlist-join]');
    if (!join) return;
    event.preventDefault();
    if (join.classList.contains('is-waitlisted')) return;
    openWaitlist({
      seriesId: join.getAttribute('data-series-id') || '',
      occurrenceId: join.getAttribute('data-occurrence-id') || '',
      title: join.getAttribute('data-event-title') || '',
      button: join
    });
  }

  if (dialog) {
    dialog.querySelectorAll('[data-waitlist-close]').forEach(function (btn) {
      btn.addEventListener('click', function (event) {
        event.preventDefault();
        closeWaitlist();
      });
    });

    dialog.addEventListener('click', function (event) {
      if (event.target === dialog) closeWaitlist();
    });
  }

  if (waitlistForm) {
    waitlistForm.addEventListener('submit', function (event) {
      event.preventDefault();
      var seriesId = (waitlistForm.querySelector('[data-waitlist-series]') || {}).value || '';
      var occurrenceId = (waitlistForm.querySelector('[data-waitlist-occurrence]') || {}).value || '';
      var fullName = ((waitlistForm.querySelector('[data-waitlist-name]') || {}).value || '').trim();
      var email = ((waitlistForm.querySelector('[data-waitlist-email]') || {}).value || '').trim();
      var statusEl = waitlistForm.querySelector('[data-waitlist-status]');
      var submitBtn = waitlistForm.querySelector('[data-waitlist-submit]');
      var url = waitlistCfg.waitlistUrl || '';

      if (!seriesId || !fullName || !email || !url) {
        if (statusEl) {
          statusEl.hidden = false;
          statusEl.textContent = 'Missing waitlist details. Refresh and try again.';
        }
        return;
      }

      if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.textContent = 'Joining…';
      }
      if (statusEl) {
        statusEl.hidden = false;
        statusEl.textContent = 'Saving your spot…';
      }

      fetch(url, {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
          'Content-Type': 'application/json',
          'X-WP-Nonce': waitlistCfg.restNonce || ''
        },
        body: JSON.stringify({
          series_id: seriesId,
          occurrence_id: occurrenceId,
          full_name: fullName,
          email: email,
          source: list ? 'event-listings' : 'event-calendar'
        })
      })
        .then(function (res) {
          return res.json().then(function (data) {
            return { ok: res.ok, status: res.status, data: data };
          });
        })
        .then(function (result) {
          if (!result.ok) {
            var msg =
              (result.data && (result.data.message || (result.data.data && result.data.data.message))) ||
              'Could not join the waitlist.';
            throw new Error(msg);
          }
          if (statusEl) {
            statusEl.textContent = (result.data && result.data.message) || 'You are on the waitlist.';
          }
          markJoined(activeWaitlistBtn);
          window.setTimeout(closeWaitlist, 900);
        })
        .catch(function (err) {
          if (statusEl) {
            statusEl.hidden = false;
            statusEl.textContent = err.message || 'Could not join the waitlist.';
          }
          if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Join waitlist';
          }
        });
    });
  }

  if (list) {
    var scope = 'upcoming';
    var eventList = list.querySelector('[data-event-list]') || list;
    var empty = list.querySelector('[data-event-empty]');
    var tabs = list.querySelectorAll('[data-event-scope]');
    var form = list.querySelector('[data-event-filters] form');

    function applyListFilters() {
      var q = ((form && form.querySelector('[data-event-search]')) || {}).value || '';
      var city = ((form && form.querySelector('[data-event-city]')) || {}).value || '';
      var vertical = ((form && form.querySelector('[data-event-vertical]')) || {}).value || '';
      q = q.trim().toLowerCase();
      city = city.trim().toLowerCase();

      var visible = 0;
      eventList.querySelectorAll('.xciv-event-card').forEach(function (card) {
        var scopes = (card.getAttribute('data-scope') || '').split(/\s+/);
        var matchScope = scopes.indexOf(scope) !== -1;
        var text = (card.textContent || '').toLowerCase();
        var matchQ = !q || text.indexOf(q) !== -1;
        var matchCity = !city || (card.getAttribute('data-city') || '').toLowerCase().indexOf(city) !== -1;
        var matchVertical = !vertical || card.getAttribute('data-vertical') === vertical;
        var show = matchScope && matchQ && matchCity && matchVertical;
        card.hidden = !show;
        if (show) visible += 1;
      });
      if (empty) empty.hidden = visible > 0;
    }

    tabs.forEach(function (tab) {
      tab.addEventListener('click', function () {
        scope = tab.getAttribute('data-event-scope') || 'upcoming';
        tabs.forEach(function (btn) {
          var on = btn === tab;
          btn.classList.toggle('is-active', on);
          btn.setAttribute('aria-pressed', on ? 'true' : 'false');
        });
        applyListFilters();
      });
    });

    if (form) {
      form.addEventListener('submit', function (event) {
        event.preventDefault();
        applyListFilters();
      });
      form.addEventListener('input', applyListFilters);
      form.addEventListener('change', applyListFilters);
    }

    eventList.addEventListener('click', function (event) {
      if (event.target.closest('[data-waitlist-join]')) {
        handleWaitlistClick(event);
        return;
      }

      var purchase = event.target.closest('[data-purchase]');
      if (purchase) {
        var on = !purchase.classList.contains('is-purchased');
        purchase.classList.toggle('is-purchased', on);
        purchase.setAttribute('aria-pressed', on ? 'true' : 'false');
        purchase.textContent = on ? 'Purchased' : 'Purchase';
        return;
      }

      var rsvp = event.target.closest('[data-rsvp]');
      if (!rsvp || rsvp.disabled) return;
      if (rsvp.classList.contains('is-rsvped') && rsvp.textContent.trim() === 'Hosting') return;
      var going = !rsvp.classList.contains('is-rsvped');
      rsvp.classList.toggle('is-rsvped', going);
      rsvp.setAttribute('aria-pressed', going ? 'true' : 'false');
      rsvp.textContent = going ? 'Going' : 'RSVP';
    });

    applyListFilters();
  }

  if (calendar) {
    var label = calendar.querySelector('[data-cal-label]');
    var prev = calendar.querySelector('[data-cal-prev]');
    var next = calendar.querySelector('[data-cal-next]');
    var grid = calendar.querySelector('[data-cal-grid]');
    var detail = calendar.querySelector('[data-day-events]');
    var dayTitle = calendar.querySelector('[data-day-title]');
    var seed = initialDate ? new Date(initialDate + 'T12:00:00') : new Date();
    var cursor = new Date(seed.getFullYear(), seed.getMonth(), 1);
    var todayKey = iso(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());

    function iso(year, month, day) {
      return year + '-' + String(month + 1).padStart(2, '0') + '-' + String(day).padStart(2, '0');
    }

    function escapeHtml(value) {
      return String(value || '')
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
    }

    function renderDayEvents(key, pretty) {
      if (dayTitle) dayTitle.textContent = pretty;
      if (!detail) return;
      var items = catalog[key] || [];
      if (!items.length) {
        detail.innerHTML = '<p class="xciv-muted">No events on this day.</p>';
        return;
      }
      detail.innerHTML = items.map(function (item) {
        var badge = item.presaleWaitlist ? 'Pre-sale' : (item.paid ? 'Paid' : 'Private');
        var chatHref = '/messages/?chat=' + encodeURIComponent(item.seriesId || '');
        var chat =
          '<a class="xciv-btn xciv-btn--ghost" href="' + chatHref + '">Attendees chat</a>';
        var cta;
        if (item.presaleWaitlist) {
          cta =
            '<button type="button" class="xciv-btn xciv-btn--primary" data-waitlist-join' +
            ' data-series-id="' + escapeHtml(item.seriesId || '') + '"' +
            ' data-occurrence-id="' + escapeHtml(item.occurrenceId || '') + '"' +
            ' data-event-title="' + escapeHtml(item.title || '') + '"' +
            '>Join waitlist</button>';
        } else if (item.paid) {
          cta = '<button type="button" class="xciv-btn xciv-btn--primary" data-purchase>Purchase</button>';
        } else {
          cta =
            '<button type="button" class="xciv-btn xciv-btn--primary' + (item.going ? ' is-rsvped' : '') + '" data-rsvp>' +
            (item.going ? 'Going' : 'RSVP') +
            '</button>';
        }
        return (
          '<article class="xciv-day-event">' +
            '<div class="xciv-day-event__time"><strong>' + escapeHtml(item.time) + '</strong><span class="xciv-muted">' + escapeHtml(item.city) + '</span></div>' +
            '<div><h3>' + escapeHtml(item.title) + ' <span class="xciv-event-card__badge">' + badge + '</span></h3><p class="xciv-muted">' + escapeHtml(item.host) + '</p></div>' +
            '<div class="xciv-day-event__actions">' + chat + cta + '</div>' +
          '</article>'
        );
      }).join('');
    }

    function renderMonth() {
      if (!grid || !label) return;
      var year = cursor.getFullYear();
      var month = cursor.getMonth();
      label.textContent = cursor.toLocaleString('en-US', { month: 'long', year: 'numeric' });

      var first = new Date(year, month, 1);
      var start = first.getDay();
      var daysInMonth = new Date(year, month + 1, 0).getDate();
      var prevDays = new Date(year, month, 0).getDate();
      var html = '';
      var cells = 42;
      var selectedKey = initialDate && catalog[initialDate] ? initialDate : '';

      for (var i = 0; i < cells; i++) {
        var dayNum;
        var cellMonth = month;
        var cellYear = year;
        var outside = false;

        if (i < start) {
          dayNum = prevDays - start + i + 1;
          cellMonth = month - 1;
          outside = true;
          if (cellMonth < 0) {
            cellMonth = 11;
            cellYear -= 1;
          }
        } else if (i >= start + daysInMonth) {
          dayNum = i - (start + daysInMonth) + 1;
          cellMonth = month + 1;
          outside = true;
          if (cellMonth > 11) {
            cellMonth = 0;
            cellYear += 1;
          }
        } else {
          dayNum = i - start + 1;
        }

        var key = iso(cellYear, cellMonth, dayNum);
        var marks = catalog[key] || [];
        if (!selectedKey && marks.length && key >= todayKey) {
          selectedKey = key;
        }

        html +=
          '<button type="button" class="xciv-calendar__cell' +
            (outside ? ' is-outside' : '') +
            (key === todayKey ? ' is-today' : '') +
            (key === selectedKey ? ' is-selected' : '') +
          '" data-date="' + key + '" data-label="' + key + '">' +
            '<span class="xciv-calendar__day">' + dayNum + '</span>' +
            '<span class="xciv-calendar__marks">' +
              marks.map(function (m) {
                var mark = m.mark || (m.title ? m.title.split(':')[0] : '');
                return '<span class="xciv-calendar__dot" title="' + escapeHtml(m.title) + '"></span>' +
                  '<span class="xciv-calendar__mark-label">' + escapeHtml(mark) + '</span>';
              }).join('') +
            '</span>' +
          '</button>';
      }

      grid.innerHTML = html;

      if (selectedKey) {
        var pretty = new Date(selectedKey + 'T12:00:00').toLocaleDateString('en-US', {
          weekday: 'long',
          month: 'short',
          day: 'numeric'
        });
        renderDayEvents(selectedKey, pretty);
      } else {
        renderDayEvents('', 'Select a day');
      }
    }

    grid.addEventListener('click', function (event) {
      var cell = event.target.closest('[data-date]');
      if (!cell) return;
      grid.querySelectorAll('.is-selected').forEach(function (el) {
        el.classList.remove('is-selected');
      });
      cell.classList.add('is-selected');
      var key = cell.getAttribute('data-date');
      var date = new Date(key + 'T12:00:00');
      var pretty = date.toLocaleDateString('en-US', { weekday: 'long', month: 'short', day: 'numeric' });
      renderDayEvents(key, pretty);
    });

    if (prev) {
      prev.addEventListener('click', function () {
        cursor.setMonth(cursor.getMonth() - 1);
        renderMonth();
      });
    }
    if (next) {
      next.addEventListener('click', function () {
        cursor.setMonth(cursor.getMonth() + 1);
        renderMonth();
      });
    }

    calendar.addEventListener('click', function (event) {
      if (event.target.closest('[data-waitlist-join]')) {
        handleWaitlistClick(event);
        return;
      }

      var purchase = event.target.closest('[data-purchase]');
      if (purchase) {
        var on = !purchase.classList.contains('is-purchased');
        purchase.classList.toggle('is-purchased', on);
        purchase.textContent = on ? 'Purchased' : 'Purchase';
        return;
      }

      var rsvp = event.target.closest('[data-rsvp]');
      if (!rsvp) return;
      var going = !rsvp.classList.contains('is-rsvped');
      rsvp.classList.toggle('is-rsvped', going);
      rsvp.textContent = going ? 'Going' : 'RSVP';
    });

    renderMonth();
  }

  document.querySelectorAll('[data-create-event]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      window.alert('Create event shell is ready — wire your form/modal here.');
    });
  });
})();
