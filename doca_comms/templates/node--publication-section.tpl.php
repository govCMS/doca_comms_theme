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

    <?php if (isset($content['field_image_with_caption'])): ?>
      <div class="spacer--bottom-large">
        <?php print render($content['field_image_with_caption']); ?>
      </div>
    <?php endif; ?>
    <?php print render($content['body']); ?>

    <?php if (!empty($content['book_navigation'])): ?>
        <?php print render($content['book_navigation']); ?>
    <?php endif; ?>

    <?php if (isset($content['related_content'])): ?>
      <div class="visible--xs">
        <?php print render($content['related_content']); ?>
      </div>
    <?php endif; ?>


    <aside class="layout-sidebar__sidebar" role="complementary">
      <?php print render($page['sidebar_right']); ?>
    </aside>  <!-- /#sidebar-second -->

</div>


<?php print render($content['field_entity_content']); ?>

<?php print render($content['field_para_qna']); ?>

<?php print render($content['field_stackla_embed_para']); ?>

<?php if (!$hide_child_pages) : ?>
  <?php print $child_pages_block; ?>
<?php endif; ?>

<?php print render($content['field_creative_commons_license']); ?>

<?php print render($content['comments']); ?>
