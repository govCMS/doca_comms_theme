<?php

/**
 * @file
 * Theme helper functions.
 */

/**
 * Helper function to add consultation variables to template files.
 */
function _consultation_vars(&$variables, $element_object) {
  $consultation['now'] = time();
  $consultation['wrapped_entity'] = entity_metadata_wrapper('node', $element_object);
  $date = $consultation['wrapped_entity']->field_consultation_date->value();
  $consultation['start'] = $date['value'];
  $consultation['end'] = $date['value2'];
  $consultation['duration'] = ($consultation['end'] - $consultation['start']);
  $consultation['date_status'] = $consultation['wrapped_entity']->field_consultation_date_status->value();
  $consultation['archived'] = _consultation_is_archived($consultation);
  $consultation['in_review'] = ($consultation['end'] < $consultation['now']) && !$consultation['archived'];
  $consultation['started_text'] = 'Started';
  if ($consultation['start'] > $consultation['now']) {
    $consultation['started_text'] = 'Starts';
  }
  $consultation['ended_text'] = 'Ends';
  if ($consultation['end'] < $consultation['now']) {
    $consultation['ended_text'] = 'Ended';
  }
  $consultation['percentage'] = _consultation_percentage($consultation);
  $consultation['days_total'] = round($consultation['duration'] / strtotime('1 day', 0));
  $consultation['days_remain'] = _consultation_days_remain($consultation);
  $consultation['submission_enabled'] = $consultation['wrapped_entity']->field_formal_submission_enabled->value();
  $consultation['status_class'] = ($consultation['percentage'] === 100 ? 'progress-bar--complete' : '');
  if ($element_object->type == 'consultation') {
    _consultation_status_message($consultation);
  }
  else {
    _consultation_status_message($consultation, 'Applications under consideration', 'Funding round finalised');
  }
  $consultation['status_msg_class'] = strtolower($consultation['status_msg_class']);
  $consultation['hide_form'] = !$consultation['submission_enabled'] || ($consultation['start'] > $consultation['now']) || ($consultation['end'] < $consultation['now']);
  $variables['consultation'] = $consultation;
  if ($element_object->type == 'funding') {
    $variables['funding'] = $consultation;
  }

  return $variables;
}

/**
 * Helper function - days_remain for progress bar.
 */
function _consultation_days_remain($consultation) {

  $days_total = round($consultation['duration'] / strtotime('1 day', 0));

  if ($consultation['percentage'] === 0) {
    $days_remain = $days_total;
  }
  elseif ($consultation['percentage'] === 100) {
    $days_remain = "0";
  }
  elseif (($consultation['end'] > $consultation['now']) && ($consultation['end'] - $consultation['now'] < strtotime('1 day', 0))) {
    $days_remain = "< 1";
  }
  else {
    $days_remain = round(($consultation['end'] - time()) / strtotime('1 day', 0));
  }

  return $days_remain;
}

/**
 * Helper function for the consultation status message.
 */
function _consultation_status_message(&$consultation, $in_review = 'Now under review', $public = 'Submissions now public') {

  $status_message = t('Open');
  $consultation['ongoing'] = FALSE;
  $node_wrapper = $consultation['wrapped_entity'];
  $is_funding = $node_wrapper->getBundle() == 'funding';

  if ($consultation['in_review']) {
    $status_message = t($in_review);
  }

  $formal_submission_public = isset($node_wrapper->field_formal_submission_public) && $node_wrapper->field_formal_submission_public->value();
  if ($formal_submission_public) {
    $status_message = t($public);
  }

  if (!$is_funding && $consultation['archived']) {
    $status_message = t('Archived');
  }

  if ($consultation['start'] > $consultation['now'] && $node_wrapper->field_consultation_date_status->value() == 'current') {
    $status_message = 'Upcoming';
  }

  if ($is_funding && !empty($node_wrapper->field_funding_type->value()) && $node_wrapper->field_funding_type->value()->name == 'Ongoing') {
    $status_message = 'Open';
    $consultation['ongoing'] = TRUE;
  }

  if ($is_funding && !is_null($node_wrapper->field_outcomes_posted->value())) {
    $status_message = 'This program has closed';
  }

  $consultation['status_msg_class'] = str_replace(' ', '-', $status_message);

  $consultation['status_message'] = $status_message;

}

/**
 * Helper function for hide form message.
 */
function _consultation_submissions_closed_message($consultation) {

  $submissions_closed_message = NULL;

  if ($consultation['in_review']) {
    $submissions_closed_message = t('Submissions are now closed for this consultation and are now under review');
  }

  $formal_submission_public = $consultation['wrapped_entity']->field_formal_submission_public->value();
  if ($formal_submission_public) {
    $submissions_closed_message = t('Submissions are now closed for this consultation and have been made public');
  }

  return $submissions_closed_message;

}

