
require([
  'jquery',
  'jquery/ui',
  'jquery/validate',
  'mage/translate'
], function ($, mageTemplate) {
  "use strict";
  $(document).ready(function () {
    addFeedBack(1);
    addFeedBack(0);
    function addFeedBack(type)
    {
      var BASE_URL = $('#feedback #BASE_URL').text();
      var selector = null;
      if (type === 1) {
        selector = '#feedback #btn-like';
      } else if (type === 0) {
        selector = '#feedback #btn-dislike';
      }
      $(document).on('click', selector, function () {
        // $('#feedback').text($('#feedback #message').text()).addClass('green');
        var formData = new FormData();
        formData.append('type', type);
        $.ajax({
          url: BASE_URL,
          data: formData,
          processData: false,
          contentType: false,
          type: 'POST',
          dataType: 'json',
          success: function (response) {
             console.log(response);
          }
        });
      });
    }
  });
});
