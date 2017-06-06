<?php
/**
 * @file
 * Returns the HTML for a node.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728164
 */

if (!isset($title_tag) || empty($title_tag)) :
  $title_tag = 'h2';
endif;
?>
<article class="document-list__item search-result"<?php print $attributes; ?>>
  <svg class="search-result__icon" width="32" height="32" role="img" title="Poll" xmlns="http://www.w3.org/2000/svg">
    <use xlink:href="#poll"/>
  </svg>
  <div class="document-list__inner">
    <?php if ($title_prefix || $title_suffix || $display_submitted || $unpublished || !$page && $title): ?>
      <header>
      <?php print render($title_prefix); ?>
      <?php if (!$page && $title): ?>
        <<?php print $title_tag; ?> class="document-list__title"><?php print $title; ?></<?php print $title_tag; ?>>
      <?php endif; ?>
      <?php print render($title_suffix); ?>

      <?php if ($unpublished): ?>
        <mark class="unpublished"><?php print t('Unpublished'); ?></mark>
      <?php endif; ?>
      </header>
    <?php endif; ?>

    <?php print render($content); ?>

  </div>
</article>
