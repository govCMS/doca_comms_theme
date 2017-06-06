<?php

/**
 * @file
 * Default template implementation to display the value of a field.
 */
?>
<div>
  <?php if (!$label_hidden): ?>
    <div class="field-label"<?php print $title_attributes; ?>><?php print $label ?>:&nbsp;</div>
  <?php endif; ?>
  <?php foreach ($items as $delta => $item): ?>
    <?php print doca_common_read_more_link(check_plain($item['#element']['url']), check_plain($item['#element']['title']), $external_source); ?>
  <?php endforeach; ?>
</div>
