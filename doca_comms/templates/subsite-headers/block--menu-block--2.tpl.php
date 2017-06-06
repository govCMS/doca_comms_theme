<?php
/**
 * @file
 * Default theme implementation for blocks.
 */
?>
<div class="subsite-header subsite--digibus">
  <div class="subsite-header__branding">
    <div class="subsite-header__layout">
      <a href="<?php print base_path() . drupal_get_path_alias('taxonomy/term/20'); ?>" class="subsite-header__logo-large">
        <img src="<?php print base_path() . drupal_get_path('theme', 'dcomms_theme'); ?>/images/example-svgs/business-area/digibus--large.svg" alt="Logo" />
      </a>
    </div>

    <div class="subsite-header__layout--small">
      <a href="<?php print base_path() . drupal_get_path_alias('taxonomy/term/20'); ?>" class="subsite-header__logo-small">
        <img class="subsite-header__logo-small " src="<?php print base_path() . drupal_get_path('theme', 'dcomms_theme'); ?>/images/example-svgs/business-area/digibus--small.svg" alt="Logo" />
      </a>

      <nav class="subsite-header__nav" role="navigation" id="subsite-naviagtion">
        <button class="subsite-header__button">
          <span class="subsite-header__button-link"><?php print t('Topics'); ?></span>
          <svg xmlns="http://www.w3.org/2000/svg" class="subsite-header__arrow" viewbox="0 0 512 512" preserveaspectratio="xMinYMin" width="512" height="512" version="1"><path style="line-height:125%;-inkscape-font-specification:Serif Italic" d="M256 422.128l76.255-76.256L512 166.128l-76.255-76.256L256 269.617 76.255 89.872 0 166.128l179.745 179.744L256 422.128z" font-size="1353.902" font-style="italic" letter-spacing="0" word-spacing="0" font-family="Serif"/></svg>
        </button>
        <?php print render($content); ?>
      </nav>
    </div>
   </div>
 </div>
