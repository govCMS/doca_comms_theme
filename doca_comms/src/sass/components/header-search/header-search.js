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

  Drupal.behaviors.searchToggle = {
    attach: function() {
      var searchForm  = $('.header-search__form');
      var searchLink  = $('.header-search__icon--link');
      var searchInput = $('.header-search__input');

      // Add aria attributes.
      $(searchLink).attr('role', 'button');
      $(searchLink).attr('aria-controls', 'search-form');
      $(searchLink).attr('aria-expanded', 'false');

      // Open search form helper function.
      var searchOpen = function() {
        $(searchForm).addClass('is-active');
        $(this).attr('aria-expanded', 'true');

        // Wait for the width to transition before setting focus.
        setTimeout(function() {
          $(searchInput).focus();
        }, 250);
      };

      // Close search form helper function.
      var searchClose = function(focusItem) {
        $(searchForm).removeClass('is-active');
        $(searchLink).attr('aria-expanded', 'false');
        $(focusItem).focus();
      };

      // If they click the search link, open the form.
      $(searchLink).click(function() {
        searchOpen();
        return false;
      });

      // If they click the search button, but haven't entered keywords, close it.
      $('.header-search__icon--button').click(function (){
        if (!$(searchInput).val()) {
          searchClose(searchLink);
          return false;
        }
      });

      // If they click outside of the search form when it's open, close it.
      $(document).click(function(e) {
        if( searchForm.hasClass('is-active') && searchForm.has(e.target).length === 0) {
          searchClose(searchLink);
        }
      });

      // If they the search form is focused when not active, open it.
      $(searchInput).focus(function() {
        if(!searchForm.hasClass('is-active')) {
          searchOpen();
        }
      });

      // If they tab or esc without entering keywords, close it.
      $(searchForm).keydown(function(e) {
        var keyCode = e.keyCode || e.which;

        if (!$(searchInput).val() && (keyCode == 9 || keyCode == 27)) {
          var menuLink = $(".header-menu__menu a").first();

          searchClose(menuLink);
          e.preventDefault();
        }
      });
    }
  };

})(jQuery, Drupal);

