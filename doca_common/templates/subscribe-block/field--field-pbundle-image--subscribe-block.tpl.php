<?php
/**
 * @file
 * Template implementation to display the title of a CTA summary item.
 */
?>
<?php foreach ($items as $delta => $item): ?>
  <div class="alert-signup__svg"><?php print render($item); ?></div>
<?php endforeach; ?>
