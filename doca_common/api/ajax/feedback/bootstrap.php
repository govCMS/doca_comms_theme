<?php

/**
 * Bootstrap.
 */

// Bootstrap Drupal.
define('DRUPAL_ROOT', $_SERVER['DOCUMENT_ROOT']);
$cd = getcwd();
// Change scope to the Drupal path.
chdir(DRUPAL_ROOT);
require_once DRUPAL_ROOT . '/includes/bootstrap.inc';
drupal_bootstrap(DRUPAL_BOOTSTRAP_FULL);
chdir($cd);

/**
 * Send response message.
 */
function site_feedback_response($status = 'OK', $message = NULL, $sid = NULL, $data = NULL) {
  // Init messages.
  $message = array(
    'status' => $status,
    'message' => $message,
    'sid' => $sid,
    'data' => $data,
  );
  drupal_json_output($message);
  drupal_exit();
}
