<?php
/**
 * @file
 * Template implementation to display the title of a promotional feature title.
 */
?>
<?php foreach ($items as $delta => $item):?>
  <h2 class="promotional-feature__title"><?php print render($item); ?></h2>
<?php endforeach; ?>
