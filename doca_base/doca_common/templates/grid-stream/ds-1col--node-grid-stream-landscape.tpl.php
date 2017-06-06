<?php

/**
 * @file
 * Display Suite 1 column template.
 */
?>
<<?php print $ds_content_wrapper;
print $layout_attributes; ?> class="ds-1col <?php print $classes; ?> clearfix">

<?php if (isset($title_suffix['contextual_links'])): ?>
  <?php print render($title_suffix['contextual_links']); ?>
<?php endif; ?>

<div class="grid-stream__has-update">
  <?php print $ds_content; ?>
</div>

<?php if (!empty($update_1) && !empty($update_2)): ?>
  <div class="update--extra__wrapper">
    <?php print render($update_1); ?>
    <?php print render($update_2); ?>
  </div>
<?php endif; ?>

</<?php print $ds_content_wrapper ?>>


<?php print render($field_updates[0]); ?>

<?php if (!empty($drupal_render_children)): ?>
  <?php print $drupal_render_children ?>
<?php endif; ?>
