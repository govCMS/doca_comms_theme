/**
 * @file
 * A JavaScript file for the Site Feedback Popup.
 */

(function ($, Drupal) {

  'use strict';

  Drupal.behaviors.SiteFeedbackPopupClose = {
    attach: function (context, settings) {
      // Set an event for Drupal aJAX.
      $(".site-feedback-thanks").click(function () {
        $(".site-feedback-form").trigger('siteFeedbackPopupClose');
      });

      /*
       Close Popup window.
       */
      $(document).delegate('.site-feedback-form', 'siteFeedbackPopupClose', function () {
        var magnificPopup = $.magnificPopup.instance;

        // Init count.
        var count = 5;

        // Set countdown interval.
        var countInterval = setInterval(countDown, 1000);

        // Count down function.
        function countDown() {
          $(".site-feedback-thanks-countdown").text(count);
          count = count - 1;
          if (count <= 0) {
            clearInterval(countInterval);
          }
        }

        function closePopup() {
          magnificPopup.close();
        }

        // Init process.
        function process() {
          closePopup();
          // Init count down.
          countDown();
          // Open popup.
          magnificPopup.open({
            items: {
              preloader: true,
              src: '#site-feedback-form',
              type: 'inline'
            }
          });
          // Close Pop up.
          setTimeout(function () {
            magnificPopup.close();
          }, 5000);
        }

        process();
      });
    }
  };

})(jQuery, Drupal);
