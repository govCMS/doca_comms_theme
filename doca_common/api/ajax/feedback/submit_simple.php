<?php

/**
 * @file
 * Site feedback Ajax API.
 */

// Bootstrap Drupal.
require_once dirname(__FILE__) . '/bootstrap.php';

// Fetch POST variables.
$nid = empty($_POST['nid']) ? NULL : $_POST['nid'];
$sid = empty($_POST['sid']) ? NULL : $_POST['sid'];
$token = empty($_POST['token']) ? NULL : $_POST['token'];
$url = empty($_POST['url']) ? NULL : $_POST['url'];
$helpful = empty($_POST['option']) ? 0 : $_POST['option'];
$update = empty($_POST['update']) ? FALSE : $_POST['update'];

// Validate Webform node id.
if (is_null($nid)) {
  site_feedback_response('Error', 'Invalid Form ID');
}

// Validate Webform node.
$node = node_load($nid);
if (!$node) {
  site_feedback_response('Error', 'Invalid Form with ID');
}

// Validate URL.
if (is_null($url) || url_is_external($path)) {
  site_feedback_response('Error', 'Invalid URL');
}

if (!$update || empty($sid)) {
  // Keys in this array are the same keys on the fields in the webform.
  $data = array(
    'site_feedback_page_url' => $url,
    'site_feedback_helpful' => $helpful,
  );
  // Insert site feedback.
  site_feedback_insert($node, $data);
}

/**
 * Insert data into webform.
 */
function site_feedback_insert($node, $data) {
  global $user;

  module_load_include('inc', 'webform', 'webform.module');
  module_load_include('inc', 'webform', 'includes/webform.submissions');

  // This methods will arrange $data in the right way
  $data = _webform_client_form_submit_flatten($node, $data);
  $data = webform_submission_data($node, $data);

  $submission = (object) array(
    'nid' => $node->nid,
    'uid' => $user->uid,
    'sid' => NULL,
    'submitted' => REQUEST_TIME,
    'completed' => REQUEST_TIME,
    'modified' => REQUEST_TIME,
    'remote_addr' => ip_address(),
    'is_draft' => FALSE,
    'data' => $data,
  );

  $sid = webform_submission_insert($node, $submission);
  if ($sid) {
    site_feedback_response('OK', 'Successful', $sid);
  }
  else {
    site_feedback_response('Error', 'Submission Failure');
  }

}
