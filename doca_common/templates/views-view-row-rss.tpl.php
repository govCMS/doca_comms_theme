<?php

/**
 * @file
 * Default view template to display a item in an RSS feed.
 *
 * @ingroup views_templates
 */
?>
<item>
  <title><?php print $title; ?></title>
  <link><?php print $link; ?></link>
  <description><?php print $description; ?></description>
  <?php
  // Get dc.creator value from theme setting. If the value is not set in
  // theme, use 'Department of Communications and the Arts' as the default.
  // This is to prevent the RSS feeds created by Views from exposing user
  // account names.
  $rss_author = !empty(theme_get_setting('rss_author')) ? theme_get_setting('rss_author') : 'Department of Communications and the Arts';
  $item_elements = preg_replace('/\\<dc:creator\\>(.*?)\\<\\/dc:creator\\>/', "<dc:creator>$rss_author</dc:creator>", $item_elements);
  print $item_elements;
  ?>
</item>
