(function($, Drupal) {

  'use strict';

  Drupal.behaviors.site = {
    attach: function (context, settings) {
      // Custom site scripts.
      $(document).ready(function () {
        $('.modaal-gallery').modaal({
          type: 'image'
        });
      });
    }
  };

})(jQuery, Drupal, this, this.document);