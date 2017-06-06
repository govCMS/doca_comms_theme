<?php
/**
 * @file
 * Channels theme implementation for image with caption and credit.
 */
?>
<div class="<?php print $classes; ?> image-with-caption">
    <?php print render($content['field_pbundle_image']); ?>
    <div class="image-with-caption__caption">
      <?php print render($content['field_pbundle_image_caption']); ?>
      <?php if (isset($content['field_pbundle_image_credit'])): ?>
        -
        <span class="image-with-caption__credit"><?php print render($content['field_pbundle_image_credit']); ?></span>
      <?php endif; ?>
    </div>
</div>
