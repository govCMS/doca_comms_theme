<?php
/**
 * @file
 * Returns the HTML for a node.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728164
 */
?>

<div class="layout-max spacer">
  <?php print render($content['field_video_filter']); ?>
  <div class="layout-sidebar__main">
    <?php print render($content['field_description']); ?>
  </div>
</div>

<?php print render($content['field_creative_commons_license']); ?>
