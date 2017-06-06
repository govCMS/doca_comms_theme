<?php
/**
 * @file
 * Template implementation to display the destination link as CTA button.
 */
?>
<div class="list-arrow">
<?php foreach ($items as $delta => $item): ?>
  <div class="list-arrow__item">
    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 416 416" preserveAspectRatio="xMidYMid meet" xml:space="preserve"><polygon points="160,115.4 180.7,96 352,256 180.7,416 160,396.7 310.5,256 "></polygon></svg>
    <?php print render($item); ?>
  </div>
<?php endforeach; ?>
</div>
