<?php

/**
 * @file
 * Display Suite 1 column template.
 */
?>
<?php
    $dom = new DOMDocument;
    $dom->loadHTML($ds_content);
    $xpath = new DOMXPath($dom);
    $src = $xpath->evaluate("string(//img/@src)");
    $caption = $xpath->evaluate("string(//*[contains(@class, 'field-name-field-pbundle-image-caption')])");
?>
<?php if (!empty($src) && !empty($caption)): ?>
    <a href="<?php print $src; ?>" data-modaal-desc="<?php print $caption; ?>" data-group="modaal-gallery" class="modaal-gallery">
        <<?php print $ds_content_wrapper; print $layout_attributes; ?> class="ds-1col <?php print $classes;?> clearfix">

          <?php if (isset($title_suffix['contextual_links'])): ?>
          <?php print render($title_suffix['contextual_links']); ?>
          <?php endif; ?>
          <?php print $ds_content; ?>
        </<?php print $ds_content_wrapper ?>>
        <?php if (!empty($drupal_render_children)): ?>
          <?php print $drupal_render_children ?>
        <?php endif; ?>
    </a>
<?php endif; ?>
