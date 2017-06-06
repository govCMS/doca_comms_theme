<?php
/**
 * @file
 * Default RSS template implementation to display field-funding-summary.
 */
?>
<?php foreach ($items as $delta => $item): ?>
  <?php print render($item); ?>
<?php endforeach; ?>
