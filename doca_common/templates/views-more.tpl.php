<?php

/**
 * @file
 * Theme the more link.
 *
 * Variables available:
 * - $view: The view object.
 * - $more_url: The url for the more link.
 * - $link_text: The text for the more link.
 *
 * @ingroup views_templates.
 */
?>

<div class="spacer--bottom read-more--footer-wrapper">
  <?php print doca_common_read_more_link($more_url, $link_text); ?>
</div>
