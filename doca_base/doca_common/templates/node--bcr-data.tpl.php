<?php

/**
 * @file
 * Returns the HTML for a node.
 *
 * Complete documentation for this file is available online.
 *
 * @see https://drupal.org/node/1728164
 */
?>

<div class="layout-max spacer">
  <?php print render($submitted); ?>
</div>

<?php if (isset($node->body[$node->language][0]['safe_summary'])): ?>
  <div class="layout-sidebar layout-max spacer <?php
  if (!isset($service_links)):
    print 'spacer--bottom-large';
  endif;?>">
    <div class="layout-sidebar__main page-description__content">
      <?php if (isset($node->body[$node->language][0]['safe_summary'])): ?>
        <?php print render($node->body[$node->language][0]['safe_summary']); ?>
      <?php endif; ?>
    </div>
  </div>
<?php endif; ?>

<?php if (isset($service_links)): ?>
  <div class="layout-max">
    <?php print $service_links; ?>
  </div>
<?php endif; ?>

<div class="layout-max spacer">
  <div class="layout-sidebar__main">
    <?php print render($content['body']); ?>
  </div>
  <?php if (isset($content['related_content'])): ?>
    <div class="layout-sidebar__sidebar sidebar--right-align">
      <?php print render($content['related_content']); ?>
    </div>
  <?php endif; ?>
</div>

<?php print render($content['field_entity_content']); ?>

<?php print render($content['field_creative_commons_license']); ?>
<?php print render($content['field_stackla_embed_para']); ?>

<?php print render($content['comments']); ?>
