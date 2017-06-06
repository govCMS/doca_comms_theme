<?php
/**
 * @file
 * Template implementation to display the image of channel.
 *
 * This file is not used and is here as a starting point for customization only.
 * @see theme_field()
 */
?>
<div class="spacer--bottom-mid">
  <?php foreach ($items as $delta => $item): ?>
    <?php print render($item); ?>
  <?php endforeach; ?>
</div>
