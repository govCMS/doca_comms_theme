<?php
/**
 * @file
 * Default template implementation to display the value of a field.
 */
?>
<?php foreach ($items as $delta => $item): ?>
  <a href="<?php print url('node/' . $element['#object']->hostEntityId()); ?>">
    <?php print render($item); ?>
  </a>
<?php endforeach; ?>
