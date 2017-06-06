<?php

/**
 * @file
 * Display Suite 1 column template.
 */
?>

<?php if (isset($status_message) && $status_message != ''): ?>
  <div class="messages--status messages status">
    <?php print $status_message; ?>
  </div>
<?php endif; ?>

<<?php print $ds_content_wrapper;
print $layout_attributes; ?> class="ds-1col <?php print $classes; ?> clearfix">
<div class="grid-stream__item--vertical__bottom--small">
  <div class="border-highlight"></div>

  <?php if (isset($title_suffix['contextual_links'])): ?>
    <?php print render($title_suffix['contextual_links']); ?>
  <?php endif; ?>

  <?php if ($view_mode == "full"): ?>
    <div class="layout-max spacer">
      <div class="layout-sidebar__main page-description">
        <?php print $node->field_consultation_summary[LANGUAGE_NONE][0]['safe_value']; ?>
      </div>
      <?php if (isset($content['related_content'])): ?>
        <div class="layout-sidebar__sidebar sidebar--right-align">
          <?php print render($content['related_content']); ?>
        </div>
      <?php endif; ?>
    </div>

    <?php if (isset($service_links)): ?>
      <div class="layout-max spacer">
        <?php print $service_links; ?>
      </div>
    <?php endif; ?>

  <?php endif; ?>

  <?php print $ds_content; ?>
</div></<?php print $ds_content_wrapper ?>>

<?php if (!empty($drupal_render_children)): ?>
  <?php print $drupal_render_children ?>
<?php endif; ?>
