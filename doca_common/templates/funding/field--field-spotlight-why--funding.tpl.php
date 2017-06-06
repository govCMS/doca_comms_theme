<?php
/**
 * @file
 * Default template implementation to display the value of a field.
 */
?>
<div class="spacer--bottom spotlight-alt__icon">
  <img src="/<?php print path_to_theme(); ?>/dist/images/icons/spotlight/fs_spotlight1.png">
</div>
<div class="heading--5">
  <?php foreach ($items as $delta => $item): ?>
    <?php print render($item); ?>
  <?php endforeach; ?>
</div>
