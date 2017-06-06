<?php
/**
 * @file
 * Default template implementation to display the value of a field.
 */
?>
<div>
  <?php if (!$label_hidden): ?>
    <div class="field-label"<?php print $title_attributes; ?>><?php print $label ?>:&nbsp;</div>
  <?php endif; ?>
  <?php print doca_common_read_more_link(drupal_get_path_alias('node/' . $element['#object']->nid), t('Learn more'), $external_source); ?>
</div>
