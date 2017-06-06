<?php

/**
 * @file
 * Template for image of statistic quick item.
 */
?>
<div class="statistic__item__max-width">
  <div class="statistic__img">
    <?php foreach ($items as $delta => $item): ?>
      <?php print render($item); ?>
    <?php endforeach; ?>
  </div>
</div>
