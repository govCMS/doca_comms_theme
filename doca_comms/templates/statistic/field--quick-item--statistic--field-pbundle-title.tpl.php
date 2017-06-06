<?php

/**
 * @file
 * Template for title of statistic quick item.
 */
?>
<?php foreach ($items as $delta => $item): ?>
  <div class="statistic__title"><?php print render($item); ?></div>
<?php endforeach; ?>
