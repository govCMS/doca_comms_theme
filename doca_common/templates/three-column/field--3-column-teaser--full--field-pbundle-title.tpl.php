<?php
/**
 * @file
 * Template implementation to correctly output title in 3 column grid.
 */
?>
<?php foreach ($items as $delta => $item): ?>
  <h2 class="heading--2--spaced"><?php print render($item); ?></h2>
<?php endforeach; ?>
