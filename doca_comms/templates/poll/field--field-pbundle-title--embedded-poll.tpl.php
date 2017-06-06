<?php
/**
 * @file
 * Template implementation to display the title of an embedded poll.
 */
?>
<?php foreach ($items as $delta => $item):?>
  <h2 class="heading--2--spaced"><?php print render($item); ?></h2>
<?php endforeach; ?>
