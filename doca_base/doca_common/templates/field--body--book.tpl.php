<?php

/**
 * @file
 * Default template implementation to display the value of a field.
 */
?>
<div class="max-width__content">
  <h2>About the book</h2>
  <?php foreach ($items as $delta => $item): ?>
    <?php print render($item); ?>
  <?php endforeach; ?>
</div>
