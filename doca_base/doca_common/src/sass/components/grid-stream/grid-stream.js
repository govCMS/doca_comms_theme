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

  Drupal.behaviors.gridAtThree = {
    attach: function() {

      var gridAtThree = $(".grid-stream--grid-at-three");
      if (gridAtThree.length > 0) {

        $('.grid-stream__item--landscape-small', gridAtThree).each(function() {
          $(this).removeClass('grid-stream__item--landscape-small');
          $(this).addClass('grid-stream__item--vertical');
        });

        $('.grid-stream__item--landscape-small--has-image-description', gridAtThree).each(function() {
          $(this).removeClass('grid-stream__item--landscape-small--has-image-description');
          $(this).addClass('grid-stream__item--vertical--has-image-description');
        });

        $('.grid-stream__item--landscape-small__right', gridAtThree).each(function() {
          $(this).attr('class', 'grid-stream__item--vertical__top');
        });

        $('.grid-stream__item--landscape-small__left', gridAtThree).each(function() {
          $(this).attr('class', 'grid-stream__item--vertical__bottom');
        });
      }
    }
  };

})(jQuery, Drupal);
