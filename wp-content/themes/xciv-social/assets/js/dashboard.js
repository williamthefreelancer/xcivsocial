(function () {
  'use strict';

  var root = document.querySelector('[data-xciv-dashboard]');
  if (!root) return;

  var videoRoot = root.querySelector('[data-xciv-video]');
  if (!videoRoot) return;

  var video = videoRoot.querySelector('[data-video-el]');
  var playBtn = videoRoot.querySelector('[data-video-play]');
  if (!video || !playBtn) return;

  playBtn.addEventListener('click', function () {
    playBtn.hidden = true;
    video.play().catch(function () {
      playBtn.hidden = false;
    });
  });

  video.addEventListener('play', function () {
    playBtn.hidden = true;
  });
  video.addEventListener('pause', function () {
    if (!video.ended) playBtn.hidden = false;
  });
  video.addEventListener('ended', function () {
    playBtn.hidden = false;
  });
})();
