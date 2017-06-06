<?php
/**
 * @file
 * Template implementation to display the promotional text of channel.
 */
?>
<div class="clearfix__overflow">
  <?php foreach ($items as $delta => $item): ?>
    <?php print render($item); ?>
  <?php endforeach; ?>
</div>
