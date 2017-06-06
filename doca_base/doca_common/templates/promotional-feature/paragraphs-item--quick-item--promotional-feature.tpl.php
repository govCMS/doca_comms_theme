<?php
/**
 * @file
 * Channels theme implementation for a single paragraph item.
 */
$bundle_title = isset($content['field_pbundle_title']) ? $content['field_pbundle_title']['#items'][0]['safe_value'] : '';
?>
<div class="promotional-feature__left">
  <a href="<?php print $content['field_pbundle_destination']['#items'][0]['url']; ?>"
     title="<?php print $bundle_title; ?>"><?php print render($content['field_pbundle_image']); ?></a>
</div>

<div class="promotional-feature__right">
  <?php print render($content['field_pbundle_title']); ?>
  <?php print render($content['field_pbundle_text']); ?>
  <?php if (isset($content['field_pbundle_destination'])): print render($content['field_pbundle_destination']); endif; ?>
</div>
