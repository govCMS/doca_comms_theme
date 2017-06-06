<?php
/**
 * @file
 * Default template implementation to display the value of a field.
 */
?>
<div class="progress-bar__bar--funding spacer--bottom-mid2">
  <?php if (!$label_hidden): ?>
    <div class="field-label"<?php print $title_attributes; ?>><?php print $label ?>:&nbsp;</div>
  <?php endif; ?>
  <div class="progress-bar <?php print $consultation['status_class']; ?>"<?php print $content_attributes; ?>>
    <div class="progress-bar__bar">
      <div class="progress-bar__progress--aqua "
           style="width: <?php print round($consultation['percentage']); ?>%;"></div>
    </div>
  </div>
</div>
