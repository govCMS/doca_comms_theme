<?php
/**
 * @file
 * Template implementation to display the title of a CTA summary item.
 */
?>
<?php foreach ($items as $delta => $item):?>
  <p><?php print render($item); ?></p>
<?php endforeach; ?>
