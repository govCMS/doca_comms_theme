<?php

/**
 * @file
 * Doca common admin theme.
 */

// Include the helper functions to make sharing between the main and admin themes easier.
require_once drupal_get_path('theme', 'doca_common') . '/includes/helper.inc';

/**
 * Implements hook_form_alter().
 *
 * Conditionally remove the Archived state from publishing options if the node
 * has a currently published revision.
 */
function doca_admin_form_node_form_alter(&$form, &$form_state, $form_id) {
  $node = $form['#node'];
  if (!empty($node->nid) && isset($node->workbench_moderation['published']->vid)) {
    unset($form['options']['workbench_moderation_state_new']['#options']['archive']);
  }
  if ($node->type == 'funding') {
    $options = &$form['field_consultation_date_status'][LANGUAGE_NONE]['#options'];
    $options['upcoming'] = str_replace('consultation', 'funding', $options['upcoming']);
    $options['current'] = str_replace('consultation', 'funding', $options['current']);
  }
}

function doca_admin_form_bean_form_alter(&$form, $form_state, $form_id) {
  if ($form['#bundle'] == 'landing_page_component') {
    if (isset($form['field_optional_components']['und']) && isset($form['field_optional_components']['und'][0])) {
      if ($form['field_optional_components']['und'][0]['#bundle'] == 'subscribe_block') {
        $form['field_optional_components']['und'][0]['field_single_full_name']['#states'] = [
          'visible' => [
            ':input[name="field_optional_components[und][0][field_hide_name_field][und]"]' => ['checked' => FALSE],
          ],
        ];
      }
    }
  }
}

/**
 * Implements hook_form_alter().
 */
function doca_admin_form_book_node_form_alter(&$form, &$form_state) {
  $pmla_tid = array_search(' PMLA', $form['workbench_access']['workbench_access']['#options']);
  $form['workbench_access']['workbench_access']['#default_value'] = $pmla_tid;
  $form['workbench_access']['workbench_access']['#access'] = FALSE;
  $form['field_illustrator'][LANGUAGE_NONE]['add_more']['add_more_bundle_author']['#value'] = 'Add Illustrator';
  $form['field_name_search']['#access'] = FALSE;
  $form['#submit'][] = '_doca_admin_book_node_author_submit';
}

/**
 * Function _doca_admin_book_node_author_submit.
 * Creates the new value for the Name Search field, which is used in the filter
 * view to allow searching accross multiple authors and illustrators.
 *
 * @param $form
 * @param $form_state
 */
function _doca_admin_book_node_author_submit(&$form, &$form_state) {
  $name_search = '';
  if (isset($form_state['values']['field_author'][LANGUAGE_NONE])) {
    _doca_admin_book_node_author_get_values($form_state['values']['field_author'][LANGUAGE_NONE], $name_search);
  }
  if (isset($form_state['values']['field_illustrator'][LANGUAGE_NONE])) {
    _doca_admin_book_node_author_get_values($form_state['values']['field_illustrator'][LANGUAGE_NONE], $name_search);
  }
  $form_state['values']['field_name_search'] = [
    LANGUAGE_NONE => [
      [
        'value' => $name_search,
      ],
    ],
  ];
}

/**
 * Function _doca_admin_book_node_author_get_values.
 * A healper function to fill the $name_search param for each author paragraph.
 *
 * @param $value_array
 * @param $name_search
 */
function _doca_admin_book_node_author_get_values($value_array, &$name_search) {
  $name_search = $name_search != '' ? $name_search : $name_search . ' ';
  foreach ($value_array as $authors) {
    if (isset($authors['field_pbundle_subtitle'][LANGUAGE_NONE][0]['value'])) {
      $name_search .= ' ' . $authors['field_pbundle_subtitle'][LANGUAGE_NONE][0]['value'];
    }
    $name_search = $name_search != '' ? $name_search : $name_search . ' ';
    if (isset($authors['field_pbundle_title'][LANGUAGE_NONE][0]['value'])) {
      $name_search .= ' ' . $authors['field_pbundle_title'][LANGUAGE_NONE][0]['value'];
    }
  }
}

/**
 * Implements hook_form_workbench_moderation_moderate_form_alter.
 *
 * @param array &$form
 *        The drupal form array.
 * @param array &$form_state
 *        The drupal form_state array.
 * @param string $form_id
 *        The drupal form_id string.
 */
function doca_admin_form_workbench_moderation_moderate_form_alter(&$form, &$form_state, $form_id) {
  if (!empty($form['node']['#value'])) {
    $node = $form['node']['#value'];
    if (!empty($node->nid) && isset($node->workbench_moderation['published']->vid)) {
      unset($form['state']['#options']['archive']);
    }
  }
}

