<?php

/**
 * @file
 * Returns the HTML for a node.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728164
 */

hide($content['field_image_with_caption']);
hide($content['field_entity_content']);
hide($content['field_para_qna']);
hide($content['field_stackla_embed_para']);
hide($content['comments']);
?>
<div class="layout-sidebar layout-max spacer">
  <div class="layout-sidebar__main">
    <?php if ($title_prefix || $title_suffix || $display_submitted || $unpublished || !$page && $title): ?>
      <header>
        <?php print render($title_prefix); ?>
        <?php if (!$page && $title): ?>
          <h2<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>
        <?php endif; ?>
        <?php print render($title_suffix); ?>

        <?php if ($display_submitted): ?>
          <p class="submitted">
            <?php print $user_picture; ?>
            <?php print $submitted; ?>
          </p>
        <?php endif; ?>

        <?php if ($unpublished): ?>
          <mark class="unpublished"><?php print t('Unpublished'); ?></mark>
        <?php endif; ?>
      </header>
    <?php endif; ?>

    <?php print render($content); ?>

  </div>
</div>
<?php if (isset($content['field_image_with_caption'])) : ?>
  <div class="layout-sidebar layout-max spacer">
    <?php if (!empty($content['field_image_with_caption'])): ?>
      <div class="layout-sidebar__main">
        <?php if (isset($content['field_image_with_caption'])): ?>
          <div class="spacer--bottom-large">
            <?php print render($content['field_image_with_caption']); ?>
          </div>
        <?php endif; ?>
      </div>
    <?php endif; ?>
  </div>
<?php endif; ?>

<?php print render($content['field_entity_content']); ?>

<?php print render($content['field_para_qna']); ?>

<?php print render($content['field_stackla_embed_para']); ?>

<?php print render($content['comments']); ?>
