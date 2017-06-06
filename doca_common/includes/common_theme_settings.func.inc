<?php

/**
 * @file
 * Common theme settings functions.
 */

/**
 * fetch webform list.
 */
function doca_common_get_webform_list() {
  $options = [];
  $webform_types = webform_node_types();
  if (empty($webform_types)) {
    return $options;
  }

  $query = db_select('webform', 'w');
  $query->innerJoin('node', 'n', 'n.nid = w.nid');
  $query->fields('n', ['nid', 'title']);
  $query->condition('n.type', $webform_types, 'IN');
  $result = $query->execute();

  foreach ($result as $node) {
    $options[$node->nid] = check_plain($node->title);
  }

  return $options;
}