/**
 * An additional validation hook for form_system_theme_settings_alter.
 *
 * @param array &$form
 *        The drupal form array.
 * @param array &$form_state
 *        The drupal form_state array.
 */
function _doca_theme_form_system_theme_settings_alter_validate(&$form, &$form_state) {
  for ($i = 1; $i < 5; $i++) {
    if (isset($form_state['values']['sub_theme_' . $i]) && $form_state['values']['sub_theme_' . $i] > 0) {
      $form_state['values']['sub_theme_' . $i . '_title'] = taxonomy_term_load($form_state['values']['sub_theme_' . $i])->name;
    }
  }
}

/**
 * An additional post save hook for form_system_theme_settings_alter.
 *
 * @param array &$form
 *        The drupal form array.
 * @param array &$form_state
 *        The drupal form_state array.
 */
function _doca_theme_form_system_theme_settings_alter_submit(&$form, &$form_state) {

  $subsite1 = $form_state['values']['sub_theme_1'];
  $subsite2 = $form_state['values']['sub_theme_2'];
  $subsite3 = $form_state['values']['sub_theme_3'];
  $subsite4 = $form_state['values']['sub_theme_4'];

  // Go through each of the simple contexts that can be changed to the dynamic
  // business areas and change their taxonomy term locations.
  $contexts = context_enabled_contexts();
  $context = $contexts['apply_subsite_class_subsite_2'];
  _doca_theme_reset_menu($context, $subsite2);

  $context = $contexts['apply_subsite_class_subsite_3'];
  _doca_theme_reset_menu($context, $subsite3);

  $context = $contexts['apply_subsite_class_subsite_1'];
  _doca_theme_reset_menu($context, $subsite1);

  $context = $contexts['display_subsite_2_nav'];
  _doca_theme_reset_block($context, $subsite2);
  _doca_theme_reset_menu($context, $subsite2);

  $context = $contexts['display_subsite_3_nav'];
  _doca_theme_reset_block($context, $subsite3);
  _doca_theme_reset_menu($context, $subsite3);

  $context = $contexts['display_subsite_1_nav_menu'];
  _doca_theme_reset_block($context, $subsite1);
  _doca_theme_reset_menu($context, $subsite1);

  $context = $contexts['clone_of_apply_subsite_class_subsite_2'];
  _doca_theme_reset_term($context, $subsite2);

  $context = $contexts['clone_of_apply_subsite_class_subsite_3'];
  _doca_theme_reset_term($context, $subsite3);

  $context = $contexts['clone_of_apply_subsite_class_subsite_1'];
  _doca_theme_reset_term($context, $subsite1);

  $context = $contexts['clone_of_display_subsite_2_nav'];
  _doca_theme_reset_block($context, $subsite2);
  _doca_theme_reset_term($context, $subsite2);

  $context = $contexts['clone_of_display_subsite_3_nav'];
  _doca_theme_reset_block($context, $subsite3);
  _doca_theme_reset_term($context, $subsite3);

  $context = $contexts['clone_of_display_subsite_1_nav_menu'];
  _doca_theme_reset_block($context, $subsite1);
  _doca_theme_reset_term($context, $subsite1);

  // Change the default form ID for the Funding and Support.
  $field = field_read_instance('node', 'field_funding_app_webform', 'funding');
  $field['default_value'] = [
    0 => [
      'target_id' => $form_state['values']['funding_default_wform_nid'],
    ],
  ];
  field_update_instance($field);
}

/**
 * Helper function to reset the default menu item in the subsite contexts.
 *
 * @param object $context
 *        The drupal context module stdClass object.
 * @param int $tid
 *        The new term id.
 */
function _doca_theme_reset_menu($context, $tid) {
  reset($context->conditions['menu']['values']);
  $key = key($context->conditions['menu']['values']);
  unset($context->conditions['menu']['values'][$key]);
  $context->conditions['menu']['values']['taxonomy/term/' . $tid] = 'taxonomy/term/' . $tid;
  context_save($context);
}

/**
 * Helper function to reset the Taxonomy term condition on sub site contexts.
 *
 * @param object $context
 *        The drupal context module stdClass object.
 * @param int $tid
 *        The new term id.
 */
function _doca_theme_reset_term($context, $tid) {
  reset($context->conditions['node_taxonomy']['values']);
  unset($context->conditions['node_taxonomy']['values']);
  $context->conditions['node_taxonomy']['values'] = [$tid => $tid];
  context_save($context);
}

/**
 * Helper function to reset the block reaction in the subsite contexts.
 *
 * @param object $context
 *        The drupal context module stdClass object.
 * @param int $tid
 *        The new term id.
 */
