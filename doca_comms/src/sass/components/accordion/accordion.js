(function ($) {

    $( document ).ready(function() {

        $('.accordion__item').each(function() {
            var $this = $(this);

            // create unique id for a11y relationship

            var id = 'collapsible-' + $this.index();

            $this.children('.accordion__button').attr('aria-controls', id);
            $this.children('.accordion__description').attr('id', id);

        });

        $('.accordion__button').bind('click', function() {
            var state = $(this).attr('aria-expanded') === 'false' ? true : false;
            $(this).attr('aria-expanded', state);
            $(this).next(".accordion__description").attr('aria-hidden', !state);
        });

    });

})(jQuery);
