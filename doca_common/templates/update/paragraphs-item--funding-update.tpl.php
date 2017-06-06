<?php
/**
 * @file
 * Channels theme implementation for a container.
 */
?>
<div class="update">
  <div class="update__icon"><?php print render($content['field_update_type']); ?></div>
  <div class="update__title"><?php print render($content['field_pbundle_destination']); ?></div>
  <div class="update__date"><?php print render($content['field_update_date']); ?></div>
  <div class="update__summary"><?php print render($content['field_update_summary_text']); ?></div>
</div>
