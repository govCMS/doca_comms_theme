<?php

/**
 * @file
 * Default theme implementation to display a term.
 */
?>
<div class="copyright <?php print $classes; ?>">

  <div class="copyright__item">
    <a href="<?php print check_plain($field_license_url[0]['value']); ?>" target="_blank">
      <img src="<?php print check_plain($field_cc_icon[0]['value']); ?>" alt="<?php print $term_name . ' ' . check_plain($field_cc_shortcode[0]['value']); ?>" />
    </a>
  </div>

  <div class="copyright__item">
    <?php print t('Content on this page is licensed under a Creative Commons') . '<br />' . $term_name . ' ' . t('International License'); ?>
  </div>

</div>
