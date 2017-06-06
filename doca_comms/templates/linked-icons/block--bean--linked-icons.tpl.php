<?php

/**
 * @file
 * Default theme implementation to display a block.
 */
?>
<div class="layout-max spacer">

  <?php print render($title_prefix); ?>
  <?php if ($block->subject): ?>
    <b class="list-inline__title"><?php print $block->subject ?></b>
  <?php endif;?>
  <?php print render($title_suffix); ?>

  <?php print $content ?>
</div>
