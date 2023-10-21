
require([
  'jquery'
], function ($) {
  "use strict";

  $(document).ready(function () {
    $('.faq-category').find('ol').find('li').first().addClass('active');
    $('.faqs-list .item > a').on('click', function () {
      if ($(this).parent().children('.description').css('display') !== 'none') {
        $(this).parents('li').removeClass('active');
      } else {
        $(this).parents('.faq-category').find('ol li').removeClass('active');
        $(this).parents('li').addClass('active');
      }
      return false;
    });
    $('.read-more').click(function() {
      window.location.href = $(this).parent().find('a').attr('href');
    });
  });
});
