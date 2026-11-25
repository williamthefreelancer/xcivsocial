(function () {
  'use strict';

  var root = document.querySelector('[data-xciv-directory]');
  if (!root) return;

  var form = root.querySelector('[data-directory-filters] form');
  var grid = root.querySelector('[data-directory-grid]');
  var empty = root.querySelector('[data-directory-empty]');
  var count = root.querySelector('[data-directory-count]');
  if (!form || !grid) return;

  function applyFilters() {
    var q = ((form.querySelector('[data-directory-search]') || {}).value || '').trim().toLowerCase();
    var vertical = (form.querySelector('[data-directory-vertical]') || {}).value || '';
    var city = ((form.querySelector('[data-directory-city]') || {}).value || '').trim().toLowerCase();
    var visible = 0;

    grid.querySelectorAll('.xciv-member-card').forEach(function (card) {
      var hay = [
        card.getAttribute('data-name') || '',
        card.getAttribute('data-summary') || '',
        card.getAttribute('data-city') || '',
        card.getAttribute('data-vertical') || ''
      ].join(' ');
      var matchQ = !q || hay.indexOf(q) !== -1;
      var matchVertical = !vertical || card.getAttribute('data-vertical') === vertical;
      var matchCity = !city || (card.getAttribute('data-city') || '').indexOf(city) !== -1;
      var show = matchQ && matchVertical && matchCity;
      card.hidden = !show;
      if (show) visible += 1;
    });

    if (empty) empty.hidden = visible > 0;
    if (count) count.textContent = visible + (visible === 1 ? ' member' : ' members');
  }

  form.addEventListener('submit', function (event) {
    event.preventDefault();
    applyFilters();
  });
  form.addEventListener('input', applyFilters);
  form.addEventListener('change', applyFilters);

  root.addEventListener('click', function (event) {
    var connect = event.target.closest('[data-connect]');
    if (!connect) return;
    connect.textContent = 'Requested';
    connect.disabled = true;
    connect.classList.add('is-rsvped');
  });

  applyFilters();
})();
