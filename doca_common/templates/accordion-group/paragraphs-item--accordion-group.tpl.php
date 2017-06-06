<?php
/**
 * @file
 * Channels theme implementation for accordion groups.
 */
?>
<div class="layout-max spacer">
  <div class="<?php print $classes; ?>">
    <?php print render($content['field_pbundle_title']); ?>
    <?php print render($content['field_pbundle_text']); ?>
    <div class="accordion">
      <?php print render($content['field_accordion_items']); ?>
    </div>
  </div>
</div>
