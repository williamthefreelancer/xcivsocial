(function () {
  'use strict';

  var form = document.querySelector('[data-xciv-settings-form]');
  if (!form) return;

  function nextIndex(container) {
    var rows = container.querySelectorAll('[data-xciv-row]');
    var max = -1;
    rows.forEach(function (row) {
      var input = row.querySelector('input[name*="[id]"]');
      if (!input) return;
      var match = input.name.match(/\[(\d+)\]\[id\]$/);
      if (match) {
        max = Math.max(max, parseInt(match[1], 10));
      }
    });
    return max + 1;
  }

  form.addEventListener('click', function (event) {
    var addBtn = event.target.closest('[data-xciv-add-row]');
    if (addBtn) {
      var type = addBtn.getAttribute('data-type');
      var tpl = document.getElementById('xciv-tpl-' + type);
      var container = form.querySelector('[data-xciv-repeater="' + type + '"]');
      if (!tpl || !container) return;

      var index = nextIndex(container);
      var html = tpl.innerHTML.replace(/\{\{INDEX\}\}/g, String(index));
      var wrap = document.createElement('div');
      wrap.innerHTML = html.trim();
      var row = wrap.firstElementChild;
      if (row) container.appendChild(row);
      return;
    }

    var removeBtn = event.target.closest('[data-xciv-remove-row]');
    if (removeBtn) {
      var row = removeBtn.closest('[data-xciv-row]');
      if (row) row.remove();
    }
  });
})();
