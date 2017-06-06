<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<?php if (!empty($title)): ?>
  <h3><?php print $title; ?></h3>
<?php endif; ?>
<?php foreach ($rows as $delta => $row): ?>
  <?php if ($delta == 1): ?>
    <div class="clearfix">
  <?php endif; ?>
  <?php print $row; ?>
  <?php if ($delta == 2): ?>
    </div>
  <?php endif; ?>
<?php endforeach; ?>
