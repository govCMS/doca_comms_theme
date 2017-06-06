<?php

/**
 * @file
 * Display Suite 1 column template.
 */
?>
<div class="channel-list__grid-item">
  <a href="<?php print $variables['term_url']; ?>" class="channel-list__grid-inner <?php print $classes;?>">

    <?php if (isset($title_suffix['contextual_links'])): ?>
    <?php print render($title_suffix['contextual_links']); ?>
    <?php endif; ?>

    <?php print $ds_content; ?>
  </a>

  <?php if (!empty($drupal_render_children)): ?>
    <?php print $drupal_render_children ?>
  <?php endif; ?>
</div>
