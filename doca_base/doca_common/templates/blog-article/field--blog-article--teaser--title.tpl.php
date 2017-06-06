<?php
/**
 * @file
 * Default template implementation to display the value of a field.
 */
?>
<?php $title = isset($one_liner) ? $one_liner : $element['#object']->title; ?>
<div class="news-list__title">
  <a href="<?php print base_path() . drupal_get_path_alias('node/' . $element['#object']->nid); ?>">
    <?php print $title; ?>
  </a>
</div>
