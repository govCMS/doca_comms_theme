<?php
/**
 * @file
 * Default template implementation to display the value of a field.
 */
?>
<div class="spacer--bottom-large">
  <button class="button-primary form-submit" data-js="webform-toggle"
          data-toggle="other-webform"><?php print t('Apply Now'); ?></button>
</div>
<div id="other-webform">
  <div class="<?php print $classes; ?>"<?php print $attributes; ?>>
    <?php if (!$label_hidden): ?>
      <div class="field-label"<?php print $title_attributes; ?>><?php print $label ?>:&nbsp;</div>
    <?php endif; ?>
    <div class="field-items"<?php print $content_attributes; ?>>
      <?php foreach ($items as $delta => $item): ?>
        <div
          class="field-item <?php print $delta % 2 ? 'odd' : 'even'; ?>"<?php print $item_attributes[$delta]; ?>><?php print render($item); ?></div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
