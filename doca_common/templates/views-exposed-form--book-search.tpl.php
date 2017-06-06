<?php

/**
 * @file
 * This template handles the layout of the views exposed filter form.
 */
?>
<?php if (!empty($q)): ?>
  <?php
  // This ensures that, if clean URLs are off, the 'q' is added first so that
  // it shows up first in the URL.
  print $q;
  ?>
<?php endif; ?>
<div class=" ">
  <div class="filter--orig">
    <?php if (!empty($widgets)): ?>
      <div class="filter_group">
        <?php foreach ($widgets as $id => $widget): ?>
          <div class="filter clearfix <?php
          if(($widget->id == 'edit-combine') || ($widget->id == 'edit-field-book-type-tid') || ($widget->id == 'edit-field-book-year-tid')) {
            print 'element-invisible';
          }
          ?>">
            <?php if (!empty($widget->label)): ?>
              <label class="filter__label" for="<?php print $widget->id; ?>">
                <?php print $widget->label; ?>
              </label>
            <?php endif; ?>
            <?php if (!empty($widget->operator)): ?>
              <?php print $widget->operator; ?>
            <?php endif; ?>
            <?php if ($widget->id == 'edit-field-book-type-tid'): ?>
              <div id="category-wrapper"><?php print $widget->widget; ?></div>
            <?php elseif ($widget->id == 'edit-field-book-year-tid'): ?>
              <div id="year-wrapper"><?php print $widget->widget; ?></div>
            <?php else: ?>

              <?php print $widget->widget; ?>
              <?php if ($widget->id == 'edit-combine'): ?>
                <div class="filter__button">
                  <?php print $button; ?>
                  <?php if (!empty($reset_button)): ?>
                    <?php print $reset_button; ?>
                  <?php endif; ?>
                </div>
              <?php endif; ?>

            <?php endif; ?>
            <?php if (!empty($widget->description)): ?>
              <?php print $widget->description; ?>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>

    <?php endif; ?>

    <?php if (!empty($sort_by) || !empty($items_per_page) || !empty($offset)): ?>
      <div class="filter__right">

        <?php if (!empty($sort_by)): ?>
          <div class="filter">
            <?php print $sort_by; ?>
          </div>
          <div class="filter">
            <?php print $sort_order; ?>
          </div>
        <?php endif; ?>
        <?php if (!empty($items_per_page)): ?>
          <div class="filter">
            <?php print $items_per_page; ?>
          </div>
        <?php endif; ?>
        <?php if (!empty($offset)): ?>
          <div class="filter">
            <?php print $offset; ?>
          </div>
        <?php endif; ?>

      </div>
    <?php endif; ?>
    
  </div>
</div>
