<?php

/**
 * @file
 * Template for image of statistic quick item.
 */
?>
 <li class="list-inline__item underline-on-hover__never__wrapper">
   <?php foreach ($items as $delta => $item): ?>
      <?php print render($item); ?>
    <?php endforeach; ?>
 </li>
