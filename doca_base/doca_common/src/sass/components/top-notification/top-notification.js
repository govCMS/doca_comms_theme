(function ($) {

  'use strict';

  function topNavigationClosed(closed, object) {
    var allObjectIDs = [];
    var clickedObjectID = '';

    // Setup the get parent ID(s).
    if (!object) {
      object = '.top-notification';
      $(object).each(function() {
        allObjectIDs.push($(this).attr('id'));
      });
    } else {
      object = $(object).parent().parent();
      clickedObjectID = $(object).attr('id');
    }

    // Hide the one clicked closed.
    if (closed === true) {
      localStorage.setItem(clickedObjectID, 1);
      $(object).hide();
    }

    // Check local storage if any have been closed before.
    jQuery.each(allObjectIDs, function(index, singleObjectID) {
      var object = document.getElementById(singleObjectID);
      if (localStorage.getItem(singleObjectID) != 1) {
        $(object).show();
      } else {
        $(object).hide();
      }
    });

  }

  $("document").ready(function() {
    // Add special message for older IE versions.
    if ($('html').hasClass('lt-ie9')) {
      var oldIE_alert = $('.top-notification').clone().prependTo('.offscreen__inner');
      $(oldIE_alert).addClass('top-notification--alert');
      $(oldIE_alert).attr('id', 'oldIE-alert');
      $('.top-notification__content', oldIE_alert).html('Our website has been optimised for display on IE9 and above and it looks like you have an older version. This just means that some elements of this website will display or behave unexpectedly.');
      $('.top-notification__icon', oldIE_alert).remove();
    }

    // Control message visibility.
    topNavigationClosed();
    $(".top-notification__close").click(function() {
      topNavigationClosed(true, this);
    });
  });

})(jQuery);
