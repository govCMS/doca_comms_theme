<?php
/**
 * @file
 * Default template implementation to display the value of a field.
 */
?>
<div class="max-width__medium">
  <h3 class="heading--3 spacer--top" <?php print $title_attributes; ?>><?php print t('How to apply'); ?></h3>
  <?php if (!empty($funding['submissions_closed_message'])): ?>
    <div class="bordered spacer"><?php print $funding['submissions_closed_message']; ?></div>
  <?php endif; ?>
  <div class="spacer--vertical">
    <?php foreach ($items as $delta => $item): ?>
      <?php print render($item); ?>
    <?php endforeach; ?>
  </div>
</div>
