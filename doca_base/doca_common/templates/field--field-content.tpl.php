<?php

/**
 * @file
 * Default template implementation to display the value of a field.
 */
?>
<div><!-- Extra div needed to isolate nth-grid from contextual-links -->
  <?php foreach ($items as $delta => $item): ?>
    <?php print render($item); ?>
  <?php endforeach; ?>
</div>
