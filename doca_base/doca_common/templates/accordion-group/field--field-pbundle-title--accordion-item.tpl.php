<?php
/**
 * @file
 * Template implementation to display the title of an accordion item.
 */
?>
<?php foreach ($items as $delta => $item): ?>
  <?php print render($item); ?>
<?php endforeach; ?>
