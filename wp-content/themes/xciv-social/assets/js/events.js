(function () {
  'use strict';

  var calendar = document.querySelector('[data-xciv-events-calendar]');
  var list = document.querySelector('[data-xciv-events-list]');
  if (!calendar && !list) return;

  var demoEvents = {
    '2026-12-04': [
      { time: '7:30 PM', city: 'Miami', title: 'Table Dinner: One Intro Before Dessert', host: 'Jonah Reyes · 18 going', going: true }
    ],
    '2026-12-11': [
      { time: '10:00 PM', city: 'Dubai', title: 'Members After Hours — DIFC Terrace', host: 'Amira Haddad · 42 going', going: false }
    ],
    '2026-12-16': [
      { time: '4:00 PM', city: 'Lagos', title: 'Corridor Operators Roundtable', host: 'Maya Okonkwo · 11 going', going: true }
    ]
  };

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
      var rsvp = event.target.closest('[data-rsvp]');
      if (!rsvp || rsvp.disabled) return;
      if (rsvp.classList.contains('is-rsvped') && rsvp.textContent.trim() === 'Hosting') return;
      var on = !rsvp.classList.contains('is-rsvped');
      rsvp.classList.toggle('is-rsvped', on);
      rsvp.setAttribute('aria-pressed', on ? 'true' : 'false');
      rsvp.textContent = on ? 'Going' : 'RSVP';
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
    var cursor = new Date(2026, 11, 1);

    function iso(year, month, day) {
      return year + '-' + String(month + 1).padStart(2, '0') + '-' + String(day).padStart(2, '0');
    }

    function renderDayEvents(key, pretty) {
      if (dayTitle) dayTitle.textContent = pretty;
      if (!detail) return;
      var items = demoEvents[key] || [];
      if (!items.length) {
        detail.innerHTML = '<p class="xciv-muted">No events on this day.</p>';
        return;
      }
      detail.innerHTML = items.map(function (item) {
        return (
          '<article class="xciv-day-event">' +
            '<div class="xciv-day-event__time"><strong>' + item.time + '</strong><span class="xciv-muted">' + item.city + '</span></div>' +
            '<div><h3>' + item.title + '</h3><p class="xciv-muted">' + item.host + '</p></div>' +
            '<button type="button" class="xciv-btn xciv-btn--primary' + (item.going ? ' is-rsvped' : '') + '" data-rsvp>' +
              (item.going ? 'Going' : 'RSVP') +
            '</button>' +
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
        var marks = demoEvents[key] || [];
        var todayKey = iso(2026, 11, 4);
        html +=
          '<button type="button" class="xciv-calendar__cell' +
            (outside ? ' is-outside' : '') +
            (key === todayKey ? ' is-today is-selected' : '') +
          '" data-date="' + key + '" data-label="' + key + '">' +
            '<span class="xciv-calendar__day">' + dayNum + '</span>' +
            '<span class="xciv-calendar__marks">' +
              marks.map(function (m) {
                return '<span class="xciv-calendar__dot" title="' + m.title + '"></span>' +
                  '<span class="xciv-calendar__mark-label">' + m.title.split(':')[0] + '</span>';
              }).join('') +
            '</span>' +
          '</button>';
      }

      grid.innerHTML = html;
      renderDayEvents('2026-12-04', 'Thursday, Dec 4');
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
      var rsvp = event.target.closest('[data-rsvp]');
      if (!rsvp) return;
      var on = !rsvp.classList.contains('is-rsvped');
      rsvp.classList.toggle('is-rsvped', on);
      rsvp.textContent = on ? 'Going' : 'RSVP';
    });

    renderMonth();
  }

  document.querySelectorAll('[data-create-event]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      window.alert('Create event shell is ready — wire your form/modal here.');
    });
  });
})();
