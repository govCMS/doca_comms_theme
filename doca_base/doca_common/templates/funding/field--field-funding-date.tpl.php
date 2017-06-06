<?php
/**
 * @file
 * Default template implementation to display the value of a field.
 */
?>
<div class="spacer--vertical">
  <?php if (!$label_hidden): ?>
    <span class="font__medium"<?php print $title_attributes; ?>><?php print $label ?>:&nbsp;</span>
  <?php endif; ?>
  <span class="font__medium--light">
    <?php if ($funding['date_status'] === 'upcoming'): ?>
      <?php print t('To be advised'); ?>
    <?php else: ?>
      <?php foreach ($items as $delta => $item): ?>
        <?php print render($item); ?>
      <?php endforeach; ?>
    <?php endif; ?>
  </span>
</div>
