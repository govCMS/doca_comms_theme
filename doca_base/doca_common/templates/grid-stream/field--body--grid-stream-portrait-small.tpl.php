<?php
/**
 * @file
 * Template implementation to display the image of channel.
 */
?>
<div class="show-at__large">
  <?php foreach ($items as $delta => $item): ?>
    <?php print doca_common_trim(render($item), 130); ?>
  <?php endforeach; ?>
</div>
