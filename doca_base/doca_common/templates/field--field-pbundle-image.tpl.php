<?php

/**
 * @file
 * Template implementation to display the image of channel.
 *
 * @see theme_field()
 */
?>

<?php foreach ($items as $delta => $item): ?>
  <div class="<?php print $img_class; ?>">
    <?php print render($item); ?>
    <?php print $img_caption; ?>
  </div>
<?php endforeach; ?>
