(function () {
  'use strict';

  var root = document.querySelector('[data-xciv-dashboard]');
  if (!root) return;

  var videoRoot = root.querySelector('[data-xciv-video]');
  if (!videoRoot) return;

  var frame = videoRoot.querySelector('[data-video-frame]');
  var playBtn = videoRoot.querySelector('[data-video-play]');
  var meta = videoRoot.querySelector('[data-video-meta]');
  var poster = videoRoot.querySelector('[data-video-poster]');
  var embedSrc = videoRoot.getAttribute('data-embed-src') || '';
  if (!playBtn || !frame) return;

  if (!embedSrc) {
    playBtn.disabled = true;
    return;
  }

  function setPlaying(isPlaying) {
    playBtn.hidden = isPlaying;
    videoRoot.classList.toggle('is-playing', isPlaying);
    frame.classList.toggle('is-playing', isPlaying);
    if (meta) meta.hidden = isPlaying;
    if (poster) poster.hidden = isPlaying;
  }

  playBtn.addEventListener('click', function () {
    if (playBtn.disabled || videoRoot.querySelector('iframe[data-video-el]')) return;

    var iframe = document.createElement('iframe');
    iframe.className = 'xciv-video__media';
    iframe.setAttribute('data-video-el', '');
    iframe.setAttribute('src', embedSrc);
    iframe.setAttribute('title', 'XCIV Briefing');
    iframe.setAttribute(
      'allow',
      'accelerometer; gyroscope; autoplay; encrypted-media; picture-in-picture; fullscreen'
    );
    iframe.setAttribute('allowfullscreen', '');
    iframe.setAttribute('loading', 'eager');
    iframe.setAttribute('referrerpolicy', 'strict-origin-when-cross-origin');

    frame.insertBefore(iframe, playBtn);
    setPlaying(true);
  });
})();
