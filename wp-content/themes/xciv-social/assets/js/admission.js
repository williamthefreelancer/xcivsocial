(function () {
  'use strict';

  var form = document.querySelector('[data-xciv-admission]');
  if (!form) return;

  var steps = Array.prototype.slice.call(form.querySelectorAll('[data-step]'));
  var progressItems = Array.prototype.slice.call(
    document.querySelectorAll('[data-admission-progress] [data-progress]')
  );
  var statusEl = form.querySelector('[data-status]');
  var successEl = document.querySelector('[data-admission-success]');
  var submitBtn = form.querySelector('[data-submit]');
  var cfg = window.xcivAdmission || {};
  var index = 0;
  var submitting = false;

  function showStep(i) {
    index = i;
    steps.forEach(function (step, n) {
      var active = n === index;
      step.hidden = !active;
      step.classList.toggle('is-active', active);
    });

    progressItems.forEach(function (item, n) {
      item.classList.toggle('is-active', n === index);
      item.classList.toggle('is-complete', n < index);
    });

    var firstField = steps[index].querySelector('input, select, textarea');
    if (firstField) {
      window.requestAnimationFrame(function () {
        firstField.focus({ preventScroll: true });
      });
    }

    form.scrollIntoView({ behavior: 'smooth', block: 'start' });
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

  function setStatus(message, isError) {
    if (!statusEl) return;
    statusEl.hidden = !message;
    statusEl.textContent = message || '';
    statusEl.classList.toggle('is-error', !!isError);
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

  form.addEventListener('keydown', function (e) {
    if (e.key !== 'Enter') return;
    if (e.target && e.target.tagName === 'TEXTAREA') return;
    if (index < steps.length - 1) {
      e.preventDefault();
      if (!validateCurrent()) return;
      showStep(index + 1);
    }
  });

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    if (submitting) return;
    if (!validateCurrent()) return;

    var data = new FormData(form);
    var payload = {};
    data.forEach(function (value, key) {
      if (key === 'manual_review') return;
      payload[key] = typeof value === 'string' ? value.trim() : value;
    });

    var url = cfg.admissionUrl || '';
    if (!url) {
      setStatus('Admission endpoint is not configured. Refresh and try again.', true);
      return;
    }

    submitting = true;
    if (submitBtn) {
      submitBtn.disabled = true;
      submitBtn.textContent = 'Submitting…';
    }
    setStatus('Submitting your application…', false);

    fetch(url, {
      method: 'POST',
      credentials: 'same-origin',
      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json',
        'X-WP-Nonce': cfg.restNonce || ''
      },
      body: JSON.stringify(payload)
    })
      .then(function (res) {
        return res.json().then(function (body) {
          return { ok: res.ok, status: res.status, body: body };
        });
      })
      .then(function (result) {
        if (!result.ok) {
          var msg =
            (result.body && (result.body.message || (result.body.data && result.body.data.message))) ||
            'Could not submit your application.';
          throw new Error(msg);
        }

        form.hidden = true;
        if (document.querySelector('[data-admission-progress]')) {
          document.querySelector('[data-admission-progress]').hidden = true;
        }
        if (successEl) {
          successEl.hidden = false;
          successEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
        setStatus('', false);
      })
      .catch(function (err) {
        setStatus(err.message || 'Could not submit your application.', true);
        if (submitBtn) {
          submitBtn.disabled = false;
          submitBtn.textContent = 'Submit for review';
        }
      })
      .finally(function () {
        submitting = false;
      });
  });

  showStep(0);
})();
