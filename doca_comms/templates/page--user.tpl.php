<?php
/**
 * @file
 * Returns the HTML for a single Drupal page.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728148
 */
?>
<div class="offscreen__inner <?php print ($is_front) ? 'header-background--blue' : 'header-background'; ?>">

<header class="header" id="header" role="banner">
  <div class="layout-max">

    <?php if (isset($logo)): ?>
        <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" class="header__logo" id="logo">
          <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" class="header__logo-image" />
        </a>
    <?php endif; ?>

    <a href="#" class="offscreen__toggle" role="button">Navigation toggle</a>
    <div class="offscreen__item header__item" id="offscreen">
      <?php print render($header_search); ?>
      <?php print render($header_menu); ?>
    </div>

  </div>
</header>

<div id="page" class="spacer--top-mid">
  <?php print render($tabs); ?>

  <div class="spacer--bottom-mid">
    <?php if ($title): ?>
      <div class="layout-max spacer">
        <?php print $breadcrumb; ?>
      </div>
    <?php endif; ?>
    <?php print render($page['highlighted']); ?>
  </div>

  <div class="main_content layout-max" data-js="on-this-page__content responsive-video external-links">

    <?php if ($title): ?>
      <h1 class="<?php print ($is_front) ? 'element-invisible' : 'page__title'; ?>" id="page-title"><?php print $title; ?></h1>
    <?php endif; ?>

    <div role="main" class="spacer--large">
      <!--<a href="#skip-link" class="element-focusable" id="skip-content">Back to top</a>-->
      <a id="main-content"></a>
      <?php print $messages; ?>
      <?php print render($page['help']); ?>
      <?php if ($action_links): ?>
        <ul class="action-links"><?php print render($action_links); ?></ul>
      <?php endif; ?>
      <?php print render($page['content']); ?>
      <?php print $feed_icons; ?>
    </div>

  </div>

  <?php print render($page['footer_top']); ?>
  <div class="footer__wrapper">

    <div class="layout-max spacer--vertical center-left">

      <div class="spacer--medium show-at__medium"><?php print render($footer_menu); ?></div>
      <div class="spacer clearfix">
        <h2 class="footer__heading"><?php print t('Connect with the Department'); ?></h2>
        <ul class="list-inline">
          <li class="list-inline__item"><a href="https://twitter.com/CommsAu" target="_blank" class="underline-on-hover__never"><img src="<?php print base_path() . drupal_get_path('theme', 'dcomms_theme'); ?>/images/social/twitter.svg" alt="Follow @CommsAu on Twitter" /></a></li>
          <li class="list-inline__item"><a href="https://www.youtube.com/user/deptcommsau" target="_blank" class="underline-on-hover__never"><img src="<?php print base_path() . drupal_get_path('theme', 'dcomms_theme'); ?>/images/social/youtube.svg" alt="Watch deptcommsau on YouTube" /></a></li>
          <li class="list-inline__item"><a href="https://www.linkedin.com/company/commsau" target="_blank" class="underline-on-hover__never"><img src="<?php print base_path() . drupal_get_path('theme', 'dcomms_theme'); ?>/images/social/linkedin.svg" alt="Follow commsau on LinkedIn" /></a></li>
        </ul>
      </div>
      <div class="spacer--medium"><?php print render($page['footer_bottom']); ?></div>

      <div class="spacer--large footer__border"><div class="copyright">
          <div class="copyright__left">
            <div class="copyright__item">
              <a href="http://creativecommons.org/licenses/by/3.0" target="_blank">
                <img class="copyright__icon" src="https://i.creativecommons.org/l/by/3.0/88x31.png" alt="Attribution CC BY" />
              </a>
            </div>
            <div class="copyright__item"><?php print t('This work is licensed under a Creative Commons') . ' <br />' . t('Attribution 3.0 International License'); ?></div>
          </div>
          <div class="copyright__right">
            <?php print render($footer_auxilary_menu); ?>
            <div><?php print t('&copy; Department of Communications and the Arts') . ' ' . date('Y'); ?></div>
          </div>
        </div></div>

    </div>

  </div>

</div>

<?php print render($page['bottom']); ?>

</div>
