<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<?php if (!empty($title)): ?>
  <div class="clearfix"><?php print $title; ?></div>
<?php endif; ?>
<div class="clearfix">
  <?php foreach ($rows as $id => $row): ?>
    <div class="layout-four-column__item">
      <div<?php
      if ($classes_array[$id]):
        print ' class="' . $classes_array[$id] . '"';
      endif; ?>>
        <?php print $row; ?>
      </div>
    </div>
  <?php endforeach; ?>
</div>
