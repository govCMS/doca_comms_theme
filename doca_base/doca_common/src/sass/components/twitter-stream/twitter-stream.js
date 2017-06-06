(function ($, Drupal) {

  'use strict';

  Drupal.behaviors.placeholderFallback = {
    attach: function() {

      var twitterCssUrl = "/" + Drupal.settings.pathToTheme + "/dist/css/components/twitter-stream/twitter-stream.css";

      var options = {
        "url": twitterCssUrl
      };

      $.getScript('https://platform.twitter.com/widgets.js', function(){
        twttr.widgets.load();
        new CustomizeTwitterWidget(options);
      });

    }
  };

})(jQuery, Drupal);
