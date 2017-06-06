<?php

/**
 * @file
 * Default view template to display a item in an RSS feed.
 *
 * @ingroup views_templates
 */
$rss_author = variable_get('site_name', 'Department of Communications and the Arts'); // The default value
if (!empty(theme_get_setting('rss_author'))) {
  $current_path = current_path();
  $rss_author_settings = preg_split('/\r\n|[\r\n]/', theme_get_setting('rss_author'));
  foreach ($rss_author_settings as $rss_author_setting) {
    $rss_author_setting = explode(',', $rss_author_setting);
    if (drupal_match_path($current_path, $rss_author_setting[0])) {
      if (!empty($rss_author_setting[1])) {
        $rss_author = check_plain($rss_author_setting[1]);
      }
      break;
    }
  }
}
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
    $item_elements = preg_replace('/\\<dc:creator\\>(.*?)\\<\\/dc:creator\\>/', "<dc:creator>$rss_author</dc:creator>", $item_elements);
    print $item_elements;
  ?>
</item>
