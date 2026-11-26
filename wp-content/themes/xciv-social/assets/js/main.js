(function () {
  'use strict';

  document.documentElement.classList.add('xciv-js');

  var body = document.body;
  var menu = document.querySelector('[data-user-menu]');
  var menuToggle = document.querySelector('[data-user-menu-toggle]');
  var menuPanel = document.querySelector('[data-user-menu-panel]');
  var sidebarToggle = document.querySelector('[data-sidebar-toggle]');
  var sidebarBackdrop = document.querySelector('[data-sidebar-backdrop]');
  var productSwitcher = document.querySelector('[data-xciv-product-switcher]');
  var productTrigger = productSwitcher
    ? productSwitcher.querySelector('[data-xciv-product-switcher-trigger]')
    : null;
  var productMenu = productSwitcher
    ? productSwitcher.querySelector('[data-xciv-product-switcher-menu]')
    : null;

  function closeUserMenu() {
    if (!menu || !menuToggle || !menuPanel) return;
    menu.classList.remove('is-open');
    menuToggle.setAttribute('aria-expanded', 'false');
    menuPanel.hidden = true;
  }

  function openUserMenu() {
    if (!menu || !menuToggle || !menuPanel) return;
    closeProductSwitcher();
    menu.classList.add('is-open');
    menuToggle.setAttribute('aria-expanded', 'true');
    menuPanel.hidden = false;
  }

  function closeProductSwitcher() {
    if (!productSwitcher || !productTrigger || !productMenu) return;
    productSwitcher.classList.remove('is-open');
    productTrigger.setAttribute('aria-expanded', 'false');
    productMenu.hidden = true;
  }

  function openProductSwitcher() {
    if (!productSwitcher || !productTrigger || !productMenu) return;
    closeUserMenu();
    productSwitcher.classList.add('is-open');
    productTrigger.setAttribute('aria-expanded', 'true');
    productMenu.hidden = false;
  }

  if (menuToggle && menuPanel) {
    menuToggle.addEventListener('click', function (event) {
      event.stopPropagation();
      if (menuPanel.hidden) {
        openUserMenu();
      } else {
        closeUserMenu();
      }
    });
  }

  if (productTrigger && productMenu) {
    productTrigger.addEventListener('click', function (event) {
      event.preventDefault();
      event.stopPropagation();
      if (productSwitcher.classList.contains('is-open')) {
        closeProductSwitcher();
      } else {
        openProductSwitcher();
      }
    });
  }

  document.addEventListener('click', function (event) {
    if (menu && !menu.contains(event.target)) {
      closeUserMenu();
    }
    if (productSwitcher && !productSwitcher.contains(event.target)) {
      closeProductSwitcher();
    }
  });

  document.addEventListener('keydown', function (event) {
    if (event.key !== 'Escape') return;
    closeUserMenu();
    closeProductSwitcher();
    closeSidebar();
  });

  function openSidebar() {
    if (!body.classList.contains('xciv-app')) return;
    body.classList.add('is-sidebar-open');
    if (sidebarToggle) sidebarToggle.setAttribute('aria-expanded', 'true');
    if (sidebarBackdrop) sidebarBackdrop.hidden = false;
  }

  function closeSidebar() {
    body.classList.remove('is-sidebar-open');
    if (sidebarToggle) sidebarToggle.setAttribute('aria-expanded', 'false');
    if (sidebarBackdrop) sidebarBackdrop.hidden = true;
  }

  if (sidebarToggle) {
    sidebarToggle.addEventListener('click', function () {
      if (body.classList.contains('is-sidebar-open')) {
        closeSidebar();
      } else {
        openSidebar();
      }
    });
  }

  if (sidebarBackdrop) {
    sidebarBackdrop.addEventListener('click', closeSidebar);
  }

  document.querySelectorAll('[data-xciv-sidebar] a').forEach(function (link) {
    link.addEventListener('click', closeSidebar);
  });
})();
