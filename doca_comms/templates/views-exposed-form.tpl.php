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
<div class="filter__wrapper">
  <div class="filter--orig">
  <?php if (!empty($widgets)): ?>

  <div class="filter__left">
    <?php foreach ($widgets as $id => $widget): ?>
        <div class="filter">
            <?php if (!empty($widget->label)): ?>
                <label class="filter__label" for="<?php print $widget->id; ?>">
                    <?php print $widget->label; ?>
                </label>
            <?php endif; ?>
            <?php if (!empty($widget->operator)): ?>
                <?php print $widget->operator; ?>
            <?php endif; ?>
            <?php print $widget->widget; ?>
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
    <div class="filter__button">
      <?php print $button; ?>
      <?php if (!empty($reset_button)): ?>
        <?php print $reset_button; ?>
      <?php endif; ?>
    </div>
    </div>
</div>
