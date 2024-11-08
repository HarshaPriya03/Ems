window.onload = function() {
  const $body = $('body');
  const targetUrl = new URLSearchParams(window.location.search).get('target');

  if (targetUrl) {
    loader(10);
  }

  function loader(delay) {
    setTimeout(function() {
      $body.addClass('loading');
    }, delay);

    setTimeout(function() {
      $body.addClass('loaded');
    }, delay + 1700);

    setTimeout(function() {
      $body.removeClass('restart').addClass('new-page');
    }, delay + 1950);

    setTimeout(function() {
      window.location.href = targetUrl; 
    }, delay + 3200);
  }

  function getRandomNumber(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
  }
};