function _doca_theme_reset_block(&$context, $tid) {
  $key = key($context->reactions['block']['blocks']);
  if ($tid < 1) {
    unset($context->reactions['block']['blocks'][$key]);
  }
  // Get the block ID for the menu block of the second sub theme.
  $results = db_query("select name from variable where name like 'menu_block___parent'")
    ->fetchCol(0);
  foreach ($results as $name) {
    $value = str_replace('main-menu:', '', variable_get($name));
    $term = db_query("select link_path from {menu_links} ml where ml.mlid = :mlid", [':mlid' => $value])
      ->fetchCol(0)[0];
    if ($term == 'taxonomy/term/' . $tid) {
      $menu_block = str_replace('menu_block_', '', str_replace('_parent', '', $name));
      if ($key != 'menu_block-' . $menu_block) {
        $context->reactions['block']['blocks']['menu_block-' . $menu_block]['module'] = 'menu_block';
        $context->reactions['block']['blocks']['menu_block-' . $menu_block]['delta'] = $menu_block;
        $context->reactions['block']['blocks']['menu_block-' . $menu_block]['region'] = 'highlighted';
        $context->reactions['block']['blocks']['menu_block-' . $menu_block]['weight'] = -10;
        unset($context->reactions['block']['blocks'][$key]);
      }
    }
  }
}

/**
 * Implements hook_form_FORM_ID_alter().
 *
 * @param array &$form
 *        The drupal form array.
 * @param array &$form_state
 *        The drupal form_state array.
 */
function doca_admin_form_consultation_node_form_alter(&$form, &$form_state) {
  // Get the node.
  $node = $form['#node'];

  // Get the value for whether the user should have access.
  $access = _doca_admin_return_user_has_role();
  // If the user has access.
  if ($access) {
    // Work out if this node can validly accept late submissions.
    $accept_late_submissions = _doca_admin_accept_late_submission($node);

    // If able to accept late submissions.
    if ($accept_late_submissions) {
      // Get the late submission URL.
      $url = _doca_admin_return_late_submission_url($node);
      // Create a message to let the admin know the URL.
      $args = [
        '!url' => $url,
      ];
      $message = t('Use the following URL for late submissions: !url', $args);
      // Finally output the message.
      drupal_set_message($message);
    }
  }
}

/**
 * Implements hook_form_FORM_ID_alter().
 */
function doca_admin_form_funding_node_form_alter(&$form, &$form_state) {
  // Add validation callback to handle auto clearing funding updates.
  $form['#validate'][] = 'doca_admin_clear_updates';
  $rolling = taxonomy_get_term_by_name('Rolling', 'funding_type');
  $rolling = reset($rolling);
  drupal_add_js([
    'doca_admin' => [
      'rolling_tid' => $rolling->tid,
    ],
  ], 'setting');
  $form['#attached']['js'][] = drupal_get_path('theme', 'doca_admin') . '/js/script.js';
}

/**
 * Validation callback for funding node forms.
 */
function doca_admin_clear_updates($form, &$form_state) {
  if (taxonomy_term_load($form_state['values']['field_funding_type'][LANGUAGE_NONE][0]['tid'])->name == 'Rolling') {
    // Don't validate on insert, only on changes.
    if (!isset($form['#node']->field_consultation_date) || empty($form['#node']->field_consultation_date)) {
      return;
    }

    // Grab current field value from node.
    $current_field = reset($form_state['node']->field_consultation_date[$form_state['node']->language]);

    // Check validity of form input.
    if (!isset($form_state['values']['field_consultation_date']) || empty($form_state['values']['field_consultation_date'])) {
      // Nothing to validate. Bail.
      return;
    }

    // Get new field value from form_state.
    $new_field = reset($form_state['values']['field_consultation_date'][$form_state['node']->language]);

    // Compare versions of the start dates.
    if ($current_field['value'] != $new_field['value']) {
      // The funding start date is being changed, remove updates!
      if (isset($form_state['values']['field_updates']) && !empty($form_state['values']['field_updates'])) {
        doca_base_paragraphs_deleteconfirm($form, $form_state);
      }
    }

    // Ensure the user has only selected either a webform or a smartygrants link.
    $smart_grant = isset($form_state['values']['field_smartygrants_link'][LANGUAGE_NONE]) && !empty($form_state['values']['field_smartygrants_link'][LANGUAGE_NONE][0]['url']);
    $application_webform = isset($form_state['values']['field_funding_app_webform'][LANGUAGE_NONE]) && !empty($form_state['values']['field_funding_app_webform'][LANGUAGE_NONE][0]['target_id']);
    if ($smart_grant && $application_webform) {
      form_set_error('field_smartygrants_link', 'Please add either an <em>Application webform</em> or a <em>Smartygrants link</em>, you cannot use both.');
      form_set_error('field_funding_app_webform', '');
    }
  }
}

