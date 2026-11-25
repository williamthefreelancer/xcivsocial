(function () {
  'use strict';

  var root = document.querySelector('[data-xciv-profile]');
  if (!root) return;

  var connectBtn = root.querySelector('[data-connect]');
  if (connectBtn) {
    connectBtn.addEventListener('click', function () {
      connectBtn.textContent = 'Request sent';
      connectBtn.disabled = true;
      connectBtn.classList.add('is-rsvped');
    });
  }
})();
