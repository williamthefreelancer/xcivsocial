(function () {
  'use strict';

  var form = document.querySelector('[data-xciv-admission]');
  if (!form) return;

  var steps = Array.prototype.slice.call(form.querySelectorAll('[data-step]'));
  var statusEl = form.querySelector('[data-status]');
  var index = 0;

  function showStep(i) {
    index = i;
    steps.forEach(function (step, n) {
      var active = n === index;
      step.hidden = !active;
      step.classList.toggle('is-active', active);
    });
  }

  function validateCurrent() {
    var fields = steps[index].querySelectorAll('input, select, textarea');
    for (var i = 0; i < fields.length; i++) {
      if (!fields[i].checkValidity()) {
        fields[i].reportValidity();
        return false;
      }
    }
    return true;
  }

  form.addEventListener('click', function (e) {
    var next = e.target.closest('[data-next]');
    var prev = e.target.closest('[data-prev]');
    if (next) {
      e.preventDefault();
      if (!validateCurrent()) return;
      if (index < steps.length - 1) showStep(index + 1);
    }
    if (prev) {
      e.preventDefault();
      if (index > 0) showStep(index - 1);
    }
  });

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    if (!validateCurrent()) return;

    var data = new FormData(form);
    var payload = {};
    data.forEach(function (value, key) {
      payload[key] = value;
    });

    statusEl.hidden = false;
    statusEl.textContent = 'Submitting… (GraphQL mutation hooks up next)';

    // Placeholder until xciv-social-core GraphQL mutation is live.
    window.setTimeout(function () {
      statusEl.textContent =
        'Boilerplate received locally. Wire submitAdmission mutation in the core plugin to persist applications.';
    }, 400);

    console.info('[xciv] admission payload', payload);
  });

  showStep(0);
})();
