<?php
/**
 * @file
 * Template implementation to display the destination link as CTA button.
 */
?>
<?php foreach ($items as $delta => $item): ?>
  <p class="clearfix__overflow">
    <a class="button--normal" href="<?php print check_plain($item['#element']['url']); ?>">
      <?php print check_plain($item['#element']['title']); ?>
    </a>
  </p>
<?php endforeach; ?>
