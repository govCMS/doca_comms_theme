<?php
/**
 * @file
 * Default template implementation to display the value of a field.
 */
?>
<?php foreach ($items as $delta => $item): ?>
  <?php if($variables['element']['#bundle'] == 'document_policy_list'): ?>
    <?php print sprintf('<h2>%s</h2>', render($item)); ?>
  <?php else: ?>
    <?php print render($item); ?>
  <?php endif; ?>
<?php endforeach; ?>
