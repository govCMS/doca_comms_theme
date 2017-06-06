<?php
/**
 * @file
 * Returns the HTML for a node.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728164
 */
?>

<div class="layout-max spacer <?php if (!isset($service_links)): print 'spacer--bottom-large'; endif; ?>">
  <?php if (isset($node->body[$node->language][0]['safe_summary'])): ?>
    <div class="layout-sidebar__main page-description__content">
      <?php print render($node->body[$node->language][0]['safe_summary']); ?>
    </div>
  <?php endif; ?>
  <div class="layout-sidebar__sidebar">
    <?php print render($content['field_blog_categories']); ?>
  </div>
</div>

<?php if (isset($service_links)): ?>
  <div class="layout-max">
    <?php print $service_links; ?>
  </div>
<?php endif; ?>

<div class="layout-max spacer spacer--bottom-large">
  <?php print render($submitted); ?>
  <?php if (isset($content['field_image_with_caption'])): ?>
    <div class="spacer--top-large">
      <?php print render($content['field_image_with_caption']); ?>
    </div>
  <?php endif; ?>
</div>

<?php print render($content['field_summary_cta_with_links']); ?>

<div class="layout-max spacer spacer--bottom-large">
  <div class="layout-sidebar__main">
    <?php print render($content['body']); ?>
  </div>
  <?php if (isset($content['related_content'])): ?>
    <div class="layout-sidebar__sidebar sidebar--right-align">
      <?php print render($content['related_content']); ?>
    </div>
  <?php endif; ?>
</div>

<?php print render($content['field_embedded_poll']); ?>
<?php print render($content['field_creative_commons_license']); ?>
<?php print render($content['field_stackla_embed_para']); ?>

<?php print render($content['comments']); ?>
