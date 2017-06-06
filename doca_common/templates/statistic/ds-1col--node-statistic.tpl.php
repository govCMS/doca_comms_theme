<?php
/**
 * @file
 * Returns the HTML for a node.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728164
 */
?>

<div class="palette__red-on-grey background-image__cross">
  <div class="layout-max statistic__wrapper spacer">

    <?php if (isset($title_suffix['contextual_links'])): ?>
      <?php print render($title_suffix['contextual_links']); ?>
    <?php endif; ?>

    <div class="share-row__left">
      <h2 class="heading--2--spaced"><?php print $title; ?></h2>
    </div>

    <?php print render($content['group_share_row']); ?>
    <?php print render($content['field_statistic_items']); ?>
    <div class="spacer--vertical"><?php print render($content['node_link']) ?></div>

  </div>
</div>
