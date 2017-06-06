(function ($, Drupal, window, document, undefined) {
  Drupal.behaviors.subsiteMenuToggle = {
    attach: function (context, settings) {

      $('.subsite-header__button').attr({
        'role': 'button',
        'aria-controls': 'subsite-naviagtion',
        'aria-expanded': 'false',
        'aria-label': 'subsite navigation menu'
      });

      $(".subsite-header__button").bind('click', function () {
        $(this).next(".subsite-header__list").toggleClass('subsite-header__expanded');
        if ($(this).attr('aria-expanded') == 'false')
          $(this).attr('aria-expanded', 'true');
        else $(this).attr('aria-expanded', 'false');
        $(this).toggleClass('subsite-header__button--expanded');
      });

    }
  };

})(jQuery, Drupal, this, this.document);
