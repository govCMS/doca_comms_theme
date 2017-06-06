<?php
/**
 * @file
 * Default template implementation to display the value of a field.
 */

$ongoing = $consultation['ongoing'];
if ($ongoing):
  $percentage = 100;
else:
  $percentage = round($consultation['percentage']);
endif;
?>
<div class="spacer--vertical progress-bar__bar--funding<?php print $ongoing ? ' ongoing': ''; ?>">
  <?php if (!$label_hidden): ?>
    <div class="field-label"<?php print $title_attributes; ?>><?php print $label ?>:&nbsp;</div>
  <?php endif; ?>
  <div
    class="progress-bar <?php print $consultation['status_class']; ?> progress-bar__<?php print ($consultation['status_msg_class']); ?>"<?php print $content_attributes; ?>>
    <?php if (!$ongoing): ?>
    <div class="progress-bar__text">
      <div class="progress-bar__start-date">
        <?php print $consultation['started_text'] . ' ' . format_date($consultation['start'], 'full_with_timezone'); ?></div>
      <div class="progress-bar__end-date">
        <?php print $consultation['ended_text'] . ' ' . format_date($consultation['end'], 'full_with_timezone'); ?></div>
    </div>
    <?php endif; ?>
    <div class="progress-bar__bar">
      <div class="progress-bar__progress" style="width: <?php print $percentage; ?>%;"></div>
    </div>
    <?php if (!$ongoing): ?>
    <div class="progress-bar__days-remain">
      <span class="progress-bar__label"><?php print t('Days Remaining'); ?> </span>
      <span
        class="progress-bar__highlighted"><?php print $consultation["days_remain"]; ?></span> <?php print 'of ' . $consultation["days_total"]; ?>
    </div>
    <?php endif; ?>

    <?php if (isset($consultation['status_message'])): ?>
    <div class="progress-bar__highlighted">
      <?php print $consultation['status_message']; ?>
    </div>
    <?php endif; ?>

  </div>
</div>
