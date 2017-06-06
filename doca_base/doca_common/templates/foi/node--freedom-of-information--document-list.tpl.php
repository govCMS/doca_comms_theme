<?php
/**
 * @file
 * Returns the HTML for a node.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728164
 */

if (!isset($title_tag) || empty($title_tag)) :
  $title_tag = 'h3';
endif;
?>
<article class="document-list__item"<?php print $attributes; ?>>
  <div class="document-list__inner">
    <?php if ($title_prefix || $title_suffix || $display_submitted || $unpublished || !$page && $title): ?>
      <header>
      <?php print render($title_prefix); ?>
      <?php if (!$page && $title): ?>
        <<?php print $title_tag; ?> class="document-list__title"><a
          href="<?php print $node_url; ?>"><?php print $title; ?></a></<?php print $title_tag; ?>>
      <?php endif; ?>
      <?php print render($title_suffix); ?>

      <ul class="document-list__list">
        <li><?php print render($content['field_reference_number']); ?></li>
        <li><?php print render($content['field_access_date']); ?></li>
        <li><?php print render($content['field_date']); ?></li>
      </ul>

      <?php if ($unpublished): ?>
        <mark class="unpublished"><?php print t('Unpublished'); ?></mark>
      <?php endif; ?>
      </header>
    <?php endif; ?>

    <div class="document-list__desc">
      <?php print render($content['body']); ?>
    </div>

    <?php print render($content['links']); ?>
    <?php print render($content['comments']); ?>
  </div>
</article>
