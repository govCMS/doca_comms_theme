<?php
/**
 * @file
 * Template implementation to display the title of a Question Answer group item.
 */
?>
<?php foreach ($items as $delta => $item): ?>
  <h2 class="heading--2--spaced"><?php print render($item); ?></h2>
<?php endforeach; ?>
