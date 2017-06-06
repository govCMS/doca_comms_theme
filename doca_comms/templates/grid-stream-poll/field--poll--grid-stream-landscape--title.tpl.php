<?php
/**
 * @file
 * Default template implementation to display the value of a field.
 */
?>
<?php $title = isset($one_liner) ? $one_liner : $element['#object']->title; ?>
<h3 class="grid-stream__title" id="poll_<?php print $element['#object']->nid; ?>__title">
  <?php print t('Quick Poll:') . ' <b>' . $title . '</b>'; ?>
</h3>
