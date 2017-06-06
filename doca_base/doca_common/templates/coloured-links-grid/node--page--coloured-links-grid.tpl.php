<?php
/**
 * @file
 * Returns the HTML for a node.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728164
 */
?>
<?php if ($title): ?>
  <h2><?php print doca_common_trim(render($title), 35); ?></h2>
<?php endif; ?>

<div>
  <?php print render($content); ?>
</div>


<?php print doca_common_read_more_link($node_url, $read_more_text, $external_source); ?>
