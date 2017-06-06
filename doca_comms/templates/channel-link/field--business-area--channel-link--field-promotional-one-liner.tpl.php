<?php
/**
 * @file
 * Default template implementation to display the value of a field.
 */
?>
<?php foreach ($items as $delta => $item): ?>
  <div class="channel-list__title">
    <?php print render($item); ?>
  </div>
<?php endforeach; ?>
