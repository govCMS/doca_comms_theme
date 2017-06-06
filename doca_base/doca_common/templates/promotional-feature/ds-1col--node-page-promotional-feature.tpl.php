<?php
/**
 * @file
 * Channels theme implementation for a Standard Page within Promotional Feature.
 */
?>
<div class="promotional-feature__left">
  <?php print render($content['field_image']); ?>
</div>

<div class="promotional-feature__right">
  <?php print render($content['title']); ?>
  <?php print render($content['body']); ?>
  <?php print render($content['node_link']); ?>
</div>
