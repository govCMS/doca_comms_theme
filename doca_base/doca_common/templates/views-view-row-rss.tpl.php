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
  $rss_author_raw = theme_get_setting('rss_author');
  $rss_author = 'Department of Communications and the Arts';
  if(!empty($rss_author_raw)) {
    //see whether this has multiple entries by checking for carriage returns
    if(strstr($rss_author_raw, chr(13))) {
      //explode the newlines into an array
      $rss_author_array = preg_split('/\r\n?|\n/', $rss_author_raw, -1, PREG_SPLIT_NO_EMPTY);
      //loop through to find a URI match
      foreach($rss_author_array as $key => $value) {
        //if value contains a comma separator (and only 1 comma)
        if(substr_count($value, ',') !== 1) {
	  //there should only be 1 comma separating terms, so skip item if not 1
          continue;
        }
        //explode on comma separator
        $rss_author_data = explode(',', $value, 2);
        //does URI match current govCMS path?
        if($rss_author_data[0] == request_path()) {
          //found it!
          $rss_author = $rss_author_data[1];
          //break out of loop
          break;
        }
      }
    }
  }
  $item_elements = preg_replace('/\\<dc:creator\\>(.*?)\\<\\/dc:creator\\>/', "<dc:creator>$rss_author</dc:creator>", $item_elements);
  print $item_elements;
  ?>
</item>
