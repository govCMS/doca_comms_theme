(function($) {
  Drupal.behaviors.stacklaPane = {
    attach: function(context, settings) {
      $(window).load(function() {
        (function(d, id) {
          if (d.getElementById(id)) {
            return;
          }
          var t = d.createElement('script');
          t.type = 'text/javascript';
          t.src = '//stackla-widget.s3.amazonaws.com/media/js/widget/fluid-embed.js';
          t.id = id;
          (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(t);
        }(document, 'stacklafw-js'));
      });
    }
  };
})(jQuery);
