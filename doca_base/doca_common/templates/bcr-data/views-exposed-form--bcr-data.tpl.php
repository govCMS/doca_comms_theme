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
<div class="spacer filter__wrapper">
  <h2><?php print t('Search the Data Lab'); ?></h2>
  <p><?php print t('Find, compare and share the latest Comms data, charts, maps and tables'); ?></p>
  <div class="filter--yellow">
    <?php foreach ($widgets as $id => $widget): ?>
      <?php if ($widget->id === 'edit-search-api-views-fulltext'): ?>

        <div class="filter--search">
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

      <?php endif; ?>
    <?php endforeach; ?>

    <?php if (!empty($widgets)): ?>

      <div class="filter__left">
        <b class="filter__label--main"><?php print t('Filter by'); ?></b>
        <?php foreach ($widgets as $id => $widget): ?>
          <?php if ($widget->id != 'edit-search-api-views-fulltext'): ?>

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

          <?php endif; ?>
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
      <span class="filter__submit">
        <?php print $button; ?>
      </span>
      <?php if (!empty($reset_button)): ?>
        <span class="filter__clear">
          <?php print $reset_button; ?>
        </span>
      <?php endif; ?>
    </div>

  </div>
</div>
