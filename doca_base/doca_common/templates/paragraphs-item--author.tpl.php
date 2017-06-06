<?php

/**
 * @file
 * Default theme implementation for a single paragraph item.
 */
?>
<div class="book-author-inline">
  <?php if ($view_mode == 'full'):
    print '<h3>';
  endif; ?>
  <?php print render($content['field_pbundle_title']) . ' ' . render($content['field_pbundle_subtitle']); ?><?php if ($view_mode == 'full') {
    print '</h3>';
  } ?>
</div>
<?php print render($content); ?>
