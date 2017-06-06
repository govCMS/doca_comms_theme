<?php
/**
 * @file
 * Default template implementation to display the value of a field.
 */
?>
<div class="grid-stream__item--vertical__top">
  <?php foreach ($items as $delta => $item): ?>
    <?php print render($item); ?>
  <?php endforeach; ?>
</div>