/**
 * Remove funding update paragraph bundles when start date changes.
 *
 * This is an adaptation of the submit callback for confirming
 * deletion of a paragraph item. Paragaphs handles all of it's
 * CRUD through ajax callbacks that we can't invoke directly or
 * just shortcut by unsetting field values in $form_state.
 *
 * Instead, we call this function during form validation and spoof
 * pressing the confirm deletion button on each paragraph item.
 * This ensures that all the normal paragraphs routines and field API
 * hooks fire and paragraphs items are retained for old revisions.
 *
 * @param array $form
 *         Drupal form array.
 * @param array &$form_state
 *         Drupal form_state array.
 */
function doca_base_paragraphs_deleteconfirm($form, &$form_state) {
  // Loop over each 'updates' paragraph item widget in the form.
  foreach ($form['field_updates'][LANGUAGE_NONE] as $delta => $update) {
    if (!is_int($delta)) {
      // Only look at field values, not formAPI stuff.
      continue;
    }

    // Spoof the #array_parents value for transplanted paragraphs code below.
    $spoofed_array_parents = [
      'field_updates',
      LANGUAGE_NONE,
      $delta,
      'actions',
      'remove_button',
    ];

    // Code below this point is adapted from
    // function paragraphs_deleteconfirm_submit().

    // Where in the form we'll find the parent element.
    $address = array_slice($spoofed_array_parents, 0, -3);

    // Go one level up in the form, to the widgets container.
    $parent_element = drupal_array_get_nested_value($form, $address);
    $field_name = $parent_element['#field_name'];
    $langcode = $parent_element['#language'];
    $parents = $parent_element['#field_parents'];

    $field_state = field_form_get_state($parents, $field_name, $langcode, $form_state);

    if (isset($field_state['entity'][$delta])) {
      $field_state['entity'][$delta]->removed = 1;
      $field_state['entity'][$delta]->confirmed_removed = 1;
    }

    // Fix the weights. Field UI lets the weights be in a range of
    // (-1 * item_count) to (item_count). This means that when we remove one,
    // the range shrinks; weights outside of that range then get set to
    // the first item in the select by the browser, floating them to the top.
    // We use a brute force method because we lost weights on both ends
    // and if the user has moved things around, we have to cascade because
    // if I have items weight weights 3 and 4, and I change 4 to 3 but leave
    // the 3, the order of the two 3s now is undefined and may not match what
    // the user had selected.
    $input = drupal_array_get_nested_value($form_state['input'], $address);
    // Sort by weight,
    // but first remove garbage values to ensure proper '_weight' sorting.
    unset($input['add_more']);
    uasort($input, '_field_sort_items_helper');

    // Reweight everything in the correct order.
    $weight = -1 * $field_state['items_count'] + 1;
    foreach ($input as $key => $item) {
      if ($item) {
        $input[$key]['_weight'] = $weight++;
      }
    }

    drupal_array_set_nested_value($form_state['input'], $address, $input);
    field_form_set_state($parents, $field_name, $langcode, $form_state, $field_state);
  }

  // Alert the editor that we've made some automated changes to their new draft.
  drupal_set_message(t('The funding updates for this draft have been automatically cleared due to a change in the application deadline start date.'), 'warning');
}

/**
 * Implements hook form alter.
 *
 * @param array &$form
 *        The drupal form array.
 * @param array &$form_state
 *        The drupal form_state array.
 */
function doca_admin_form_file_entity_edit_alter(&$form, &$form_state) {
  if ($form['#bundle'] == 'image') {
    array_unshift($form['#validate'], '_doca_admin_form_file_entity_edit_validate');
    array_unshift($form['actions']['submit']['#validate'], '_doca_admin_form_file_entity_edit_validate');
  }
}

/**
 * Form validation function for image file entities.
 *
 * This function ensure that, if a title or description is entered there is a
 * valid artist.
 *
 * @param array $form
 *        The drupal form array.
 * @param array &$form_state
 *        The drupal form_state array.
 */
function _doca_admin_form_file_entity_edit_validate($form, &$form_state) {
  $invalid = ((!isset($form_state['values']['field_read_more_text'][LANGUAGE_NONE]) ||
        $form_state['values']['field_read_more_text'][LANGUAGE_NONE][0]['value'] != '') ||
      (!isset($form_state['values']['field_image_title'][LANGUAGE_NONE]) ||
        $form_state['values']['field_image_title'][LANGUAGE_NONE][0]['value'] != '')) &&
    (isset($form_state['values']['field_artist'][LANGUAGE_NONE]) &&
      $form_state['values']['field_artist'][LANGUAGE_NONE][0]['value'] == '');
  if ($invalid) {
    form_set_error('field_artist', t('If either a title or description is added, the Artist field cannot be blank.'));
  }
}
