<?php

/**
 * @file
 * Returns the HTML for a node.
 *
 * Complete documentation for this file is available online.
 *
 * @see https://drupal.org/node/1728164
 */
hide($content['links']);
hide($content['comments']);
?>
<?php if ($title): ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>
<?php print render($content); ?>
