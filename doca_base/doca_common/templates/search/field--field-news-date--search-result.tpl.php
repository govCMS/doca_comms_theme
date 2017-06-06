<?php
/**
 * @file
 * Default template implementation to display the value of a field.
 */
?>
<?php if (!$label_hidden): ?>
  <?php print $title_attributes; ?><?php print $label ?>:&nbsp;
<?php endif; ?>
<?php foreach ($items as $delta => $item): ?>
  <?php print render($item); ?>
<?php endforeach; ?>
