<?php

/**
 * @file
 * Returns the HTML for a single Drupal page.
 *
 * Complete documentation for this file is available online.
 *
 * @see https://drupal.org/node/1728148
 */
?>
<div class="offscreen__inner header-background">
  <?php if (!empty($top_announcements) && $top_announcements): ?>
    <div class="top-notification" id="top-announcements">
      <div class="top-notification__inner">
        <svg class="top-notification__icon" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
             xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
             width="40px" height="43.99px" viewBox="0 0 50 50" enable-background="new 4 2.01 40 43.99"
             xml:space="preserve">
<path d="M27.98,41.947c0.002,0.019,0.006,0.035,0.006,0.056C27.986,44.21,26.202,46,24,46s-3.987-1.79-3.987-3.997
  c0-0.019,0.005-0.036,0.005-0.056C7.267,41.598,4,39.52,4,37.003c0-0.788,0.344-1.53,1.181-2.194C11.209,28.094,13,29.953,13,20.006
  c0-6.632,0.271-12.712,8.258-13.807C21.1,5.833,21.01,5.431,21.01,5.008c0-1.656,1.339-2.998,2.99-2.998
  c1.65,0,2.99,1.342,2.99,2.998c0,0.423-0.09,0.825-0.248,1.191C34.729,7.294,35,13.374,35,20.006c0,9.977,1.8,8.073,7.872,14.86
  C43.666,35.516,44,36.236,44,37.003C44,39.518,40.646,41.595,27.98,41.947z M24,44.003c1.102,0,1.994-0.896,1.994-1.998
  c0-0.006-0.002-0.012-0.002-0.019c-0.651,0.01-1.297,0.02-1.992,0.02c-0.696,0-1.34-0.01-1.992-0.02
  c0,0.007-0.002,0.013-0.002,0.019C22.006,43.107,22.898,44.003,24,44.003z M24,4.007c-0.551,0-0.996,0.447-0.996,0.999
  c0,0.552,0.445,1,0.996,1s0.997-0.448,0.997-1C24.997,4.454,24.551,4.007,24,4.007z M41.605,36.414c0,0-1.522-1.714-4.019-3.984
  C34.18,29.325,33,27.854,33,20.006c0-7.664-0.418-12-9-12s-9,4.336-9,12c0,7.848-1.18,9.321-4.59,12.428
  c-2.447,2.229-3.986,3.941-3.986,3.941C6,36.712,6,36.908,6,37.003c0,0.123,0.205,3.003,18,3.003s18-2.88,18-3.003
  C42,36.923,42,36.736,41.605,36.414z"/>
          <circle cx="24.094" cy="33.359" r="2.141"/>
          <polygon points="25.474,29.336 22.714,29.336 21.812,12.75 26.375,12.75 "/>
