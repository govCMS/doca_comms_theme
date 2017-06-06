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

  Drupal.behaviors.offscreenToggle = {
    attach: function() {

      var toggleClicked = false;
      var toggleLink = $('.offscreen__toggle');

      // Add aria attributes.
      $(toggleLink).attr('role', 'button');
      $(toggleLink).attr('aria-controls', 'offscreen');
      $(toggleLink).attr('aria-expanded', 'false');

      $(toggleLink).click(function() {

        if (toggleClicked === false) {
          $('.offscreen').addClass('is-moved');
          $(this).addClass('is-active');
          $(this).attr('aria-expanded', 'true');
        }
        else {
          $('.offscreen').removeClass('is-moved');
          $(this).removeClass('is-active');
          $(this).attr('aria-expanded', 'false');
        }
        toggleClicked = !toggleClicked;
        return false;

      });
    }
  };

})(jQuery, Drupal);

