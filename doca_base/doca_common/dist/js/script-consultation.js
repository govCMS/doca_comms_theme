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
(function($, Drupal) {

  'use strict';

  Drupal.behaviors.formalSubmissionToggle = {
    attach: function() {
      // Attach toggle functionality for Have Your Say webform.

      if ($("[data-js*='webform-toggle']").length > 0) {
        var webform_toggle = $("[data-js*='webform-toggle']");

        $(webform_toggle).once('weformToggle', function() {
          var toggled_form_id = $(this).attr('data-toggle');
          var form = document.getElementById(toggled_form_id);
          $(form).hide();

          $(webform_toggle).click(function() {
            var toggled_form_id = $(this).attr('data-toggle');
            var form = document.getElementById(toggled_form_id);

            $(this).parent().hide();
            $(form).show();
            $('input', form).first().focus();
          });
        });
      }

      if ($('body.node-type-consultation').length) {
        var webform_nid = Drupal.settings.doca_common.webform_nid;
      }
      else {
        var webform_nid = Drupal.settings.doca_common.fund_webform_nid;
      }

      $('#formal-submission-webform #webform-client-form-' + webform_nid + ' input[id*="remain-anonymous"]').change(function() {
        $('#formal-submission-webform #webform-client-form-' + webform_nid + ' input[id*="private-submission"]')
          .attr('checked', false);
        if ($(this).is(":checked")) {
          $('#formal-submission-webform #webform-client-form-' + webform_nid + ' input[id*="hys-formal-your-name"]')
            .val('Anonymous')
            .attr('readonly', true);
        }
        else {
          $('#formal-submission-webform #webform-client-form-' + webform_nid + ' input[id*="hys-formal-your-name"]')
            .val('')
            .attr('readonly', false);
        }
      });
      $('#formal-submission-webform #webform-client-form-' + webform_nid + ' input[id*="private-submission"]').change(function() {
        $('#formal-submission-webform #webform-client-form-' + webform_nid + ' input[id*="remain-anonymous"]')
          .attr('checked', false);
        if ($(this).is(":checked")) {
          $('#formal-submission-webform #webform-client-form-' + webform_nid + ' input[id*="hys-formal-your-name"]')
            .val('Not required - private submission')
            .attr('readonly', true);
        }
        else {
          $('#formal-submission-webform #webform-client-form-' + webform_nid + ' input[id*="hys-formal-your-name"]')
            .val('')
            .attr('readonly', false);
        }
      });
    }
  };

  Drupal.behaviors.formalSubmissionValidation = {
    attach: function(context) {
      var fileUploadsEnabled = Drupal.settings.doca_common.fileUploadsEnabled;
      var shortCommentsEnabled = Drupal.settings.doca_common.shortCommentsEnabled;
      var message = 'It looks like you haven\'t added a submission. Please add a submission to have your say.';
      var shortCommentSelector = 'textarea[name$="[short_comments]"]';
      var firstFileSelector = 'input[name$="formal_uploads_hys_formal_upload_file_1]"]';
      var submittedFileSelector = 'div[id$="formal-uploads-hys-formal-upload-file-1-upload"] > .file';
      if ($('body.node-type-consultation').length) {
        var webform_nid = Drupal.settings.doca_common.webform_nid;
      }
      else {
        var webform_nid = Drupal.settings.doca_common.fund_webform_nid;
      }
      var $forms = $('#webform-client-form-' + webform_nid, context);

      $forms.each(function(index, item) {
        var $form = $(item);
        if (fileUploadsEnabled && !shortCommentsEnabled) {
          $form.find(firstFileSelector).attr('required', 'true');
        }
        else if (shortCommentsEnabled && !fileUploadsEnabled) {
          $form.find(shortCommentSelector).attr('required', 'true');
        }
        else if (shortCommentsEnabled && fileUploadsEnabled) {
          $form.find('.webform-submit').unbind('click.formalSubmissionValidation').bind('click.formalSubmissionValidation', function(o) {
            $form.find('.custom-message').remove();
            // Get fields
            var $filesInput = $form.find(firstFileSelector);
            var $filesSubmitted = $form.find(submittedFileSelector);
            var $shortDescription = $form.find(shortCommentSelector).val();
            var pass = false;
            var has_file = ($filesInput.length > 0 && $filesInput[0].value.length > 0) || $filesSubmitted.length > 0;

            try {
              // Check for at least one field to be populated
              if ($shortDescription.length > 0 || has_file) {
                pass = true;
              }
              if (!pass) {
                // Show error message
                $form.find('.webform-component--step-1-your-submission > .fieldset-wrapper').each(function() {
                  $(this).prepend('<div class="messages--error messages error custom-message">' + message + '</div>');
                  $(window).scrollTop($('.custom-message').position().top);
                });
              }
            }
            catch (e) {
              console.log('An error occured validating form. Allowing to pass. ' + e);
              pass = true;
            }
            return pass;
          });
        }
      });

    }
  };

  Drupal.behaviors.submissionCommentDisplay = {
    attach: function(context) {
      var is_mobile = null;
      var $window = $(window);
      var medium_breakpoint = 720 - 15;
      var accordion = '.document-list__inner--comment';
      var comment_toolbar = '.document-list__comment--comment-docs';
      var accordion_head = '.document-list__comment--comment-link';
      var accordion_body = '.document-list__desc--comment';

      // Set up toggle click
      $(accordion_head, context).bind('click', function() {
        $(this).toggleClass('link-open');
        $(this).closest(accordion).find(accordion_body).toggle();
      });
      // Set up mobile switch
      function windowResize() {
        // 720 - 15px for scrollbar
        if ($window.width() < medium_breakpoint) {
          if (!is_mobile || is_mobile === null) {
            $(accordion_body, context).each(function() {
              var acc_head = $(this).closest(accordion).find(accordion_head);
              $(this).insertAfter(acc_head);
            });
            is_mobile = true;
          }
        }
        else {
          if (is_mobile || is_mobile === null) {
            $(accordion_body, context).each(function() {
              var comm_toolbar = $(this).closest(accordion).find(comment_toolbar);
              $(this).insertAfter(comm_toolbar);
            });
            is_mobile = false;
          }
        }
      }
      $window.resize(windowResize);
      windowResize();
    }
  };

  Drupal.behaviors.uploadMultipleSubmissions = {
    attach: function(context) {
      // Attach toggle functionality for Have Your Say webform.
      $('fieldset[class*="--hys-formal-uploads"]', context).each(function() {

        var $parent = $(this);
        var $files = $parent.children('.fieldset-wrapper').children('div[id*="hys-formal-upload-file-"]');

        function refreshSubmissionView() {
          var currentFileSlot = 0;
          var fileSlots = [];

          $files.each(function(index, item) {
            var $file = $(item).find('input');
            fileSlots.push($file);
            // Find current file slot
            if ($file[0].value !== undefined && $file[0].value.length > 0) {
              currentFileSlot++;
            }
          });

          // Hide unused
          $files.hide();

          for (var i = 0; i < (currentFileSlot + 1); i++) {
            if (fileSlots[i] !== undefined) {
              fileSlots[i].parent().parent().parent().show();
            }
          }
        }
        $files.unbind('change.multi_submission').bind('change.multi_submission', refreshSubmissionView);
        refreshSubmissionView();
      });
    }
  };

  Drupal.behaviors.shortCommentMaxLength = {
    attach: function(context) {
      var maxLengthHandler = function(e) {
        var target = e.target;
        if (target.value.length > 500) {
          target.value = target.value.substring(0, 500);
        }
      };

      $('textarea[name="submitted[step_1_your_submission][short_comments]"]')
        .attr('maxlength', 500)
        .keyup(maxLengthHandler)
        .keydown(maxLengthHandler);
    }
  };

})(jQuery, Drupal);
