<?php
/**
 * @file
 * Channels theme implementation for image with caption and credit.
 */
?>

<?php
if ($content['field_pbundle_image']['#items'][0]['uri']) {
  $src = file_create_url($content['field_pbundle_image']['#items'][0]['uri']);
}
$caption = '';
if ($content['field_pbundle_image_caption']['#items'][0]['value']) {
  $caption = $content['field_pbundle_image_caption']['#items'][0]['value'];
}
?>

<?php if (!empty($src)): ?>
<div class="media-item">
    <a href="<?php print $src; ?>" data-modaal-desc="<?php print $caption; ?>" data-group="modaal-gallery" class="modaal-gallery">
      <?php print render($content['field_pbundle_image']); ?>
        <div class="image-with-caption__caption">
          <?php print render($content['field_pbundle_image_caption']); ?>
          <?php if (isset($content['field_pbundle_image_credit'])): ?>
              -
              <span class="image-with-caption__credit"><?php print render($content['field_pbundle_image_credit']); ?></span>
          <?php endif; ?>
        </div>
    </a>
</div>
<?php endif; ?>