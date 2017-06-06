<?php
/**
 * @file
 * Returns the HTML for a node.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728164
 */

?>
<article class="poll-form spacer"<?php print $attributes; ?>>
    <?php if ($title_prefix || $title_suffix || $display_submitted || $unpublished || !$page && $title): ?>
      <header>
        <?php print render($title_prefix); ?>
        <?php if (!$page && $title): ?>
          <h3 class="poll-form__title" id="poll_<?php print $nid; ?>__title"><?php print $title; ?></h3>
        <?php endif; ?>
        <?php print render($title_suffix); ?>

        <?php if ($unpublished): ?>
          <mark class="unpublished"><?php print t('Unpublished'); ?></mark>
        <?php endif; ?>
      </header>
    <?php endif; ?>

    <?php
    // We hide the comments and links now so that we can render them later.
    hide($content['comments']);
    hide($content['links']);
    print render($content);
    ?>
</article>
