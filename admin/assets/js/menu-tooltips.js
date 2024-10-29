(function($) {

  'use strict';

  $(document).ready(function() {

    'use strict';

    removeBorderLastTableTr();

    $(document.body).on('click', '.group-trigger', function() {

      //open and close the various sections of the tables area
      const target = $(this).attr('data-trigger-target');
      $('.' + target).toggle();

      $(this).find('.expand-icon').toggleClass('arrow-down');

      removeBorderLastTableTr();

      /**
       * Prevent a bug that causes the "All" text (used in the chosen multiple when there are no items selected) to be
       * hidden.
       */
      $('.chosen-container-multi .chosen-choices .search-field input').
          each(function() {
            $(this).css('width', 'auto');
          });

    });

    $(document.body).on('click', '#cancel', function(event) {

      //reload the Tooltips menu
      event.preventDefault();
      window.location.replace(
          window.daextauttolAdminUrl + 'admin.php?page=daextauttol-tooltips');

    });

    //Initialize an object wrapper in the global context
    window.DAEXTAUTTOL = {};

    $(document.body).on('click', '.menu-icon.delete', function(event) {
      event.preventDefault();
      window.DAEXTAUTTOL.tooltipToDelete = $(this).prev().val();
      $('#dialog-confirm').dialog('open');
    });

    //Submit the filter form when the select box changes
    $('#daext-filter-form select').on('change', function() {
      $('#daext-filter-form').submit();
    });

  });

  /*
   Remove the bottom border on the last visible tr included in the form
   */
  function removeBorderLastTableTr() {
    $('table.daext-form-table tr > *').css('border-bottom-width', '1px');
    $('table.daext-form-table tr:visible:last > *').
        css('border-bottom-width', '0');
  }

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
          $('#form-delete-' + window.DAEXTAUTTOL.tooltipToDelete).submit();
        },
        [objectL10n.cancelText]: function() {
          $(this).dialog('close');
        },
      },
    });
  });

}(window.jQuery));

