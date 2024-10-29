(function($) {

  'use strict';

  $(document).ready(function() {

    'use strict';

    //initialize chosen on all the select elements
    const chosenElements = [];

    //Statistics Menu -------------------------------------------------------------------------------------------------
    addToChosen('sb');
    addToChosen('or');

    //Tooltips Menu ---------------------------------------------------------------------------------------------------
    addToChosen('cf');
    addToChosen('category-id');
    addToChosen('case-sensitive-search');
    addToChosen('left-boundary');
    addToChosen('right-boundary');
    addToChosen('post-types');
    addToChosen('categories');
    addToChosen('tags');

    //Options Menu -----------------------------------------------------------------------------------------------------

    //Style
    addToChosen('daextauttol-style-tooltip-font-weight');
    addToChosen('daextauttol-style-tooltip-text-alignment');
    addToChosen('daextauttol-style-tooltip-drop-shadow');
    addToChosen('daextauttol-style-keyword-font-weight');
    addToChosen('daextauttol-style-keyword-decoration');

    //Defaults
    addToChosen('daextauttol-defaults-category-id');
    addToChosen('daextauttol-defaults-case-sensitive-search');
    addToChosen('daextauttol-defaults-left-boundary');
    addToChosen('daextauttol-defaults-right-boundary');
    addToChosen('daextauttol-defaults-categories');
    addToChosen('daextauttol-defaults-tags');

    //Analysis
    addToChosen('daextauttol-analysis-set-max-execution-time');
    addToChosen('daextauttol-analysis-set-memory-limit');
    addToChosen('daextauttol-analysis-post-types');

    //Advanced
    addToChosen('daextauttol-advanced-enable-tooltips');
    addToChosen('daextauttol-advanced-enable-test-mode');
    addToChosen('daextauttol-advanced-random-prioritization');
    addToChosen('daextauttol-advanced-categories-and-tags-verification');
    addToChosen('daextauttol-advanced-general-limit-mode');
    addToChosen('daextauttol-advanced-protected-tags');
    addToChosen('daextauttol-advanced-protected-gutenberg-blocks');
    addToChosen('daextauttol-advanced-protected-gutenberg-embeds');

    $(chosenElements.join(',')).chosen({
      placeholder_text_multiple: window.objectL10n.chooseAnOptionText,
    });

    function addToChosen(elementId) {

      if ($('#' + elementId).length &&
          chosenElements.indexOf($('#' + elementId)) === -1) {
        chosenElements.push('#' + elementId);
      }

    }

  });

})(window.jQuery);