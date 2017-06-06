/**
 * @file
 * A JavaScript file for the theme.
 *
 * In order for this JavaScript to be loaded on pages, see the instructions in
 * the README.txt next to this file.
 */

// JavaScript should be made compatible with libraries other than jQuery by
// wrapping it with an "anonymous closure". See:
// - https://drupal.org/node/1446420
// - http://www.adequatelygood.com/2010/3/JavaScript-Module-Pattern-In-Depth
(function ($, Drupal) {

  'use strict';

  Drupal.behaviors.placeholderFallback = {
    attach: function() {

      if(!('placeholder' in document.createElement('input')) || !('placeholder' in document.createElement('textarea'))) {
        $('[placeholder]').focus(function() {
          var input = $(this);
          if (input.val() === input.attr('placeholder')) {
            input.val('');
            input.removeClass('placeholder');
          }
        }).blur(function() {
          var input = $(this);
          if (input.val() === '' || input.val() === input.attr('placeholder')) {
            input.addClass('placeholder');
            input.val(input.attr('placeholder'));
          }
        }).blur().parents('form').submit(function() {
          $(this).find('[placeholder]').each(function() {
            var input = $(this);
            if (input.val() === input.attr('placeholder')) {
              input.val('');
            }
          });
        });
      }
    }
  };

  Drupal.behaviors.formalSubmissionNotify = {
    attach: function() {
      try {
        var formalSubmissionNotify = $("input[name='submitted[email_notification]']");
        if (formalSubmissionNotify.length > 0) {
          // Set the value of each email_notification field.
          $(formalSubmissionNotify).each(function() {
            $(this).val(Drupal.settings.dcomms_theme.formalSubmissionNotify);
          });
        }
      } catch(e) {}
    }
  };

  Drupal.behaviors.searchPlaceholder = {
    attach: function () {
      var filterSearchInput = $(".filter--search input");
      if (filterSearchInput.length > 0) {
        $(filterSearchInput).attr('placeholder', 'Enter search term...');
      }
    }
  };

})(jQuery, Drupal);
