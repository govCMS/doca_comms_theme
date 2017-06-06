<?php
/**
 * @file
 * Template implementation to display the promotional text of channel.
 */
?>
<div class="clearfix__overflow show-at__medium">
  <?php foreach ($items as $delta => $item): ?>
    <?php print render($item); ?>
  <?php endforeach; ?>
</div>
