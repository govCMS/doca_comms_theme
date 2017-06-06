(function ($, Drupal) {

  'use strict';

  Drupal.behaviors.alertSignupForm = {
    attach: function (settings, context) {

      function alertSignupForm() {
        var messageArea = $('.alert-signup__message');
        var alertForm = $('.alert-signup__form');

        // Standard fields.
        var standardFields = {};
        standardFields.EMAIL = $('#st_EMAIL').val();

        // Custom fields.
        var customFields = {};
        if (!Drupal.settings.doca_common.alertHideName) {
          customFields.cu_FULL_NAME = $('#cu_FULL_NAME').val();
        }
        if (!Drupal.settings.doca_common.alertHideNumber) {
          customFields.cu_CONTACT_NUMBER = $('#cu_CONTACT_NUMBER').val();
        }
        customFields.cu_DEPARTMENT_ID = $('#cu_DEPARTMENT_ID').val();

        var mailGroups = Drupal.settings.doca_common.alertMailGroup.split(',');
        var microSite = "http://ssoalerts.e-newsletter.com.au";

        $.getJSON(microSite + "/scripts/subscribe/subscribe.php?callback=?", {
          st: standardFields,
          cu: customFields,
          gr: mailGroups,
          method: 'updategroups',
          format: "json"
        }, function(response) {
          $(alertForm).hide();

          // Show response message.
          switch (response.code) {
            case '000':
              $(messageArea).addClass('messages--status').html(Drupal.settings.doca_common.alertSuccessMessage);
              break;

            case '101':
            case '102':
            case '103':
              $(messageArea).addClass('messages--error').html(response.message);
              break;

            default:
              $(messageArea).addClass('messages--error').html("Sorry it looks like that didn't work. Please try refreshing the page and subscribing again.");
          }
        });
      }

      $('.alert-signup__form').submit(function() {
        alertSignupForm();
        return false;
      });
    }
  };

})(jQuery, Drupal);
