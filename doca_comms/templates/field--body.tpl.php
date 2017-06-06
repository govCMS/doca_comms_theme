<?php
/**
 * @file
 * Default template implementation to display the value of a field.
 */
?>
<div class="max-width__content">
  <?php foreach ($items as $delta => $item): ?>
    <?php print render($item); ?>
  <?php endforeach; ?>
</div>
