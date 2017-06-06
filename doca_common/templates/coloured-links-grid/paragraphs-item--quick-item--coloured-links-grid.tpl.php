<?php
/**
 * @file
 * Channels theme implementation for a single paragraph item.
 */
?>
<?php
$content_class = "featured__grid-item__default";
if (isset($content['field_pbundle_image'])) {
  $content_class = "featured__grid-item__content";
}
?>
<div class="featured__grid-item">
  <?php if (isset($content['field_pbundle_image'])): ?>
    <div class="featured__grid-item__img">
      <?php print render($content['field_pbundle_image']); ?>
    </div>
  <?php endif; ?>
  <div class="<?php print $content_class; ?>">
    <?php print render($content['field_pbundle_title']); ?>
    <?php print render($content['field_pbundle_text']); ?>
    <?php print render($content['field_pbundle_destination']); ?>
  </div>
</div>

