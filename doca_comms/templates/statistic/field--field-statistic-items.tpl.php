<?php

/**
 * @file
 * Template for field statistic items.
 */
?>
<?php if(!empty($label)): ?>
  <h4 class="heading--4--spaced"><?php print $label; ?></h4>
<?php endif; ?>
<?php foreach ($items as $delta => $item): ?>
    <?php print render($item); ?>
<?php endforeach; ?>
