document.addEventListener('DOMContentLoaded', function () {
  var selects = document.querySelectorAll('.js-conditional-select');
  selects.forEach(function (select) {
    select.addEventListener('change', function () {
      setVisibility(parseInt(this.value, 10));
    });
  });

  var firstSelect = document.querySelector('.js-conditional-select');
  setVisibility(parseInt(firstSelect ? firstSelect.value : NaN, 10));
});

function setVisibility(value) {
  var elements = document.querySelectorAll('.js-conditional[data-show]');
  elements.forEach(function (el) {
    var visibility = String(el.getAttribute('data-show'));
    if (visibility.indexOf(String(value)) === -1) {
      if (typeof el.dataset.vekeOriginalDisplay === 'undefined') {
        var computed = window.getComputedStyle(el).display;
        el.dataset.vekeOriginalDisplay = el.style.display || computed || '';
      }
      el.style.display = 'none';
      el.querySelectorAll('input, select').forEach(function (input) {
        if ('value' in input) {
          input.value = '';
        }
        var reqAttr = input.getAttribute('data-required');
        if (reqAttr !== null && reqAttr !== 'false') {
          input.required = false;
        }
      });
    } else {
      var original = el.dataset.vekeOriginalDisplay;
      if (typeof original !== 'undefined' && original !== '') {
        el.style.display = (original === 'none') ? '' : original;
      } else if (typeof original !== 'undefined' && original === '') {
        el.style.display = '';
      } else {
        el.style.display = 'block';
      }
      el.querySelectorAll('input, select').forEach(function (input) {
        var reqAttr = input.getAttribute('data-required');
        if (reqAttr !== null && reqAttr !== 'false') {
          input.required = true;
        }
      });
    }
  });
}
