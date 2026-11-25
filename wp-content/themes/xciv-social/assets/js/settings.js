(function () {
  'use strict';

  var account = document.querySelector('[data-xciv-account-settings]');
  var profile = document.querySelector('[data-xciv-profile-settings]');
  if (!account && !profile) return;

  function bindForm(form, successCopy) {
    if (!form) return;
    form.addEventListener('submit', function (event) {
      event.preventDefault();
      var status = form.querySelector('[data-status]') || document.createElement('p');
      status.className = 'xciv-form__status';
      status.setAttribute('data-status', '');
      status.hidden = false;
      status.textContent = successCopy || 'Saved locally (not persisted yet).';
      if (!form.contains(status)) form.appendChild(status);
    });
  }

  function bindNav(root) {
    var nav = root.querySelector('[data-settings-nav]');
    if (!nav) return;
    nav.querySelectorAll('a[href^="#"]').forEach(function (link) {
      link.addEventListener('click', function () {
        nav.querySelectorAll('a').forEach(function (el) {
          el.classList.toggle('is-active', el === link);
        });
      });
    });
  }

  if (account) {
    bindNav(account);
    bindForm(account.querySelector('[data-account-login]'), 'Email saved locally.');
    bindForm(account.querySelector('[data-account-security]'), 'Password form ready.');
    bindForm(account.querySelector('[data-account-notifications]'), 'Notification prefs saved locally.');

    account.querySelectorAll('[data-revoke-session]').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var row = btn.closest('li');
        if (row) row.remove();
      });
    });

    var deactivate = account.querySelector('[data-deactivate]');
    if (deactivate) {
      deactivate.addEventListener('click', function () {
        deactivate.textContent = 'Deactivation queued (preview)';
        deactivate.disabled = true;
      });
    }
  }

  if (profile) {
    bindNav(profile);
    bindForm(profile.querySelector('[data-profile-basics]'), 'Basics saved locally.');
    bindForm(profile.querySelector('[data-profile-story]'), 'Story saved locally.');
    bindForm(profile.querySelector('[data-profile-visibility]'), 'Visibility saved locally.');

    var previewName = profile.querySelector('[data-preview-name]');
    var previewHeadline = profile.querySelector('[data-preview-headline]');
    var nameInput = profile.querySelector('[data-sync-preview="name"]');
    var headlineInput = profile.querySelector('[data-sync-preview="headline"]');

    if (nameInput && previewName) {
      nameInput.addEventListener('input', function () {
        previewName.textContent = nameInput.value || 'Member';
      });
    }
    if (headlineInput && previewHeadline) {
      headlineInput.addEventListener('input', function () {
        previewHeadline.textContent = headlineInput.value || 'Headline';
      });
    }

    profile.querySelectorAll('[data-upload-avatar], [data-upload-cover]').forEach(function (btn) {
      btn.addEventListener('click', function () {
        btn.textContent = 'Upload ready (wire media)';
      });
    });
  }
})();
