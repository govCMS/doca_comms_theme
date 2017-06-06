<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>


<div class="grid-data__palette">
  <div class="grid-data">


    <div class="grid-data__item">
      <div class="grid-data__title">
        <a href="" class="grid-data__link">
          <img src="http://lorempixel.com/450/450/" class="grid-data__image">
          <span class="grid-data__link-text">
          Test title
          <svg focusable="false" xmlns='http://www.w3.org/2000/svg' height='15' version='1.1' viewBox='0 0 416 416'
               width='10' xml:space='preserve'><polygon
              points='160,115.4 180.7,96 352,256 180.7,416 160,396.7 310.5,256 '></polygon></svg>
        </span>
        </a>
      </div>
    </div>

    <div class="grid-data__item">
      <?php foreach ($rows as $id => $row): ?>
        <div class="grid-data__title">
          <a href="" class="grid-data__link">
            <?php print $row; ?>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