</svg>
        <div class="top-notification__content">
          <?php print theme_get_setting('page_top_announcement_messages'); ?>
        </div>
        <button class="top-notification__close" href="#">
          <span class="element-invisible">Close</span>
          <svg class="top-notification__close-svg" xmlns="http://www.w3.org/2000/svg" version="1.1" id="Layer_1" x="0px"
               y="0px" width="192" height="192" viewBox="0 0 192 192" xml:space="preserve"><polygon class="st0"
                                                                                                    points="160,172.2 244,256 160,339.9 171.8,351.6 255.8,267.8 340.2,352 352,340.3 267.6,256 352,171.8 340.2,160 255.8,244.3 171.8,160.4 "
                                                                                                    id="polygon4188"
                                                                                                    style="fill:#0d293b"
                                                                                                    transform="translate(-160,-160)"/></svg>
        </button>
      </div>
    </div>
  <?php endif; ?>

  <div class="top-notification" id="cookie-alert">
    <div class="top-notification__inner">
      <svg class="top-notification__icon" xmlns="http://www.w3.org/2000/svg" version="1.1" width="127.91687"
           height="127.68849" viewBox="0 0 140 140">
        <path style="fill:#ffffff"
              d="M 36.10054,126.42465 C 14.614748,120.39671 -0.04012547,101.13771 8.2531598e-5,78.98249 0.03250253,61.12068 10.564946,44.02482 26.528886,35.92195 c 5.588021,-2.83633 7.006424,-4.08477 8.457063,-7.44363 2.367169,-5.48103 8.729308,-13.740188 13.539996,-17.577259 27.953127,-22.295806 68.987945,-8.7519348 77.970605,25.734829 1.85476,7.12089 1.89749,17.19347 0.10154,23.93831 -3.45557,12.97776 -13.42852,25.43924 -25.10027,31.36351 -5.556098,2.82013 -6.724418,3.92365 -8.932748,8.43731 -5.47524,11.19099 -14.9247,19.92443 -26.6665,24.64588 -7.113532,2.86039 -22.091095,3.56597 -29.798032,1.40375 z m 19.996851,-4.50277 C 77.920612,117.7832 93.514822,97.69191 91.700562,76.05143 88.611162,39.20112 44.265505,22.788611 18.155771,48.8322 1.5047895,65.441 1.0822275,91.53084 17.188382,108.56072 c 6.451007,6.82099 12.27324,10.33888 20.799832,12.56759 7.713426,2.01616 10.921278,2.15673 18.109177,0.79357 z m -6.063496,-15.42425 c -0.659565,-0.79472 -1.052165,-2.48222 -0.872445,-3.75 0.25827,-1.82187 0.955601,-2.30504 3.326764,-2.30504 2.371163,0 3.068494,0.48317 3.326764,2.30504 0.358031,2.52561 -1.351378,5.19496 -3.326764,5.19496 -0.690311,0 -1.794754,-0.65023 -2.454319,-1.44496 z M 28.532927,95.08347 c -0.970463,-3.05766 0.429711,-5.14088 3.455287,-5.14088 3.025576,0 4.42575,2.08322 3.455287,5.14088 -0.39429,1.2423 -1.540693,1.85912 -3.455287,1.85912 -1.914594,0 -3.060997,-0.61682 -3.455287,-1.85912 z m 34.455285,-5.14088 c -2.675315,-2.67532 -2.521367,-5.56954 0.45455,-8.54546 4.36601,-4.36601 10.54545,-2.05304 10.54545,3.94718 0,6.02475 -6.75131,8.84697 -11,4.59828 z M 27.643202,77.11385 c -0.910244,-1.00581 -1.654988,-3.48081 -1.654988,-5.5 0,-4.74569 2.832577,-7.67126 7.42742,-7.67126 6.383762,0 10.040937,8.53164 5.57258,13 -2.614432,2.61443 -9.046107,2.71152 -11.345012,0.17126 z m 27.390693,-6.61622 c -1.9653,-2.36804 -0.885954,-6.00701 1.898291,-6.40001 2.830518,-0.39953 5.225006,2.2071 4.310286,4.69217 -1.197286,3.25272 -4.233328,4.08787 -6.208577,1.70784 z m 54.821345,8.48269 C 127.10672,61.72885 126.74248,34.4587 109.03499,17.568619 95.313262,4.4803102 77.170932,1.6718272 60.208584,10.010156 53.142263,13.48381 44.976102,21.085845 41.959786,26.99831 l -2.01222,3.94428 8.276926,0 c 4.552309,0 9.830808,0.44565 11.729996,0.99033 2.279564,0.65377 3.789624,0.65377 4.443394,0 2.3965,-2.3965 7.56954,-0.38416 7.6083,2.95967 0.01,0.8525 2.24367,3.00523 4.96398,4.78385 2.72031,1.77862 6.81124,5.60362 9.09097,8.5 4.80677,6.107 5.19733,6.35037 6.89944,4.29945 1.9494,-2.34888 6.76654,-1.88531 9.573088,0.92125 4.46801,4.468 2.44651,11.72939 -3.637338,13.06563 -2.55553,0.56129 -2.98969,1.0502 -2.51241,2.82918 0.31735,1.18285 0.58314,5.87229 0.59065,10.42096 l 0.0137,8.27033 3.944278,-2.01222 c 2.16935,-1.10672 6.18459,-4.25254 8.92275,-6.9907 z M 98.559642,42.37116 c -2.8853,-2.8853 -1.17141,-6.42857 3.109518,-6.42857 3.1513,0 4.41234,4.7274 1.77538,6.65559 -2.35094,1.71905 -2.96749,1.69039 -4.884898,-0.22702 z m -19.32143,-7.95228 c -2.82798,-1.99806 -3.06107,-7.43231 -0.42126,-9.821302 5.62697,-5.092339 13.93658,2.148412 9.42789,8.215182 -2.33779,3.14567 -5.92277,3.78497 -9.00663,1.60612 z"/>
      </svg>
      <div class="top-notification__content">
        <?php print theme_get_setting('cookie_textarea'); ?>
      </div>
      <button class="top-notification__close" href="#">
        <span class="element-invisible">Close</span>
        <svg class="top-notification__close-svg" xmlns="http://www.w3.org/2000/svg" version="1.1" id="Layer_1" x="0px"
             y="0px" width="192" height="192" viewBox="0 0 192 192" xml:space="preserve"><polygon class="st0"
                                                                                                  points="160,172.2 244,256 160,339.9 171.8,351.6 255.8,267.8 340.2,352 352,340.3 267.6,256 352,171.8 340.2,160 255.8,244.3 171.8,160.4 "
                                                                                                  id="polygon4188"
                                                                                                  style="fill:#ffffff"
                                                                                                  transform="translate(-160,-160)"/></svg>
      </button>
    </div>
  </div>

  <header class="header" id="header" role="banner">
    <div class="layout-max">

      <?php if (isset($logo)): ?>
        <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" class="header__logo"
           id="logo">
          <img src="/<?php print path_to_theme(); ?>/logo.svg" alt="<?php print t('Home'); ?>"
               class="header__logo-image"/>
        </a>
      <?php endif; ?>

      <a href="#" class="offscreen__toggle" role="button">Navigation toggle</a>

      <div class="offscreen__item header__item" id="offscreen">
        <?php print render($header_search); ?>
        <?php print render($header_menu); ?>
      </div>

    </div>
  </header>
  <div class="layout-max">
    <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" class="header__inner__logo"></a>
  </div>
  <div id="page" class="spacer--top">
    <?php print render($tabs); ?>

    <?php if (!$is_front): ?>
      <div class="spacer--bottom-mid">
        <?php if ($title): ?>
          <div class="layout-max">
            <?php print $breadcrumb; ?>
          </div>
        <?php endif; ?>
        <?php print render($page['highlighted']); ?>
      </div>
    <?php endif; ?>
    <?php
    if (!$is_front): ?><a id="skip-content" href="#skip-content"></a><?php
    endif;
    ?>
    <div class="main_content" data-js="on-this-page__content responsive-video external-links">

      <?php if ($title): ?>
        <h1 class="<?php print ($is_front) ? 'element-invisible' : 'page__title'; ?>"
            id="page-title"><?php print $title; ?></h1>
      <?php endif; ?>

      <div role="main">
        <a id="main-content"></a>
        <?php print $messages; ?>
        <?php print render($page['help']); ?>
        <?php if ($action_links): ?>
          <ul class="action-links"><?php print render($action_links); ?></ul>
        <?php endif; ?>
        <?php print render($page['content']); ?>
        <!--<a href="#skip-link" class="link-top">Back to top</a>-->
        <?php print $feed_icons; ?>
      </div>

    </div>

    <?php if (theme_get_setting('feedback_enabled') == 1): ?>
      <!-- WEB-4 JZ Start -->
      <div class="site-feedback-block" id="site-feedback-block">
        <div class="site-feedback-block__inner">
          <div class="site-feedback-block__content">
            <p>Was this page helpful?</p>
          </div>
          <div class="site-feedback-block__simple">
            <a href="#" class="site-feedback-action" data-option="1">Yes</a>
            <span class="divider">/</span>
            <a href="#" class="site-feedback-action" data-mfp-src="#site-feedback-form" data-option="0">No</a>
          </div>
        </div>
      </div>
      <div id="site-feedback-form" class="site-feedback-form mfp-hide">
        <div class="site-feedback-form__content">
          <?php print render($page['site_pages_feedback_form']); ?>
        </div>
      </div>
      <!-- WEB-4 JZ End -->
    <?php endif; ?>

    <?php if (theme_get_setting('external_link_enable_popup') == 1): ?>
      <!-- External link popup window -->
      <div id="external-link-popup-content" class="external-link-popup mfp-hide">
        <h2>Goodbye</h2>
        <div class="external-link-popup__content">
          <?php
          print theme_get_setting('external_link_popup_text');
          ?>
          <div>
            <ul>
              <li><a href="#" id="external-link-action-cancel">Cancel</a></li>
              <li><a href="#" id="external-link-action-continue">Continue</a></li>
            </ul>
          </div>
        </div>
      </div>
    <?php endif; ?>
    <img class="iefix" src="<?php print path_to_theme(); ?>/dist/images/bg--point--black.svg">
    <?php print render($page['footer_top']); ?>
    <div class="footer__wrapper">

      <div class="layout-max spacer--vertical center-left">

        <div class="spacer--medium show-at__medium"><?php print render($footer_menu); ?></div>
        <div class="spacer clearfix">
          <h2 class="footer__heading"><?php print t('Connect with the Department'); ?></h2>
          <ul class="list-inline">
            <li class="list-inline__item"><a href="https://twitter.com/artsculturegov" target="_blank"
                                             class="underline-on-hover__never"><img
                  src="<?php print base_path() . drupal_get_path('theme', 'doca_common'); ?>/dist/images/social/twitter.svg"
                  alt="Follow @artsculturegov on Twitter"/></a></li>
            <li class="list-inline__item"><a href="https://www.youtube.com/user/deptcommsau" target="_blank"
                                             class="underline-on-hover__never"><img
                  src="<?php print base_path() . drupal_get_path('theme', 'doca_common'); ?>/dist/images/social/youtube.svg"
                  alt="Watch deptcommsau on YouTube"/></a></li>
          </ul>
        </div>
        <div class="spacer--medium"><?php print render($page['footer_bottom']); ?></div>
      </div>
      <div class="footer__border">
        <div class="layout-max spacer--large center-left">
          <div class="copyright">
            <div class="copyright__left">
              <div class="copyright__item">
                <a href="http://creativecommons.org/licenses/by/3.0" target="_blank">
                  <img class="copyright__icon"
                       src="<?php print base_path() . drupal_get_path('theme', 'doca_common'); ?>/dist/images/cc_logo.png"
                       alt="Attribution CC BY"/>
                </a>
              </div>
              <div
                class="copyright__item"><?php print t('This work is licensed under a Creative Commons') . ' <br />' . t('Attribution 3.0 International License'); ?></div>
            </div>
            <div class="copyright__right">
              <?php print render($footer_auxilary_menu); ?>
              <div><?php print t('&copy; Department of Communications and the Arts') . ' ' . date('Y'); ?></div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <?php print render($page['bottom']); ?>

</div>
