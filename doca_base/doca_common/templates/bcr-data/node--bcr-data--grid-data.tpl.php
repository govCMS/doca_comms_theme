<?php
/**
 * @file
 * Returns the HTML for a node.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728164
 */
?>

<a href="<?php print $node_url; ?>" class="grid-data__item">
  <?php print render($content['field_image']); ?>
  <span class="grid-data__link-text">
    <?php print doca_common_trim(render($title), 50); ?>
    <svg focusable="false" xmlns='http://www.w3.org/2000/svg' height='15' version='1.1' viewBox='0 0 416 416' width='10'
         xml:space='preserve'><polygon
        points='160,115.4 180.7,96 352,256 180.7,416 160,396.7 310.5,256 '></polygon></svg>
  </span>
</a>
