<?php
/**
 * @file
 * Default template implementation to display the value of a field.
 */
?>
<div class="grid-stream__item--landscape-small__right">
  <?php foreach ($items as $delta => $item): ?>
    <div class="<?php print $img_class; ?>">
      <?php print render($item); ?>
      <?php print $img_caption; ?>
    </div>
  <?php endforeach; ?>
</div>
