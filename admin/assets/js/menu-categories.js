(function($) {

  'use strict';

  $(document).ready(function() {

    'use strict';

    $(document.body).on('click', '#cancel', function() {

      //reload the Categories menu
      event.preventDefault();
      window.location.replace(
          window.daextauttolAdminUrl + 'admin.php?page=daextauttol-categories');

    });

    //Dialog Confirm ---------------------------------------------------------------------------------------------------
    window.DAEXTAUTTOL = {};
    $(document.body).on('click', '.menu-icon.delete', function(event) {
      event.preventDefault();
      window.DAEXTAUTTOL.categoryToDelete = $(this).prev().val();
      $('#dialog-confirm').dialog('open');
    });

  });

  /**
   * Initialize the dialog.
   */
  $(function() {
    $('#dialog-confirm').dialog({
      autoOpen: false,
      resizable: false,
      height: 'auto',
      width: 340,
      modal: true,
      buttons: {
        [objectL10n.deleteText]: function() {
          $('#form-delete-' + window.DAEXTAUTTOL.categoryToDelete).submit();
        },
        [objectL10n.cancelText]: function() {
          $(this).dialog('close');
        },
      },
    });
  });

}(window.jQuery));

