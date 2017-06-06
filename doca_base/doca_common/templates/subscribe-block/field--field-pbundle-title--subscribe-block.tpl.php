<?php
/**
 * @file
 * Template implementation to display the title of a CTA summary item.
 */
?>
<?php foreach ($items as $delta => $item): ?>
  <h2><?php print render($item); ?></h2>
<?php endforeach; ?>
