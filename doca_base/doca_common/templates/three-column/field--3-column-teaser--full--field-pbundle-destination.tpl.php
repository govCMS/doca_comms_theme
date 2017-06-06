<?php
/**
 * @file
 * Template implementation to display the destination link of a 3 column bundle.
 */
?>
<?php foreach ($items as $delta => $item): ?>
  <div class="clearfix__overflow read-more--footer-wrapper">
    <?php print doca_common_read_more_link(check_plain($item['#element']['url']), check_plain($item['#element']['title'])); ?>
  </div>
<?php endforeach; ?>
