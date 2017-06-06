(function ($, Drupal) {

  'use strict';

  Drupal.behaviors.responsiveVideos = {
    attach: function() {
      $('[data-js*="responsive-video"]').fitVids();
    }
  };


})(jQuery, Drupal);
