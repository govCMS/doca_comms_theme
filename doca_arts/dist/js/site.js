(function ($, Drupal) {

  'use strict';

  Drupal.behaviors.site = {
    attach: function () {
      // Custom site scripts.
    }
  };

  /**
   * Stream icons hover effect.
   *
   * @type {{attach: attach}}
   */
  Drupal.behaviors.streamLinks = {
    attach: function (context) {
      var filepath = "/" + Drupal.settings.pathToTheme + "/dist/images/icons/stream/";
      $('.channel-list__grid-item a', context).each(function () {
        var imgSrc = $(this).find('img').attr('src');
        var imgSrc_o = imgSrc;
        var parts = imgSrc.split('/');
        imgSrc = parts[parts.length - 1];
        var imgSrc_h = imgSrc.replace('.svg', '_h.svg');
        imgSrc_h = filepath + imgSrc_h;
        var imgSrc_a = imgSrc.replace('.svg', '_a.svg');
        imgSrc_a = filepath + imgSrc_a;
        $(this).hover(function () {
          $(this).find('img').attr('src', imgSrc_h);
        }, function () {
          $(this).find('img').attr('src', imgSrc_o);
        });
        $(this).mousedown(function () {
          $(this).find('img').attr('src', imgSrc_a);
        });
        $(this).mouseup(function () {
          $(this).find('img').attr('src', imgSrc_o);
        });
      })
    }
  };

  /**
   * Arts site sign up form.
   *
   * @type {{attach: attach}}
   */
  Drupal.behaviors.artsSignupForm = {
    attach: function () {

      function artsSignupForm() {
        var messageArea = $('.alert-signup__message');
        var alertForm = $('.alert-signup__form');

        // Standard fields.
        var standardFields = {};
        standardFields.EMAIL = $('#st_EMAIL').val();

        // Custom fields.
        var customFields = {};
        if (Drupal.settings.doca_common.alertHideName === '0') {
          if (Drupal.settings.doca_common.alertFullName === '0') {
            standardFields.FIRST_NAME = $('#st_FIRST_NAME').val();
            standardFields.LAST_NAME = $('#st_LAST_NAME').val();
          }
          else {
            customFields.cu_FULL_NAME = $('#cu_FULL_NAME').val();
          }
        }
        if (!Drupal.settings.doca_common.alertHideNumber) {
          customFields.cu_CONTACT_NUMBER = $('#cu_CONTACT_NUMBER').val();
        }
        customFields.cu_DEPARTMENT_ID = $('#cu_DEPARTMENT_ID').val();

        var mailGroups = Drupal.settings.doca_common.alertMailGroup.split(',');
        var microSite = Drupal.settings.doca_common.microSite;
        var apicall = Drupal.settings.doca_common.apicall;
        var errorMessage = Drupal.settings.doca_common.errorMessage;

        $.getJSON(microSite + "/scripts/subscribe/subscribe.php?callback=?", {
          st: standardFields,
          cu: customFields,
          gr: mailGroups,
          method: apicall,
          format: "json"
        }, function (response) {
          $(alertForm).hide();

          // Show response message.
          switch (response.code) {
            case '000':
              $(messageArea).addClass('messages--status').html(Drupal.settings.doca_common.alertSuccessMessage);
              break;

            case '101':
            case '102':
            case '103':
              $(messageArea).addClass('messages--error').html(errorMessage + '<br/><strong>Error:</strong> ' + response.message);
              break;

            default:
              $(messageArea).addClass('messages--error').html(errorMessage);
          }
        });
      }

      $('.alert-signup__form').submit(function (e) {
        e.preventDefault();
        artsSignupForm();
        return false;
      });

    }
  };

})(jQuery, Drupal);
