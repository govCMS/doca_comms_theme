<?php
/**
 * @file
 * Template implementation to correctly output title in 3 column grid.
 */
?>
<?php foreach ($items as $delta => $item): ?>
  <div class="spacer--bottom min-height__icon"><?php print render($item); ?></div>
<?php endforeach; ?>
