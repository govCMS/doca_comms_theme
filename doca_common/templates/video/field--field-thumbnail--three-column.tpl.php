<?php
/**
 * @file
 * Template implementation to display images in a three column layout.
 */
?>
<div class="spacer--bottom">
  <?php foreach ($items as $delta => $item): ?>
    <?php print render($item); ?>
  <?php endforeach; ?>
</div>
