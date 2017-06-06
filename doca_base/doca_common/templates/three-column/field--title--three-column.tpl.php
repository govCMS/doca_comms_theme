<?php
/**
 * @file
 * Template implementation to apply class to a linked title in three col layout.
 */
?>
<?php foreach ($items as $delta => $item): ?>
  <a class="read-more--heading"
     href="<?php print base_path() . drupal_get_path_alias('node/' . $element['#object']->nid); ?>">
    <?php print doca_common_trim($element['#object']->title, 50); ?>
  </a>
<?php endforeach; ?>