/**
 * Helper function to determine if consultation is archived.
 */
function _consultation_is_archived($consultation) {
  $outcomes_posted_date = $consultation['wrapped_entity']->field_outcomes_posted->value();
  if (isset($outcomes_posted_date)) {
    $archived_date = $outcomes_posted_date + strtotime('6 months', 0);
    $is_archived = ($consultation['now'] > $archived_date);

    return $is_archived;
  }
}

/**
 * Helper function to determine percentage complete.
 */
function _consultation_percentage($consultation) {
  $time_until_it_starts = ($consultation['now'] - $consultation['start']);
  $percentage = $time_until_it_starts / $consultation['duration'] * 100;
  $percentage = max(0, min(100, $percentage));

  return $percentage;
}

/*
 * Helper function: Return the 'External source' field value.
 */
function _doca_admin_return_external_source($node, $wrapper = NULL) {
  // Set default external source value.
  $external_source = FALSE;

  // If the wrapper is NULL.
  if (is_null($wrapper)) {
    // Create a custom wrapper.
    $wrapper = entity_metadata_wrapper('node', $node);
  }

  if (isset($node->field_external_source)) {
    $external_source_field_value = $wrapper->field_external_source->value();
    // If the 'External source' field exists and is not blank.
    if (!empty($external_source_field_value)) {
      // Get the 'External source' field.
      $external_source = $wrapper->field_external_source->value();
    }
  }

  return $external_source;
}

/**
 * Helper function: Return whether an entity has an 'External source' filled in.
 */
function _doca_admin_return_node_has_external_source($node) {
  return (_doca_admin_return_external_source($node)) != FALSE ? TRUE : FALSE;
}

/**
 * Helper function: Return whether a node can validly accept late submissions.
 *
 * Check that the 'Enable late submissions' value is set.
 * Check that the date has passed.
 */
function _doca_admin_accept_late_submission($node) {
  // Set a default answer.
  $answer = FALSE;
  // Create an entity metadata wrapper.
  $wrapper = entity_metadata_wrapper('node', $node);

  // Check if the 'Enable late submissions' field exists and is TRUE.
  if (isset($node->field_enable_late_submissions) && $wrapper->field_enable_late_submissions->value() === TRUE) {
    // Get the consultation date end.
    $consultation_date_end = _doca_admin_return_end_consultation_date($node, $wrapper);
    // Get the current time.
    $time = time();
    // Check if the current date is greater than the end date (i.e. it's in the past).
    if ($time > $consultation_date_end) {
      // Update the answer.
      $answer = TRUE;
    }
  }

  // Return the answer.
  return $answer;
}

/**
 * Helper function: Return salted hash for a given node ID.
 */
function _doca_admin_return_salted_hash($nid) {
  return crc32($nid);
}

/**
 * Helper function: Return formatted late submission URL.
 */
function _doca_admin_return_late_submission_url($node) {
  global $base_url;

  // Get the salted hash for this nid.
  $salted_hash = _doca_admin_return_salted_hash($node->nid);

  // Get the node path.
  $uri = entity_uri('node', $node);
  // Update the options with the query.
  $uri['options']['query']['fso'] = $salted_hash;
  // Output the URL.
  $url = $base_url . url($uri['path'], $uri['options']);

  // Return the URL.
  return $url;
}

/**
 * Helper function: Return whether a user has a given role.
 */
function _doca_admin_return_user_has_role($roles = []) {
  global $user;

  // Set default access value.
  $access = FALSE;

  // If no roles are provided.
  if (empty($roles)) {
    // Set some default roles.
    $roles = [
      'publisher',
      'site builder',
      'site editor',
      'administrator',
    ];
  }

  // Loop through the user roles.
  foreach ($user->roles as $role) {
    // If this role is one we are looking for.
    if (in_array(strtolower($role), $roles)) {
      // Update the access value.
      $access = TRUE;
      // There is no need to check the other roles; so we can safely end the loop.
      break;
    }
  }

  // Return the access value.
  return $access;
}

/**
 * Helper function: Return end consultation date.
 */
function _doca_admin_return_end_consultation_date($node, $wrapper) {
  // Set default consultation date end value.
  $consultation_date_end = '';

  // If the 'Consultation date' field exists and is not blank.
  $consultation_date_value = $wrapper->field_consultation_date->value();
  if (isset($node->field_consultation_date) && !empty($consultation_date_value)) {
    // Get the 'Consultation date' field.
    $consultation_date = $consultation_date_value;
    // Get the end date.
    $consultation_date_end = $consultation_date['value2'];
  }

  return $consultation_date_end;
}

/**
 * Render webform.
 */
function _doca_common_webform_render($nid = NULL) {
  $wnode = node_load($nid);
  $form = drupal_get_form('webform_client_form_' . $nid, $wnode, []);

  return render($form);
}
