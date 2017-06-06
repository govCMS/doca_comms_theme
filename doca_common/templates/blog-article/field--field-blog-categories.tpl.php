<?php
/**
 * @file
 * Default template implementation to display the value of a field.
 */
?>
<?php if (!$label_hidden): ?>
  <div class="bordered--top">
    <div class="heading--4"><?php print $label ?>:&nbsp;</div>
  </div>
<?php endif; ?>
<ul class="list-arrow">
  <?php foreach ($items as $delta => $item): ?>
    <li class="list-arrow__item">
      <svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 416 416" preserveAspectRatio="xMidYMid meet"
           xml:space="preserve"><polygon
          points="160,115.4 180.7,96 352,256 180.7,416 160,396.7 310.5,256 "></polygon></svg>
      <?php print render($item); ?>
    </li>
  <?php endforeach; ?>
</ul>
