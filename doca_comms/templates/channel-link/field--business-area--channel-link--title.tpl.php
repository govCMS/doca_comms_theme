<?php
/**
 * @file
 * Default template implementation to display the value of a field.
 */
?>
<div class="channel-list__description">
  <?php foreach ($items as $delta => $item): ?>
    <?php print render($item); ?>
  <?php endforeach; ?>
</div>
