<?php
/**
 * @file
 * Returns the HTML for a node.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728164
 */

?>
<article class="document-list__item"<?php print $attributes; ?>>
  <div class="document-list__inner">
    <?php if ($title_prefix || $title_suffix || $display_submitted || $unpublished || !$page && $title): ?>
      <header>
        <?php print render($title_prefix); ?>
        <?php if (!$page && $title): ?>
          <h3 class="document-list__title"><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h3>
        <?php endif; ?>
        <?php print render($title_suffix); ?>

        <?php if ($display_submitted): ?>
          <p class="document-list__date">
            <?php print $submitted; ?>
          </p>
        <?php endif; ?>

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
