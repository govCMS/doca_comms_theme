<?php

/**
 * @file
 * The template for the Stackla paragraph bundle.
 */

$stackla_arr = reset($items[0]['entity']['paragraphs_item']);
?>
<?php if (!empty($stackla_arr['field_short_title']['#items'][0]['value'])): ?>
  <div id="stackla-title"
       class="stackla-title layout-max"><?php print $stackla_arr['field_short_title']['#items'][0]['value']; ?></div>
<?php endif; ?>
<div class="stacklafw layout-max--sm-med-lrg panel-background-2"
     data-id="<?php print $stackla_arr['field_stackla_widget_id']['#items'][0]['value']; ?>"
     data-hash="<?php print $stackla_arr['field_stackla_hash_id']['#items'][0]['value']; ?>" data-ct=""
     data-alias="<?php print $stackla_arr['field_stackla_domain']['#items'][0]['value']; ?>" data-ttl="30"></div>
