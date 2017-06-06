<?php
/**
 * @file
 * Template for a statistic paragraph item.
 */
?>

<div class="palette__light-grey background-image__big">
  <div class="layout-max spacer--large">
  <?php print render($content['field_pbundle_title']); ?>
  <div class="layout-sidebar__main">
    <?php print render($content['field_pbundle_text']); ?>
    <?php print render($content['field_pbundle_destination']); ?>
    <?php print render($content['field_video']); ?>
  </div>
  <?php if(isset($content['field_pbundle_for_more'])): ?>
    <div class="layout-sidebar__sidebar">
      <?php print render($content['field_pbundle_for_more']); ?>
    </div>
  <?php endif; ?>
  <div class="clearfix"></div>
  </div>
</div>
