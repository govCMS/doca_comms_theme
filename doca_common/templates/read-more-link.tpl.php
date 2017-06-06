<?php

/**
 * @file
 * Template for read more link.
 */
?>
<a class="read-more<?php
  if ($external): ?> external-link<?php
  endif;
  ?>" href="<?php print $href; ?>" target="_parent">
  <?php print $text; ?>
  <?php if ($external): ?>
    <svg name="external-link" xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12"
         preserveAspectRatio="xMidYMid meet">
      <path
        d="M11.3 6.2c.2 0 .4-.2.4-.4V.7H6.6c-.2 0-.4.2-.4.4s.2.4.4.4h3.7L4.2 7.6c-.2.2-.2.4 0 .6.2.2.4.2.6 0l6.1-6.1v3.7c0 .2.1.4.4.4z"/>
      <path d="M9.5 9c0-.2-.2-.4-.4-.4s-.5.2-.5.4v2.1H1.4V3.8h2.1c.2 0 .4-.2.4-.4S3.7 3 3.5 3H.6v8.9h8.9V9z"/>
    </svg>
  <?php endif; ?>
  <svg focusable="false" xmlns='http://www.w3.org/2000/svg' height='15' version='1.1' viewBox='0 0 416 416' width='10'
       xml:space='preserve'><polygon points='160,115.4 180.7,96 352,256 180.7,416 160,396.7 310.5,256 '></polygon></svg>
</a>
