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

  Drupal.behaviors.pollButtons = {
    attach: function() {
      var option = $('.poll-form__choices .option, .poll-form__option label');
      if (option.length) {
        $('.poll-form__choices .option, .poll-form__option label').bind('click', function () {
          var optionParent = $(option).closest('.poll-form__choices');
          var thisParent = $(this).parent();

          // Unset all other options.
          $('input', optionParent).removeAttr('checked');
          $(option).removeClass('is-active');

          // Check the selected one.
          $('input', thisParent).attr('checked', 'checked');
          $(this).addClass('is-active');
        });
      }
    }
  };

})(jQuery, Drupal);

