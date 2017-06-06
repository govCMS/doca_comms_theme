<?php
/**
 * @file
 * Template implementation to display the promotional text of channel.
 */
?>
<div class="channel-list__description">
  <?php foreach ($items as $delta => $item): ?>
    <?php print render($item); ?>
  <?php endforeach; ?>
</div>
