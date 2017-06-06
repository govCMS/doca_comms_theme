<?php
/**
 * @file
 * Template implementation to display images in a three column layout.
 */
?>
<div class="spacer--bottom-mid">
  <?php foreach ($items as $delta => $item): ?>
    <div class="<?php print $img_class; ?>">
      <?php print render($item); ?>
      <?php print $img_caption; ?>
    </div>
  <?php endforeach; ?>
</div>
