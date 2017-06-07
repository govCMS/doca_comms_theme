var year_toggled = false;
var cat_toggled = false;
var winner_val = "All";

(function ($, Drupal) {

  'use strict';

  /**
   *
   * @type {{attach: attach}}
   */
  Drupal.behaviors.books = {
    attach: function (context) {

      if ($('.view-book-search').length > 0) {

        // The winners select list keeps resetting, this code ensures it's value
        // is maintained across ajax calls.
        if ($('.view-filters [name="field_winner_value"]')
                .val() != winner_val) {
          $('.view-filters [name="field_winner_value"]')
              .val(winner_val)
              .change();
        }
        $('.view-filters [name="field_winner_value"]')
            .bind('change', function () {
              winner_val = $('.view-filters [name="field_winner_value"]').val();
            });

        function removeThrobber() {
          $('.ajax-progress-throbber').remove();
        }

        function addThrobber(element) {
          removeThrobber();
          element.after('<div class="ajax-progress ajax-progress-throbber"><div class="throbber">&nbsp;</div></div>');
        }

        function disableFilters() {
          $('.view-filters [name="field_winner_value"]')
              .attr('disabled', 'disabled');
          $('.view-filters [id^="filter-wrapper-bookyear-tid"] input')
              .attr('disabled', 'disabled');
          $('.view-filters [id^="filter-wrapper-booktype-tid"] input')
              .attr('disabled', 'disabled');
          $('.view-filters .manual [name="combine"]')
              .attr('disabled', 'disabled');
        }

        var textHeight;
        if ($('#edit-combine').val() != '') {
          $('.views-row.book').each(function () {
            textHeight = $(this)
                    .find('.book-details__overlay')
                    .outerHeight() + 20;
            $(this).find('.views-field-field-thumbnail').css('top', textHeight);
          })
        }
        else {
          $('.views-row.book').hover(function () {
            textHeight = $(this)
                    .find('.book-details__overlay')
                    .outerHeight() + 20;
            $(this).find('.views-field-field-thumbnail').animate({
              top: textHeight
            }, 200);
          }, function () {
            $(this).find('.views-field-field-thumbnail').animate({
              top: 0
            }, 200);
          });
        }

        var year_open = false
        var cat_open = false;

        // Ensure all the category and year select options are available as
        // checkboxes.
        $('#category-wrapper').ready(function () {
          if ($('#filter-wrapper-booktype-tid').length) {
            $('#filter-wrapper-booktype-tid').remove();
          }
          var $checkboxes = '<div class="filter" id="filter-wrapper-booktype-tid"><label class="filter__label" id="label-field-book-type-tid_cb" for="edit-field-book-type-tid_cb">Categories</label>'
          $checkboxes += '<div id="edit-field-book-type-tid_cb" class="form-checkboxes">';
          $('#category-wrapper').find('select option').each(function (i) {
            $checkboxes += '<div class="form-item form-type-checkbox">';
            var value = $(this).val();
            $checkboxes += '<input type="checkbox" id="id-' + value + '" name="field_book_type_tid_check[]" value="' + value + '" class="form-checkbox"';
            if ($(this).attr('selected')) {
              $checkboxes += ' checked';
              cat_open = true;
            }
            $checkboxes += '>';
            $checkboxes += '<label class="option" for="id-' + value + '">' + $(this)
                    .text() + '</label></div>';
          });
          $checkboxes += '</div></div>';
          $('[id^="views-exposed-form-book-search-default"], [id^="views-exposed-form-book-search-book-search"]')
              .after($checkboxes);
          $('#edit-field-book-type-tid_cb')
              .find(':checkbox')
              .bind('change', function () {
                disableFilters();
                addThrobber($('.filter.manual .form-submit'))
                if ($(this).attr('checked')) {
                  $('#category-wrapper')
                      .find('select option[value="' + $(this)
                              .attr('id')
                              .replace('id-', '') + '"]' +
                          '')
                      .selected(true)
                      .change();
                }
                else {
                  $('#category-wrapper')
                      .find('select option[value="' + $(this)
                              .attr('id')
                              .replace('id-', '') + '"]' +
                          '')
                      .selected(false)
                      .change();
                }
              });
        });
        $('#year-wrapper').ready(function () {
          if ($('#filter-wrapper-bookyear-tid').length) {
            $('#filter-wrapper-bookyear-tid').remove();
          }
          var $checkboxes = '<div class="filter" id="filter-wrapper-bookyear-tid"><label class="filter__label" for="edit-form-item-field-book-year-tid">Year</label>'
          $checkboxes += '<div id="edit-form-item-field-book-year-tid" class="form-checkboxes">';
          $('#year-wrapper').find('select option').each(function (i) {
            $checkboxes += '<div class="form-item form-type-checkbox">';
            var value = $(this).val();
            $checkboxes += '<input type="checkbox" id="id-' + value + '" name="field_book_year_tid_check[]" value="' + value + '" class="form-checkbox"';
            if ($(this).attr('selected')) {
              $checkboxes += ' checked';
              year_open = true;
            }
            $checkboxes += '>';
            $checkboxes += '<label class="option" for="id-' + value + '">' + $(this)
                    .text() + '</label></div>';
          });
          $checkboxes += '</div></div>';
          $('[id^="views-exposed-form-book-search-default"], [id^="views-exposed-form-book-search-book-search"]')
              .after($checkboxes);

          $('#edit-form-item-field-book-year-tid')
              .find(':checkbox')
              .bind('change', function () {
                disableFilters();
                addThrobber($('.filter.manual .form-submit'))
                if ($(this).attr('checked')) {
                  $('#year-wrapper')
                      .find('select option[value="' + $(this)
                              .attr('id')
                              .replace('id-', '') + '"]' +
                          '')
                      .selected(true)
                      .change();
                }
                else {
                  $('#year-wrapper')
                      .find('select option[value="' + $(this)
                              .attr('id')
                              .replace('id-', '') + '"]' +
                          '')
                      .selected(false)
                      .change();
                }
              });
        });

        // Manually make the search textbox not ajax submit.
        $('.filter.manual [name="combine"]')
            .val($('form .filter [name="combine"]').val());
        $('.filter.manual [name="combine"]').blur(function () {
          $('form .filter [name="combine"]')
              .val($('.filter.manual [name="combine"]').val());
        });
        $('.filter.manual [name="combine"]').bind("keypress", function (e) {
          if (e.which == 13) {
            disableFilters();
            $('form .filter [name="combine"]')
                .val($('.filter.manual [name="combine"]').val());
            addThrobber($('.filter.manual .form-submit'))
            $('form .filter [name="combine"]').change();
          }
        });
        $('.filter.manual .form-submit').bind("keypress", function (e) {
          if (e.which == 13) {
            disableFilters();
            addThrobber($('.filter.manual .form-submit'))
            $('form .filter [name="combine"]').change();
          }
        });
        $('.filter.manual .form-submit').bind("click", function (e) {
          disableFilters();
          addThrobber($('.filter.manual .form-submit'))
          $('form .filter [name="combine"]').change();
        });

        // If the year / category have selected items, leave the fieldset open.
        if (cat_open || cat_toggled) {
          $('.filter__label[for="edit-field-book-type-tid_cb"]')
              .toggleClass('open');
          $('.filter__label[for="edit-field-book-type-tid_cb"]')
              .next()
              .toggleClass('open');
        }
        if (year_open || year_toggled) {
          $('.filter__label[for="edit-form-item-field-book-year-tid"]')
              .toggleClass('open');
          $('.filter__label[for="edit-form-item-field-book-year-tid"]')
              .next()
              .toggleClass('open');
        }
        // Years / category expand-collapse.
        $('.filter__label[for="edit-form-item-field-book-year-tid"], .filter__label[for="edit-field-book-type-tid_cb"]')
            .bind('click', function () {
              $(this).toggleClass('open');
              $(this).next().toggleClass('open');
              if ($(this).text() == "Year") {
                year_toggled = !year_toggled;
              }
              else {
                cat_toggled = !cat_toggled;
              }
            });
      }
      // Set correct labels for authors & illustrators.
      $('.book-author').each(function () {
        if ($(this).find('.field-name-field-pbundle-subtitle').length > 1) {
          $(this).find('.pmla_author').html('Authors: ');
        }
        if ($(this).find('.field-name-field-pbundle-subtitle').length == 0) {
          $(this).find('.pmla_author').html('');
        }
      });
      $('.book-illustrator').each(function () {
        if ($(this).find('.field-name-field-pbundle-subtitle').length > 1) {
          $(this).find('.pmla_illustrator').html('Illustrators: ');
        }
        if ($(this).find('.field-name-field-pbundle-subtitle').length == 0) {
          $(this).find('.pmla_illustrator').html('');
        }
      });

      // Set no result message.
      if ($('.layout-sidebar__main > .view-empty').length > 0) {
        var message_set = false;
        if ($('#edit-combine').val() == '') {
          var $isCurrentYr = 0;
          var $selectedCat = $('#edit-field-book-type-tid option:selected').length;
          var $selectedYear = $('#edit-field-book-year-tid option:selected').length;

          if ($selectedYear > 0) {
            var $current_yr = new Date().getFullYear();
            var $year_val = '';

            $('#edit-field-book-year-tid option:selected').each(function (i) {
              if ($('#edit-field-book-year-tid option:selected').length == 1 && $(this)
                      .text() == $current_yr && $('select[name="field_winner_value"]')
                      .val() == 1) {
                $('#no-yr').show();
                message_set = true;
                $isCurrentYr = 1;
                return false;
              }
              if (i < ($selectedYear - 1)) {
                $year_val += $(this).filter(':selected').text() + ', ';
              }
              else {
                $year_val += $(this).filter(':selected').text();
              }
            });
            $('.view-empty span:last-child').text(' in ' + $year_val);
          }

          if (($selectedCat > 0) && ($isCurrentYr == 0)) {
            var $cat_name = ''
            $('#edit-field-book-type-tid option:selected').each(function (i) {

              if (i < ($selectedCat - 1)) {
                $cat_name += $(this).filter(':selected').text() + ', ';
              }
              else {
                $cat_name += $(this).filter(':selected').text();
              }
            });
            $('.view-empty span:first-child').html(' ' + $cat_name + ' ');
            $('#no-cat').show();
            message_set = true;
          }
        }
        if (!message_set) {
          $('#no-res').show();
        }

      }
    }
  };

  /**
   *
   * @type {{attach: attach}}
   */
  Drupal.behaviors.skipLink = {
    attach: function () {
      setTimeout(function () {
        var firstElement = $('#skip-link').siblings().first();
        $(firstElement).before($('#skip-link'));
      }, 2100);

      $('#skip-link').click(function () {
        $('#skip-content').focus();
      });
    }
  };

  /**
   *
   * @type {{attach: attach}}
   */
  Drupal.behaviors.iframeLinks = {
    attach: function (context) {
      $('.view-consultations-iframe', context).find('a').each(function () {
        var $this = $(this);
        if (!$this.is('[target]')) {
          $this.attr('target', '_parent');
        }
      });
    }
  };

  /**
   *
   * @type {{attach: attach}}
   */
  Drupal.behaviors.qanda = {
    attach: function (context) {
      $('#qa-expand', context).bind('click', function (e) {
        e.preventDefault();
        if ($(this).hasClass('open-all')) {
          $(this).removeClass('open-all');
          $(this).html('Expand all <span>+</span>');
          $('.accordion__button[aria-expanded="true"]').click();
        }
        else {
          $(this).addClass('open-all');
          $(this).html('Collapse all <span>-</span>');
          $('.accordion__button[aria-expanded="false"]').click();
        }

      })
    }
  };

  /**
   *
   * @type {{attach: attach}}
   */
  Drupal.behaviors.caption_hover = {
    attach: function (context) {
      var is_touch_screen = 'ontouchstart' in document.documentElement;
      if (!is_touch_screen) {
        $('.featured-with-caption', context).hover(function () {
          $(this).find('.featured-overlay').fadeIn(100);
          $(this).closest('div.node').css('overflow', 'visible');
        }, function () {
          $(this).find('.featured-overlay').fadeOut(100);
          $(this).closest('div.node').css('overflow', 'hidden');
        })
      }
    }
  };

  /**
   *
   * @type {{attach: attach}}
   */
  Drupal.behaviors.ga = {
    attach: function (context) {
      // Only set up GA tracking and custom event bindings once.
      $('body', context).once('gaBehavior', function () {
        // Grab appropriate GA code for the active environment.
        var gaCode = Drupal.settings.gaSettings.gaCode;

        // Add GA magic.
        (function (i, s, o, g, r, a, m) {
          i["GoogleAnalyticsObject"] = r;
          i[r] = i[r] || function () {
                (i[r].q = i[r].q || []).push(arguments)
              }, i[r].l = 1 * new Date();
          a = s.createElement(o), m = s.getElementsByTagName(o)[0];
          a.async = 1;
          a.src = g;
          m.parentNode.insertBefore(a, m)
        })(window, document, "script", "//www.google-analytics.com/analytics.js", "ga");
        ga("create", gaCode, {
          "cookieDomain": "auto"
        });

        // GTM tracking. If GTM is used - it will use GA tracker created by
        // this module and send Pageview later. If GTM is not used - send
        // Pageview right now
        ga("set", "page", location.pathname + location.search + location.hash);
        var isGTMUsed = true;
        if (!isGTMUsed) {
          ga("send", "pageview");
        }
        ga('create', gaCode, 'auto', {
          'name': 'govcms'
        });
        ga('govcms.send', 'pageview', {
          'anonymizeIp': true
        });

        // Track frontend webform submisions as custom events.
        $('.webform-client-form').submit(function (event) {
          // Wrap the form in a jQuery object.
          var $form = $(this);
          ga('send', {
            hitType: 'event',
            eventCategory: 'webform',
            eventAction: 'submit',
            // Pass the form ID as the label argument.
            eventLabel: $form.attr('id'),
          });
        });
      });
    }
  };

  /**
   *
   * @type {{attach: attach}}
   */
  Drupal.behaviors.tables = {
    attach: function (context) {
      if ($('.tablesaw').length > 0) {
        $(".tablesaw tbody tr:even").addClass("tr-even");
      }
    }
  };


})(jQuery, Drupal);

jQuery.extend({
  getUrlVars: function () {
    var vars = [],
        hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for (var i = 0; i < hashes.length; i++) {
      hash = hashes[i].split('=');
      vars.push(hash[0]);
      vars[hash[0]] = hash[1];
    }
    return vars;
  },
  getUrlVar: function (name) {
    return $.getUrlVars()[name];
  }
});
