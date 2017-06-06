<?php
/**
 * @file
 * Template implementation to display the image of channel.
 */
?>
<div class="grid-stream__icon is-stream">
  <?php foreach ($items as $delta => $item): ?>
    <?php print render($item); ?>
      <span class="grid-stream__icon__name"><?php print check_plain($element['#object']->name); ?></span>
  <?php endforeach; ?>
</div>
