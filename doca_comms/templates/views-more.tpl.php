<?php

/**
 * @file
 * Theme the more link.
 *
 * - $view: The view object.
 * - $more_url: the url for the more link.
 * - $link_text: the text for the more link.
 *
 * @ingroup views_templates
 */
?>

<div class="spacer--bottom">
  <?php print doca_common_read_more_link($more_url, $link_text); ?>
</div>
