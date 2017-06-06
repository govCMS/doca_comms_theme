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
<?php $with_img = 0;
$show_img = isset($content['field_show_hero_image']) ? $content['field_show_hero_image']['#items'][0]['value'] : '';
if (!empty($content['field_show_hero_image']) && !empty($show_img)):
  $with_img = 1;
endif;
?>
<?php if (isset($node->body[$node->language][0]['safe_summary'])): ?>
  <div
    class="layout-sidebar layout-max spacer <?php
    if (!isset($service_links)):
      print 'spacer--bottom-large';
    endif;
    ?>">
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
<?php if (!$hide_on_this_page) : ?>
  <div class="on-this-page" data-js="on-this-page"></div>
<?php endif; ?>

<?php print render($content['field_summary_cta_with_links']); ?>

<div class="layout-sidebar layout-max spacer <?php
  if ($with_img):
    print 'layout-sidebar__with-img';
  endif;
?>">
  <?php if (isset($content['related_content']) || $with_img): ?>
    <div class="layout-sidebar__sidebar sidebar--large sidebar--right-align">
      <?php if ($with_img): ?>
        <?php print render($content['field_feature_image']); ?>
      <?php endif; ?>
      <div class="layout-sidebar__sidebar--related visible--md">
        <?php print render($content['related_content']); ?>
      </div>
    </div>
  <?php endif; ?>

  <div class="layout-sidebar__main">
    <?php if (isset($content['field_image_with_caption'])): ?>
      <div class="spacer--bottom-large">
        <?php print render($content['field_image_with_caption']); ?>
      </div>
    <?php endif; ?>
    <?php print render($content['body']); ?>
    <?php if (isset($content['related_content'])): ?>
      <div class="visible--xs">
        <?php print render($content['related_content']); ?>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php print render($content['field_entity_content']); ?>

<?php print render($content['field_para_qna']); ?>

<?php print render($content['field_stackla_embed_para']); ?>

<?php if (!$hide_child_pages) : ?>
  <?php print $child_pages_block; ?>
<?php endif; ?>

<?php print render($content['field_creative_commons_license']); ?>

<?php print render($content['comments']); ?>
