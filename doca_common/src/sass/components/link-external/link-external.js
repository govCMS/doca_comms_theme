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

  Drupal.behaviors.linkExternal = {
    attach: function() {
      $('[data-js*="external-links"] a').each(function() {

        var $this                    = $(this);
        var is_link_external_no_icon = $this.hasClass('link-external__no-icon');
        var has_child_image          = $this.children("img").length;

        if (this.hostname && this.hostname !== location.hostname && !is_link_external_no_icon && !has_child_image) {
          // Read More Links
          if ($this.hasClass('read-more')) {
            $this.addClass('external-link').attr('target','_blank');
            $this.find('svg').before('<svg name="external-link" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" preserveAspectRatio="xMidYMid meet"> <path d="M11.3 6.2c.2 0 .4-.2.4-.4V.7H6.6c-.2 0-.4.2-.4.4s.2.4.4.4h3.7L4.2 7.6c-.2.2-.2.4 0 .6.2.2.4.2.6 0l6.1-6.1v3.7c0 .2.1.4.4.4z"/><path d="M9.5 9c0-.2-.2-.4-.4-.4s-.5.2-.5.4v2.1H1.4V3.8h2.1c.2 0 .4-.2.4-.4S3.7 3 3.5 3H.6v8.9h8.9V9z"/></svg>');
          }
          // Every other link
          else {
            $this.addClass('link-external').attr('target','_blank');
          }
          if ($("body").hasClass('caretaker')) {
            $this.click(function (e) {
              e.preventDefault();
              $.magnificPopup.open({
                items: {
                  preloader: true,
                  src: '#external-link-popup-content',
                  type: 'inline'
                }
              });
              $("#external-link-action-continue").attr("href", $this.attr("href"));
              $("#external-link-action-continue").attr("target", $this.attr("target"));
            });
          }
        }
        if ($("body").hasClass('caretaker')) {
          $("#external-link-action-cancel").click(function(e) {
            e.preventDefault();
            var magnificPopup;
            magnificPopup = $.magnificPopup.instance;
            magnificPopup.close();
          });
          $("#external-link-action-continue").click(function(e) {
            var magnificPopup;
            magnificPopup = $.magnificPopup.instance;
            magnificPopup.close();
          });
        }
      });
    }
  };

})(jQuery, Drupal);

