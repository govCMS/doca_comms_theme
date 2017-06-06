<?php
/**
 * @file
 * Template implementation to display the image of channel.
 *
 * @see theme_field()
 */
?>

<?php foreach ($items as $delta => $item): ?>
  <?php print render($item); ?>
<?php endforeach; ?>

