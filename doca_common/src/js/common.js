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

  Drupal.behaviors.skipLink = {
    attach: function() {
      setTimeout(function() {
        var firstElement = $('#skip-link').siblings().first();
        $(firstElement).before($('#skip-link'));
      }, 2100);

      $('#skip-link').click(function() {
        $('#skip-content').focus();
      });
    }
  };

  Drupal.behaviors.twitterFeed = {
    attach: function() {
      setTimeout(function() {
        $("iframe[id^=twitter-widget-").each(function() {
          var head = $(this).contents().find('head');
          if (head.length) {
            head.append('<style type="text/css">.timeline { max-width: none !important; width: 100% !important; } .timeline .stream { max-width: none !important; width: 100% !important; } </style>');
          }
        });
      }, 2000);
    }
  };

  Drupal.behaviors.iframeLinks = {
    attach: function(context) {
      $('.view-consultations-iframe', context).find('a').each(function() {
        var $this = $(this);
        if (!$this.is('[target]')) {
          $this.attr('target', '_parent');
        }
      });
    }
  };

  Drupal.behaviors.streamLinks = {
    attach: function(context) {
      var filepath = "/" + Drupal.settings.pathToTheme + "/dist/images/icons/stream/";
      $('.channel-list__grid-item a', context).each(function() {
        var imgSrc = $(this).find('img').attr('src');
        var imgSrc_o = imgSrc;
        var parts = imgSrc.split('/');
        imgSrc = parts[parts.length - 1];
        var imgSrc_h = imgSrc.replace('.svg', '_h.svg');
        imgSrc_h = filepath + imgSrc_h;
        var imgSrc_a = imgSrc.replace('.svg', '_a.svg');
        imgSrc_a = filepath + imgSrc_a;
        $(this).hover(function() {
          $(this).find('img').attr('src', imgSrc_h);
        }, function() {
          $(this).find('img').attr('src', imgSrc_o);
        });
        $(this).mousedown(function() {
          $(this).find('img').attr('src', imgSrc_a);
        });
        $(this).mouseup(function() {
          $(this).find('img').attr('src', imgSrc_o);
        });
      })
    }
  };
  Drupal.behaviors.qanda = {
    attach: function(context) {
      $('#qa-expand', context).bind('click', function(e) {
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

  Drupal.behaviors.caption_hover = {
    attach: function(context) {
      var is_touch_screen = 'ontouchstart' in document.documentElement;
      if (!is_touch_screen) {
        $('.featured-with-caption', context).hover(function() {
          $(this).find('.featured-overlay').fadeIn(100);
          $(this).closest('div.node').css('overflow', 'visible');
        }, function() {
          $(this).find('.featured-overlay').fadeOut(100);
          $(this).closest('div.node').css('overflow', 'hidden');
        })
      }
    }
  };

  Drupal.behaviors.ga = {
    attach: function(context) {
      // Only set up GA tracking and custom event bindings once.
      $('body', context).once('gaBehavior', function() {
        // Grab appropriate GA code for the active environment.
        var gaCode = Drupal.settings.gaSettings.gaCode;

        // Add GA magic.
        (function(i, s, o, g, r, a, m) {
          i["GoogleAnalyticsObject"] = r;
          i[r] = i[r] || function() {
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

        // GTM tracking. If GTM is used - it will use GA tracker created by this module and send Pageview later. If GTM is not used - send Pageview right now
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
        $('.webform-client-form').submit(function(event) {
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

  Drupal.behaviors.tables = {
    attach: function(context) {
      if ($('.tablesaw').length > 0) {
        $(".tablesaw tbody tr:even").addClass("tr-even");
      }
    }
  };

})(jQuery, Drupal);

jQuery.extend({
  getUrlVars: function() {
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
  getUrlVar: function(name) {
    return $.getUrlVars()[name];
  }
});
