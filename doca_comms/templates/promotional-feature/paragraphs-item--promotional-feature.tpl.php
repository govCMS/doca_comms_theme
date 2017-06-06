<?php
/**
 * @file
 * Default theme implementation for a single paragraph item.
 */
?>

<div class="<?php print $classes; ?> promotional-feature--dark">
  <div class="promotional-feature__item">
    <?php print render($content['field_optional_components']); ?>
  </div>
</div>
