(function ($, Drupal) {

    Drupal.behaviors.onThisPage = {
        attach: function (context, settings) {



            var onThisPage = $(".on-this-page");

            if (onThisPage.length > 0) {

                var toc = $('<ul class="on-this-page__menu"></ul>');

                if(toc.length > 0) {
                    toc = toc.tableOfContents($("[data-js*='on-this-page__content']"), {
                        startLevel: 2,
                        depth: 1,
                        ignoreClass: 'element-invisible'
                    });

                    // Do not display On This Page unless there is more than one header.
                    if ($('li', toc).length > 1) {
                        onThisPage.show();
                        $(onThisPage).html(toc);
                        onThisPage.prepend('<h5 class="on-this-page__title">On this page</h5>');
                    } else {
                        onThisPage.hide();
                    }
                }


            }

        }
    };


    Drupal.behaviors.onThisPageSticky = {
        attach: function (context, settings) {



            var onThisPageMenu = $(".on-this-page__menu");

            function onThisPageStickyOnLargeScreens() {

                if (window.matchMedia("(min-width: 750px)").matches) {
                    onThisPageMenu.stick_in_parent({
                          sticky_class: "on-this-page__sticky",
                          parent: "[data-js*='on-this-page__content']"
                      });
                }
                if (window.matchMedia("(max-width: 750px)").matches) {
                    onThisPageMenu.trigger("sticky_kit:detach");
                }

            }

            onThisPageStickyOnLargeScreens();

            var TO = false;
            $(window).resize(function() {
                if(TO !== false)
                    clearTimeout(TO);
                TO = setTimeout(onThisPageStickyOnLargeScreens, 200);
            });

            $("a[href*=#]:not([href=#])").bind( "click", function() {


                if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') || location.hostname == this.hostname)
                {

                    var target = $(this.hash),
                      headerHeight = onThisPageMenu.height() + 30; // Get fixed header height

                    target = target.length ? target : $('[name=' + this.hash.slice(1) +']');

                    if (target.length)
                    {
                        $('html,body').animate({
                            scrollTop: target.offset().top - headerHeight
                        }, 500);
                        return false;
                    }
                }

            });

        }
    };

})(jQuery, Drupal);
