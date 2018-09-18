<?php
/**
 * @file
 * Default template implementation to display the value of a field.
 */
?>
<div class="spacer--bottom-large">
  <button class="button-primary form-submit" data-js="webform-toggle"
          data-toggle="formal-submission-webform"><?php print t('Have Your Say Now'); ?></button>
</div>
<div id="formal-submission-webform">
  <div class="<?php print $classes; ?>"<?php print $attributes; ?>>
    <?php if (!$label_hidden): ?>
      <div class="field-label"<?php print $title_attributes; ?>><?php print $label ?>:&nbsp;</div>
    <?php endif; ?>
    <div class="field-items"<?php print $content_attributes; ?>>
      <?php foreach ($items as $delta => $item): ?>
        <div
          class="field-item <?php print $delta % 2 ? 'odd' : 'even'; ?>"<?php if (isset($item_attributes['client-block-' . $form_id])): print $item_attributes['client-block-' . $form_id];endif; ?>>
          <?php
            $hys_form_block = module_invoke('webform', 'block_view', 'client-block-' . $form_id);
            print render($hys_form_block['content']);
          ?></div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
