<?php
/**
 * @file
 * Default RSS template implementation to display field-consultation-summary.
 */
?>
<?php foreach ($items as $delta => $item): ?>
  <?php print render($item); ?>
<?php endforeach; ?>
