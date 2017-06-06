<?php

/**
 * @file
 * Template for text of statistic quick item.
 */
?>
<?php foreach ($items as $delta => $item): ?>
  <div class="statistic__desc"><?php print render($item); ?></div>
<?php endforeach; ?>
