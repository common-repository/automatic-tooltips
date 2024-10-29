(function($) {

  'use strict';

  $(document).ready(function() {

    'use strict';

    $('#daext-sort-form select').on('change', function() {
      $('#daext-sort-form').submit();
    });

    $(document.body).on('click', '#update-archive', function() {

      //if another request is processed right now do not proceed with another ajax request
      if ($('#ajax-request-status').val() == 'processing') {
        return;
      }

      //prepare ajax request
      const data = {
        'action': 'daextauttol_generate_statistics',
        'security': window.DAEXTAUTTOL_PHPDATA.nonce,
      };

      //show the ajax loader
      $('#ajax-loader').show();

      //set the ajax request status
      $('#ajax-request-status').val('processing');

      //send ajax request
      $.post(window.DAEXTAUTTOL_PHPDATA.ajaxUrl, data, function() {

        //reload the dashboard menu ----------------------------------------
        window.location.replace(window.DAEXTAUTTOL_PHPDATA.adminUrl +
            'admin.php?page=daextauttol-statistics');

      });

    });

  });

}(window.jQuery));