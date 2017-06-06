<?php
/**
 * @file
 * Default template implementation to display the value of a field.
 */
?>
<?php $title = isset($one_liner) ? $one_liner : $element['#object']->title; ?>
<div class="grid-stream__title">
  <a href="<?php print base_path() . drupal_get_path_alias('node/' . $element['#object']->nid); ?>" target="_parent">
    <?php print doca_common_trim(render($title), 50); ?>
  </a>
</div>
