<?php

/**
 * @file
 * Contains the theme's functions to manipulate Drupal's default markup.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728096
 */

// Include the helper functions to make sharing between the main and admin themes easier.
require_once drupal_get_path('theme', 'dcomms_theme') . '/template.helpers.inc';

/**
 * Implements hook_preprocess_page().
 */
function dcomms_theme_preprocess_html(&$variables, $hook) {
  // Add offscreen class to body for mobile navigation.
  $variables['classes_array'][] = 'offscreen';
}

/**
 * Implements hook_js_alter().
 */
function dcomms_theme_js_alter(&$javascript) {
  $tabs_js_path = drupal_get_path('module', 'field_group') . '/horizontal-tabs/horizontal-tabs.js';
  unset($javascript[$tabs_js_path]);
}

/**
 * Implements hook_preprocess_page().
 */
function dcomms_theme_preprocess_page(&$variables, $hook) {
  // Add pathToTheme to Drupal.settings in JS.
  drupal_add_js('jQuery.extend(Drupal.settings, { "pathToTheme": "' . path_to_theme() . '" });', 'inline');

  // Site pages feedback.
  if (theme_get_setting('feedback_enabled') && !empty(theme_get_setting('feedback_wform_nid'))) {
    $wf_nid = theme_get_setting('feedback_wform_nid');
    $js_settings = array(
      'nid' => $wf_nid,
    );
    drupal_add_js(array('sitePagesFeedback' => $js_settings), 'setting');
    $variables['site_pages_feedback_form'] = _dcomms_theme_webform_render($wf_nid);
  }

  // Create template variables for the header menu block.
  $variables['header_search'] = _dcomms_theme_block_render('search', 'form');
  $variables['header_menu'] = _dcomms_theme_block_render('system', 'main-menu');
  // Create template variables for the footer menu blocks.
  $variables['footer_menu'] = _dcomms_theme_block_render('menu', 'menu-footer-menu');
  $variables['footer_auxilary_menu'] = _dcomms_theme_block_render('menu', 'menu-footer-sub-menu');

  $header = drupal_get_http_header("status");
  if ($header === "404 Not Found") {
    $variables['theme_hook_suggestions'][] = 'page__404';
  }
  if ($header === "403 Forbidden") {
    $variables['theme_hook_suggestions'][] = 'page__403';
  }

  // If this is the 'iframe_portrait' or 'iframe_landscape' Consultation page.
  if (array_search('page__consultations__iframe_portrait', $variables['theme_hook_suggestions']) || array_search('page__consultations__iframe_landscape', $variables['theme_hook_suggestions'])) {
    // Extend the theme hook suggestions to include a stripped page.
    $variables['theme_hook_suggestions'][] = 'page__stripped';
  }

  // Define page top announcement variable
  $page_top_announcement_paths = drupal_strtolower(theme_get_setting('page_top_announcement_paths'));
  $current_path = drupal_strtolower(drupal_get_path_alias($_GET['q']));
  $page_match = drupal_match_path($current_path, $page_top_announcement_paths);
  if ($current_path != $_GET['q']) {
    $page_match = $page_match || drupal_match_path($_GET['q'], $page_top_announcement_paths);
  }
  if ($page_match) {
    $variables['top_announcements'] = theme_get_setting('page_top_announcement_messages');
  }
}

/**
 * Get standard page node ids that are menu children of a given menu link.
 *
 * @param array $item
 *   A fully translated menu link.
 *
 * @return array
 *   Node ids that are menu children of $item.
 */
function dcomms_theme_get_standard_page_menu_children($item) {
  if ($item === FALSE || empty($item['menu_name']) || !isset($item['mlid'])) {
    return array();
  }
  $sql = "SELECT SUBSTR(ml.link_path, 6) AS nid
FROM {menu_links} ml
JOIN {node} n ON (n.nid = SUBSTR(ml.link_path, 6))
WHERE
  ml.link_path LIKE 'node/%' AND
  ml.menu_name = :menu_name AND
  plid = :plid AND
  n.status = 1 AND
  n.type = 'page'
ORDER BY ml.weight";

  return db_query($sql, array(
    ':menu_name' => $item['menu_name'],
    ':plid' => $item['mlid'],
  ))->fetchCol();
}

/**
 * Implements hook_preprocess_entity().
 */
function dcomms_theme_preprocess_entity(&$variables, $hook) {
  if ($variables['entity_type'] === 'bean' && $variables['bean']->type === 'standard_page_children' && $variables['view_mode'] === 'coloured_links_grid') {
    // Get menu link of current page.
    $item = menu_link_get_preferred();

    // Get children menu items that are standard pages.
    $nids = dcomms_theme_get_standard_page_menu_children($item);

    // Render the nodes in coloured grid view mode.
    $node_elements = array();
    foreach ($nids as $nid) {
      $node = node_load($nid);
      $node_elements[] = array(
        '#type' => 'container',
        '#attributes' => array(
          'class' => array('featured__grid-item'),
        ),
        'node' => node_view($node, 'coloured_links_grid'),
      );
    }

    // Render content.
    if (!empty($node_elements)) {
      $variables['content'] = array(
        '#type' => 'container',
        '#attributes' => array(
          'class' => array('featured-palette__wrapper'),
        ),
        'content' => array(
          '#type' => 'container',
          '#attributes' => array(
            'class' => array('featured__grid-container', 'featured-palette'),
          ),
          'nodes' => $node_elements,
        ),
      );
    }

    if ($variables['elements']['#bundle'] == 'accordion_item') {

      if (isset($variables['elements']['field_pbundle_image'])) {
        $variables['classes_array'][] = 'accordion__item--with-image';
      }

      else {
        $variables['classes_array'][] = 'accordion__item';
      }
    }
  }

  if ($variables['entity_type'] === 'paragraphs_item') {
    if ($variables['elements']['#bundle'] === 'subscribe_block') {
      drupal_add_js(array(
        'dcomms_theme' => array(
          'alertHideName' => $variables['field_hide_name_field'][0]['value'],
          'alertHideNumber' => $variables['field_hide_contact_number_field'][0]['value'],
          'alertMailGroup' => $variables['field_mail_groups'][0]['value'],
          'alertSuccessMessage' => $variables['field_success_message'][0]['value'],
        ),
      ), 'setting');
    }
  }
}

/**
 * Fill related content with content from a category term.
 *
 * @param array $related_content_nids
 *   Array of related content node ids.
 * @param int $limit
 *   Maximum number of related content nodes.
 * @param object $node
 *   Drupal node.
 * @param string $field_name
 *   Field name with category term.
 */
function _dcomms_theme_related_content_category_term(&$related_content_nids, $limit, $node, $field_name) {
  if (count($related_content_nids) < $limit && isset($node->{$field_name}[LANGUAGE_NONE][0]['tid'])) {
    $query = db_select('node', 'n')
      ->fields('n', array('nid'));
    $query->join('field_data_' . $field_name, 'tags', 'n.nid = tags.entity_id AND n.vid = tags.revision_id');
    $query->condition('n.status', 1, '=')
      ->condition('n.type', $node->type, '=')
      ->condition('n.nid', $node->nid, '<>');
    if (!empty($related_content_nids)) {
      $query->condition('n.nid', $related_content_nids, 'NOT IN');
    }
    $query->condition('tags.' . $field_name . '_tid', $node->{$field_name}[LANGUAGE_NONE][0]['tid'], '=')
      ->orderBy('title', 'ASC');
    $query->addTag('node_access');
    $result = $query->range(0, $limit - count($related_content_nids))
      ->execute();
    foreach ($result as $row) {
      $related_content_nids[] = $row->nid;
    }
  }
}

/**
 * Generated related content for a node.
 *
 * @param object $node
 *   Node.
 *
 * @return array
 *   Render Array.
 */
function _dcomms_theme_related_content($node) {
  $limit = 4;
  $related_content_nids = array();

  // First fill related content with content of same type with highest number
  // of the same tags.
  $tids = array();
  $tags = field_get_items('node', $node, 'field_tags');
  if ($tags) {
    foreach ($tags as $term) {
      $tids[] = $term['tid'];
    }
  }
  if (!empty($tids)) {
    $query = db_select('node', 'n')->fields('n', array('nid'));
    $query->join('field_data_field_tags', 'tags', 'n.nid = tags.entity_id AND n.vid = tags.revision_id');
    $query->condition('n.status', 1, '=')
      ->condition('n.nid', $node->nid, '<>')
      ->condition('tags.field_tags_tid', $tids, 'IN')
      ->groupBy('nid')
      ->orderBy('nid_count', 'DESC')
      ->orderBy('title', 'ASC')
      ->addExpression('COUNT(nid)', 'nid_count');
    $query->addTag('node_access');
    $result = $query->range(0, $limit)
      ->execute();
    foreach ($result as $row) {
      $related_content_nids[] = $row->nid;
    }
  }

  // Next fill related content with content of same type in this business area.
  _dcomms_theme_related_content_category_term($related_content_nids, $limit, $node, 'field_business_area');

  // Next fill related content with content of same type in this stream.
  _dcomms_theme_related_content_category_term($related_content_nids, $limit, $node, 'field_stream');

  // Next fill related content with content of same type in this audience.
  _dcomms_theme_related_content_category_term($related_content_nids, $limit, $node, 'field_audience');

  // Finally fill related content with content of same type.
  if (count($related_content_nids) < $limit) {
    $query = db_select('node', 'n')
      ->fields('n', array('nid'))
      ->condition('n.status', 1, '=')
      ->condition('n.type', $node->type, '=')
      ->condition('n.nid', $node->nid, '<>');
    if (!empty($related_content_nids)) {
      $query->condition('n.nid', $related_content_nids, 'NOT IN');
    }
    $query->orderBy('title', 'ASC');
    $query->addTag('node_access');
    $result = $query->range(0, $limit - count($related_content_nids))
      ->execute();
    foreach ($result as $row) {
      $related_content_nids[] = $row->nid;
    }
  }

  // Get list of links from related content nodes.
  $items = array();
  foreach (node_load_multiple($related_content_nids) as $related_nid => $related_node) {
    $items[] = l($related_node->title, 'node/' . $related_nid);
  }

  return array(
    '#theme' => 'list_arrow',
    '#items' => $items,
  );
}

/**
 * Implements hook_preprocess_node().
 */
function dcomms_theme_preprocess_node(&$variables, $hook) {
  $node = $variables['node'];
  // Adjust the submitted date format.
  $variables['pubdate'] = '<time pubdate datetime="' . format_date($variables['node']->created, 'custom', 'c') . '">' . format_date($variables['node']->created, 'custom', 'jS M Y') . '</time>';
  if ($variables['display_submitted']) {
    $variables['submitted'] = t('Published !datetime', array('!datetime' => $variables['pubdate']));
  }

  // Add a theme hook suggestion for type and view mode.
  $variables['theme_hook_suggestions'][] = 'node__' . $variables['type'] . '__' . $variables['view_mode'];

  // Add first/second update item to grid_stream_landscape view mode if exist.
  if ($variables['type'] == 'consultation' && $variables['view_mode'] == 'grid_stream_landscape') {
    $wrapped_entity = entity_metadata_wrapper('node', $variables['node']);
    if (isset($wrapped_entity->field_updates[0]) && isset($wrapped_entity->field_updates[1])) {
      $variables['update_1'] = $wrapped_entity->field_updates[0]->view('teaser');
      $variables['update_2'] = $wrapped_entity->field_updates[1]->view('teaser');
    }
  }

  // Conditionally remove Formal Submission fields where relevant.
  if ($variables['type'] == 'consultation' && $variables['view_mode'] == 'full') {

    // Include Consultation specific script.
    drupal_add_js(path_to_theme() . '/js/script-consultation.js', array('file'));

    _consultation_vars($variables, $variables['node']);
    $consultation = $variables['consultation'];

    // Return if formal submissions are not accepted.
    if (!empty($consultation['hide_form'])) {
      field_group_hide_field_groups($variables['elements'], array('group_formal_submission_form'));
      hide($variables['content']['formal_submission_webform']);
      // Only hide inro/outro if there is no embedded webform.
      if (empty($variables['content']['field_other_embedded_webform'])) {
        hide($variables['content']['field_formal_submission_cta_1']);
        hide($variables['content']['field_formal_submission_cta_2']);
      }
    }

    if ($consultation['in_review']) {
      show($variables['content']['field_formal_submission_cta_1']);
    }

    // Add formal submission field to JS Drupal.settings if a value is present.
    if (isset($variables['content']['field_formal_submission_notify']['#items'][0]['value'])) {
      drupal_add_js(array(
        'dcomms_theme' => array(
          'formalSubmissionNotify' => check_plain($variables['content']['field_formal_submission_notify']['#items'][0]['value']),
        ),
      ), 'setting');
    }
    hide($variables['content']['field_formal_submission_notify']);

  }

  // Conditionally remove Progress bar from all view modes where relevant.
  if ($variables['type'] == 'consultation') {
    // Create the entity metadata wrapper.
    $wrapper = entity_metadata_wrapper('node', $node);

    _consultation_vars($variables, $variables['node']);
    $consultation = $variables['consultation'];

    if ($consultation['date_status'] === 'upcoming') {
      field_group_hide_field_groups($variables['elements'], array('group_formal_submissions'));
      hide($variables['content']['hys_progress_bar']);
      hide($variables['content']['formal_submission_webform']);
      hide($variables['content']['field_formal_submission_cta_1']);
      hide($variables['content']['field_formal_submission_cta_2']);
      hide($variables['content']['field_other_embedded_webform']);
    }

    // Set default values.
    $short_comments_enabled = $file_uploads_enabled = FALSE;
    // Create the entity metadata wrapper.
    $wrapper = entity_metadata_wrapper('node', $node);

    // If the 'Short comments enabled' field exists and is TRUE.
    if (isset($node->field_short_comments_enabled) && $wrapper->field_short_comments_enabled->value()) {
      $short_comments_enabled = TRUE;
    }

    // If the 'File upload enabled' field exists and is TRUE.
    if (isset($node->field_file_uploads_enabled) && $wrapper->field_file_uploads_enabled->value()) {
      $file_uploads_enabled = TRUE;
    }

    // Add the above results to javascript.
    drupal_add_js(array(
      'dcomms_theme' => array(
        'shortCommentsEnabled' => $short_comments_enabled,
        'fileUploadsEnabled' => $file_uploads_enabled,
      ),
    ), 'setting');

    // Get the end consultation date.
    $end_consultation_date = _dcomms_admin_return_end_consultation_date($node, $wrapper);
    // Get the current timestamp.
    $time = time();

    // Check if a fso has been provided.
    if (isset($_GET['fso'])) {
      // Check if the node is able to accept late submissions.
      $accept_late_submissions = _dcomms_admin_accept_late_submission($node);
      // If the node can accept late submissions.
      if ($accept_late_submissions) {
        // Get the salted hash for this nid.
        $salted_hash = _dcomms_admin_return_salted_hash($node->nid);
        // If the salted hash and the fso are equal.
        if ($_GET['fso'] == $salted_hash) {
          // Show the relevant HYS sections.
          show($variables['content']['formal_submission_webform']);

          // Build up the message to let the user know of the special case.
          $message = t("Please note that acceptance of submissions for this round of the consultation has closed. It is at the Departments' discretion if late submissions are accepted. Thank you.");
          // Output the status message.
          $variables['status_message'] = $message;
        }
      }
      // If the 'Enable late submissions' value is not TRUE and the end consultation date is less than now.
      elseif (isset($node->field_enable_late_submissions) && $wrapper->field_enable_late_submissions->value() !== TRUE && $end_consultation_date < $time) {
        // Redirect the user to the custom 404 page.
        drupal_goto('page-404-consultations');
      }
    }
  }

  // Variables for optional display of child links grid, 'on this page', suggested content.
  if (in_array($variables['type'], array(
      'alert',
      'bcr_data',
      'blog_article',
      'consultation',
      'news_article',
      'policy',
      'page',
    ))
    && $variables['view_mode'] == 'full'
  ) {
    $wrapped_entity = entity_metadata_wrapper('node', $variables['node']);
    if ($variables['type'] == 'page') {
      $hide_child_pages = $variables['hide_child_pages'] = $wrapped_entity->field_hide_child_pages->value();
      $variables['hide_on_this_page'] = $wrapped_entity->field_hide_on_this_page->value();
    }
    $hide_related_content = $wrapped_entity->field_hide_related_content->value();

    // Child pages.
    if (isset($hide_child_pages) && !$hide_child_pages) {
      $block = module_invoke('bean', 'block_view', 'standard-page-children---coloure');
      $variables['child_pages_block'] = render($block['content']);
    }

    // Related content.
    if (isset($hide_related_content) && !$hide_related_content) {
      $variables['content']['related_content'] = _dcomms_theme_related_content($variables['node']);
    }
  }

  $variables['read_more_text'] = t('Learn more');
  if (!empty($node->field_read_more_text[LANGUAGE_NONE][0]['safe_value'])) {
    $variables['read_more_text'] = $node->field_read_more_text[LANGUAGE_NONE][0]['safe_value'];
  }

  // Find out whether the node has an 'External source' filled in.
  $external_source = _dcomms_admin_return_node_has_external_source($node);
  $variables['external_source'] = $external_source;

  // Build service links.
  $variables['service_links'] = NULL;
  // If 'Hide social links' field is not set/empty.
  if (!isset($variables['field_social_links'][LANGUAGE_NONE]) || $variables['field_social_links'][LANGUAGE_NONE][0]['value'] == 0) {
    // And it's the full view mode.
    if ($variables['view_mode'] === 'full') {
      $options = array('absolute' => TRUE);
      $variables['service_links'] = theme('share_row', array(
        'title' => $node->title,
        'url' => url('node/' . $node->nid, $options),
      ));
    }
  }

  // Check to see if $user has the administrator role then show form.
  global $user;
  $submit_formal_submission_roles = array(
    "Site builder",
    "Site editor",
    "Publisher",
    "administrator",
  );

  if (array_intersect($submit_formal_submission_roles, array_values($user->roles))) {
    $variables['formal_submission_block'] = module_invoke('webform', 'block_view', 'client-block-15');
  }

  // If this is a 'Consultation' content type.
  if ($variables['type'] == 'consultation') {
    // Hide 'Discussion Forum' related fields initially.
    hide($variables['content']['field_discussion_forum_heading']);
    hide($variables['content']['field_discussion_forum_intro']);
    // Create an entity metadata wrapper.
    $wrapper = entity_metadata_wrapper('node', $node);

    if (!$wrapper->field_short_comments_enabled->value()) {
      $variables['classes_array'][] = 'hide_short_comments';
    }
    if (!$wrapper->field_file_uploads_enabled->value()) {
      $variables['classes_array'][] = 'hide_files';
    }

    // If comments are open.
    if ($variables['comment'] == COMMENT_NODE_OPEN) {
      // If the heading 'Discussion Forum' heading field exists and is not blank.
      if (isset($node->field_discussion_forum_heading) && $wrapper->field_discussion_forum_heading->value() != '') {
        // Show the 'Discussion Forum' heading field.
        show($variables['content']['field_discussion_forum_heading']);
      }
      // If the 'Discussion Forum' introduction field eixsts and is not blank.
      if (isset($node->field_discussion_forum_intro) && $wrapper->field_discussion_forum_intro->value() != '') {
        // Show the 'Discussion Forum' introduction field.
        show($variables['content']['field_discussion_forum_intro']);
      }
    }
  }

  if ($variables['type'] == 'alert') {
    if (isset($variables['field_priority_level']) && count($variables['field_priority_level'])) {
      $priority_level = $variables['field_priority_level'][LANGUAGE_NONE][0]['tid'];
      if ($priority_level = taxonomy_term_load($priority_level)) {
        $variables['classes_array'][] = 'alert-priority-' . strtolower(trim($priority_level->name));
        $variables['alert_priority'] = $priority_level->name;
      }
    }
  }

}

/**
 * Implements template_preprocess_views_view_fields().
 */
function dcomms_theme_preprocess_views_view_field(&$variables) {
  if ($variables["field"]->options["id"] == "value_2") {
    $nid = $variables['field']->options['webform_nid'];
    $sid = $variables['row']->sid;
    $full_submission = webform_get_submission($nid, $sid);
    if (isset($full_submission->data[24]) && ($full_submission->data[24][0] === 'anonymous')) {
      // If anonymous (component 24) checked title should be "Anonymous".
      $variables["output"] = "Anonymous";
    }
    elseif (isset($full_submission->data[2]) && !empty($full_submission->data[2][0])) {
      // If anonymous not checked but organisation is set, it displays as title.
      $variables["output"] = $full_submission->data[2][0];
    }
  }
}

/**
 * Implements hook_form_alter().
 */
function dcomms_theme_form_alter(&$form, &$form_state, $form_id) {
  if ($form_id == 'webform_client_form_15') {
    $component_key = "privacy";
    $form['actions'][$component_key] = $form['submitted'][$component_key];
    unset($form['submitted'][$component_key]);

    // Check if the 'Short comments' field is available.
    if (isset($form['submitted']['short_comments'])) {
      // Update the attributes and set the maxlength.
      $form['submitted']['short_comments']['#attributes']['maxlength'] = 500;
    }
  }

  if ($form_id == 'workbench_moderation_moderate_form' && !empty($form['node']['#value'])) {
    $node = $form['node']['#value'];
    if (!empty($node->nid) && isset($node->workbench_moderation['published']->vid)) {
      unset($form['state']['#options']['archive']);
    }
  }
}

/**
 * Render a read more link.
 *
 * @param string $href
 *   URL of the read more link.
 * @param string $text
 *   Text of the read more link.
 * @param boolean $external
 *   Whether the link is external or not. Defaults to FALSE.
 *
 * @return string
 *   HTML markup for read more link.
 */
function dcomms_theme_read_more_link($href, $text, $external = FALSE) {
  $template_file = drupal_get_path('theme', 'dcomms_theme') . '/templates/read-more-link.tpl.php';

  // Make sure relative links start with /.
  if (substr($href, 0, 4) != 'http' && substr($href, 0, 1) != '/') {
    $href = base_path() . $href;
  }

  return theme_render_template($template_file, array(
    'href' => $href,
    'text' => $text,
    'external' => $external,
  ));
}

/**
 * Implements hook_preprocess_block().
 */
function dcomms_theme_preprocess_block(&$variables) {
  // Theming various blocks.
  switch ($variables['block_html_id']) {
    case 'block-system-main-menu':
      $variables['classes_array'][] = 'header-menu';
      $variables['title_attributes_array']['class'] = array('element-invisible');
      break;

    case 'block-menu-menu-footer-menu':
      $variables['classes_array'][] = 'layout-centered';
      $variables['classes_array'][] = 'clearfix';
      $variables['title_attributes_array']['class'] = array('element-invisible');
      break;

    case 'block-menu-menu-footer-sub-menu':
      $variables['classes_array'][] = 'layout-centered';
      $variables['classes_array'][] = 'clearfix';
      $variables['title_attributes_array']['class'] = array('element-invisible');
      break;
  }

  // Block template per bean type.
  if ($variables['block']->module === 'bean') {
    $beans = $variables['elements']['bean'];
    $bean_keys = element_children($beans);
    $bean = $beans[reset($bean_keys)];
    // Add template suggestions for bean types.
    $variables['theme_hook_suggestions'][] = 'block__bean__' . $bean['#bundle'];
  }
}

/**
 * Returns HTML for a menu with a heading and wrapper.
 */
function _dcomms_theme_block_render($module, $delta) {
  $output = '';
  $block = block_load($module, $delta);
  if (isset($block->bid)) {
    $block_content = _block_render_blocks(array($block));
    $block_array = _block_get_renderable_array($block_content);
    $output = drupal_render($block_array);
  }

  return $output;
}

/**
 * Implements theme_menu_tree__MENU_NAME().
 */
function dcomms_theme_menu_tree__main_menu($variables) {
  if (strpos($variables['tree'], 'subsite-header__item') !== FALSE) {
    // If it's a menu block menu.
    $output = '<ul class="subsite-header__list">' . $variables['tree'] . '</ul>';
  }
  else {
    // Otherwise it's the system menu.
    $output = '<ul class="header-menu__menu">';
    $output .= $variables['tree'];

    // Include the search link.
    $output .= '<li class="header-search__icon-wrapper">';
    $output .= l(t('Search'), 'search', array('attributes' => array('class' => array('header-search__icon--link'))));
    $output .= '</li>';

    $output .= '</ul>';
  }

  return $output;
}

/**
 * Implements theme_menu_link__MENU_NAME().
 */
function dcomms_theme_menu_link__main_menu(array $variables) {
  $element = $variables['element'];

  if (isset($element['#bid'])) {
    // If it's a menu block menu.
    $item_class = 'subsite-header__item';
    if (in_array('is-active-trail', $element['#attributes']['class'])) {
      $item_class = 'subsite-header__item is-active';
    }
    $link_class = 'subsite-header__link';
  }
  else {
    // Otherwise it's the system menu.
    $item_class = 'header-menu__item';
    if (in_array('is-active-trail', $element['#attributes']['class'])) {
      $item_class = 'header-menu__item is-active';
    }
    $link_class = 'header-menu__link';
  }

  $element['#localized_options']['attributes']['class'][] = $link_class;
  $element['#localized_options']['html'] = TRUE;

  $output = l(check_plain($element['#title']), $element['#href'], $element['#localized_options']);

  return '<li class="' . $item_class . '">' . $output . "</li>\n";
}

/**
 * Implements theme_menu_tree__MENU_NAME().
 */
function dcomms_theme_menu_tree__menu_footer_menu($variables) {
  return '<ul class="footer-menu">' . $variables['tree'] . '</ul>';
}

/**
 * Implements theme_menu_link__MENU_NAME().
 */
function dcomms_theme_menu_link__menu_footer_menu(array $variables) {
  $element = $variables['element'];
  $sub_menu = '';
  if ($element['#original_link']['depth'] === '1') {
    $item_class = 'footer-menu__column';
    $link_class = 'footer-menu__title';
  }
  else {
    $item_class = 'footer-menu__item';
    $link_class = '';
  }
  if (isset($element['#below'])) {
    $sub_menu = drupal_render($element['#below']);
  }
  $element['#localized_options']['attributes']['class'][] = $link_class;
  $element['#localized_options']['html'] = TRUE;

  $output = l(check_plain($element['#title']), $element['#href'], $element['#localized_options']);

  return '<li class="' . $item_class . '">' . $output . $sub_menu . "</li>\n";
}

/**
 * Implements theme_menu_tree__MENU_NAME().
 */
function dcomms_theme_menu_tree__menu_footer_sub_menu($variables) {
  return '<ul class="list-unstyled list-inline">' . $variables['tree'] . '</ul>';
}

/**
 * Implements theme_menu_link__MENU_NAME().
 */
function dcomms_theme_menu_link__menu_footer_sub_menu(array $variables) {
  $element = $variables['element'];
  $sub_menu = '';

  if (isset($element['#below'])) {
    $sub_menu = drupal_render($element['#below']);
  }
  $element['#localized_options']['attributes']['class'][] = 'footer_menu__link';
  $element['#localized_options']['html'] = TRUE;
  $output = l(check_plain($element['#title']), $element['#href'], $element['#localized_options']);

  return '<li class="footer-menu__item">' . $output . $sub_menu . "</li>\n";
}

/**
 * Implements theme_file_icon().
 */
function dcomms_theme_file_icon($variables) {
  $file = $variables['file'];
  $icon_directory = drupal_get_path('theme', 'dcomms_theme') . '/images/document';

  $mime = check_plain($file->filemime);
  $icon_url = file_icon_path($file, $icon_directory);

  return '<img alt="" class="file__icon" src="' . base_path() . $icon_url . '" title="' . $mime . '" />';
}


/**
 * Returns the poll type based on number of choices.
 */
function _dcomms_poll_type($nid) {
  $node = node_load($nid);
  $choices = count($node->choice);
  $poll_type = 'binary';
  if ($choices > '2'):
    $poll_type = 'multiple';
  endif;

  return $poll_type;
}

/**
 * Implements theme_breadcrumb().
 */
function dcomms_theme_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];
  $output = '';

  // Determine if we are to display the breadcrumb.
  $show_breadcrumb = theme_get_setting('zen_breadcrumb');
  if ($show_breadcrumb == 'yes' || $show_breadcrumb == 'admin' && arg(0) == 'admin') {

    // Optionally get rid of the homepage link.
    $show_breadcrumb_home = theme_get_setting('zen_breadcrumb_home');
    if (!$show_breadcrumb_home) {
      array_shift($breadcrumb);
    }

    // Return the breadcrumb with separators.
    if (!empty($breadcrumb)) {
      $breadcrumb_separator = "<svg class='breadcrumb__separator' xmlns='http://www.w3.org/2000/svg' height='15' version='1.1' viewBox='0 0 416 416' width='10' xml:space='preserve'><polygon points='160,115.4 180.7,96 352,256 180.7,416 160,396.7 310.5,256 '></polygon></svg>";
      $trailing_separator = $title = '';
      if (theme_get_setting('zen_breadcrumb_title')) {
        $item = menu_get_item();
        if (!empty($item['tab_parent'])) {
          // If we are on a non-default tab, use the tab's title.
          $breadcrumb[] = check_plain($item['title']);
        }
        else {
          $breadcrumb[] = drupal_get_title();
        }
      }
      elseif (theme_get_setting('zen_breadcrumb_trailing')) {
        $trailing_separator = $breadcrumb_separator;
      }

      // Provide a navigational heading to give context for breadcrumb links to
      // screen-reader users.
      if (empty($variables['title'])) {
        $variables['title'] = t('You are here');
      }
      // Unless overridden by a preprocess function, make the heading invisible.
      if (!isset($variables['title_attributes_array']['class'])) {
        $variables['title_attributes_array']['class'][] = 'element-invisible';
      }

      // Build the breadcrumb trail.
      $output = '<nav class="breadcrumb" role="navigation">';
      $output .= '<h2' . drupal_attributes($variables['title_attributes_array']) . '>' . $variables['title'] . '</h2>';
      $output .= '<ol class="breadcrumb__list"><li class="breadcrumb__item">' . implode($breadcrumb_separator . '</li><li class="breadcrumb__item">', $breadcrumb) . $trailing_separator . '</li></ol>';
      $output .= '</nav>';
    }
  }

  return $output;
}

/**
 * Trim HTML into plain text of the given length.
 *
 * @param string $markup
 *   HTML to trim.
 * @param int $trim_length
 *   The trim length.
 *
 * @return string
 *   Plain text trimmed version of the HTML.
 */
function dcomms_theme_trim($markup, $trim_length) {
  return truncate_utf8(strip_tags($markup), $trim_length, TRUE, TRUE);
}

/**
 * Implements template_preprocess_field().
 */
function dcomms_theme_preprocess_field(&$variables, $hook) {
  $element =& $variables['element'];
  $variables['theme_hook_suggestions'][] = 'field__' . $element['#field_name'] . '__' . $element['#view_mode'];
  $variables['theme_hook_suggestions'][] = 'field__' . $element['#bundle'] . '__' . $element['#view_mode'];
  $variables['theme_hook_suggestions'][] = 'field__' . $element['#bundle'] . '__' . $element['#view_mode'] . '__' . $element['#field_name'];

  if (($element['#field_type'] === 'text_with_summary' || $element['#field_type'] === 'text_long') && ($element['#formatter'] === 'text_summary_or_trimmed' || $element['#formatter'] === 'text_trimmed')) {
    $instance = field_info_instance($element['#entity_type'], $element['#field_name'], $element['#bundle']);
    $display = $instance['display'][$element['#view_mode']];
    $trim_length = $display['settings']['trim_length'];
    $use_summary = $element['#formatter'] === 'text_summary_or_trimmed';
    foreach ($element['#items'] as $delta => $item) {
      $markup = ($use_summary && !empty($item['safe_summary'])) ? $item['safe_summary'] : $item['safe_value'];
      $variables['items'][$delta]['#markup'] = dcomms_theme_trim($markup, $trim_length);
    }
  }

  if ($element['#field_name'] === 'node_link') {
    $variables['read_more_text'] = t('Learn more');
    $node = $element['#object'];
    if (!empty($node->field_read_more_text[LANGUAGE_NONE][0]['safe_value'])) {
      $variables['read_more_text'] = $node->field_read_more_text[LANGUAGE_NONE][0]['safe_value'];
    }
  }

  if ($element['#field_type'] === 'image') {
    foreach ($variables['items'] as $delta => $item) {
      if (isset($item['#item'])) {
        if ($item['#item']['filemime'] === 'image/svg+xml') {
          unset($variables['items'][$delta]['#image_style']);
        }
      }

      if (isset($item['#file'])) {
        if ($item['#file']->filemime) {
          if ($item['#file']->filemime === 'image/svg+xml') {
            $variables['items'][$delta]['file']['#theme'] = 'image';
          }
        }
      }

    }
  }

  // Add consultation vars to relevant fields.
  $consultation_fields = array(
    'hys_progress_bar',
    'field_formal_submission_cta_1',
    'field_consultation_date',
  );
  $is_consultation_field = in_array($variables['element']['#field_name'], $consultation_fields);
  if ($is_consultation_field) {
    _consultation_vars($variables, $element['#object']);
  }

  // Replace title with promotional one-liner in non-full view modes.
  if ($element['#field_name'] == 'title' && $element['#view_mode'] != 'full') {
    if (isset($element['#object']->field_promotional_one_liner) && !empty($element['#object']->field_promotional_one_liner)) {
      $variables['one_liner'] = truncate_utf8($element['#object']->field_promotional_one_liner[LANGUAGE_NONE][0]['value'], 35, TRUE, TRUE);
    }
  }

  // Strip certain characters for Swift RSS integration.
  if ($element['#view_mode'] == 'rss_feed') {
    if ($element['#formatter'] == 'text_plain' && $element['#bundle'] == 'alert') {
      // Manually control markup for Alert content.
      $allowed_tags = '<p><br><h1><h2><h3><h4><h5><h6><a><b><strong><i><em><img>';
      $clean = strip_tags($element['#items'][0]['value'], $allowed_tags);
      $variables['items'][0]['#markup'] = check_markup($clean, 'rich_text');
    }

    // Replace incompatible characters.
    $variables['items'][0]['#markup'] = str_replace(
      array(
        '—',
        '–',
        '“',
        '”',
        '’',
        '&nbsp;',
      ),
      array(
        '-',
        '-',
        '"',
        '"',
        '\'',
        ' ',
      ),
      $variables['items'][0]['#markup']
    );

  }

  // Get the node.
  $node = $element['#object'];
  // Return whether a node has the 'External source' field filled in.
  $external_source = _dcomms_admin_return_node_has_external_source($node);
  $variables['external_source'] = $external_source;

  if ($variables['element']['#field_name'] == 'field_stackla_embed_para') {
    drupal_add_js(path_to_theme() . '/js/stackla.js', array('file'));
  }
}

/**
 * Implements hook_ds_pre_render_alter().
 */
function dcomms_theme_ds_pre_render_alter(&$layout_render_array, $context, &$variables) {
  if (isset($variables['type'])) {
    $feature_types = array('page', 'blog_article', 'alert', 'news_article');
    if ($variables['type'] === 'consultation' || $variables['type'] === 'poll') {
      // If viewed in iframe mode - add additional class.
      if ($variables['view']->name === 'consultations_iframe') {
        $variables['classes_array'][] = 'grid-stream__item--iframe';
      }
      // Modify the class if the node has a Featured Image.
      $modifier_class = '';
      if (!empty($variables['field_feature_image'])) {
        $modifier_class = '--has-image';
      }
      // Add the relevant class to the template.
      if ($variables['view_mode'] === 'grid_stream_portrait') {
        $variables['classes_array'][] = 'grid-stream__item--vertical' . $modifier_class;
      }
      elseif ($variables['view_mode'] === 'grid_stream_landscape') {
        $variables['classes_array'][] = 'clearfix__overflow grid-stream__item--landscape-small' . $modifier_class;
      }
      elseif ($variables['view_mode'] === 'grid_stream_upcoming') {
        if (!empty($variables['field_feature_image'])) {
          $modifier_class = '--has-image-description';
        }
        $variables['classes_array'][] = 'clearfix__overflow grid-stream__item--landscape-small' . $modifier_class;
      }
    }
    elseif (in_array($variables['type'], $feature_types)) {
      if ($variables['view_mode'] === 'grid_stream_portrait') {
        $variables['classes_array'][] = 'grid-stream__item--portrait';
      }
      elseif ($variables['view_mode'] === 'grid_stream_landscape') {
        $variables['classes_array'][] = 'clearfix__overflow grid-stream__item--landscape';
      }
      elseif ($variables['view_mode'] === 'grid_stream_portrait_small') {
        $variables['classes_array'][] = 'grid-stream__item--portrait-small';
      }
    }
    if ($variables['type'] === 'news_article' && $variables['view_mode'] === 'teaser') {
      $variables['classes_array'][] = 'news-list__item';
    }
    // Add business area class to relevant items where relevant.
    if (isset($variables['field_business_area']) && !empty($variables['field_business_area']) && $variables['view_mode'] != 'full') {
      $hide_stream = FALSE;
      if (isset($variables['field_business_area'][LANGUAGE_NONE])) {
        $business_area_tid = $variables['field_business_area'][LANGUAGE_NONE][0]['tid'];
      }
      else {
        $business_area_tid = $variables['field_business_area'][0]['tid'];
      }

      switch ($business_area_tid) {
        case 20:
          $business_area_name = 'digital-business';
          $hide_stream = TRUE;
          break;

        case 40:
          $business_area_name = 'bureau-communications-research';
          $hide_stream = TRUE;
          break;

        case 15:
          $business_area_name = 'stay-smart-online';
          $hide_stream = TRUE;
          break;

        default:
          $business_area_name = $business_area_tid;
          break;

      }
      $variables['classes_array'][] = 'grid-stream__item--business-area';
      $variables['classes_array'][] = 'subsite__' . $business_area_name;

      if ($hide_stream === TRUE) {
        $variables['classes_array'][] = 'grid-stream__item--business-area--hide-stream';
      }
    }

    // add different classes to relevant priority levels of SSO Alerts
    if ($variables['type'] == 'alert') {
      if (isset($variables['field_priority_level']) && count($variables['field_priority_level'])) {
        $priority_level = $variables['field_priority_level'][LANGUAGE_NONE][0]['tid'];
        if ($priority_level = taxonomy_term_load($priority_level)) {
          $variables['classes_array'][] = 'alert-priority-' . strtolower(trim($priority_level->name));
          $variables['alert_priority'] = $priority_level->name;
        }
      }
    }
  }
}

/**
 * Implements template_preprocess_poll_results().
 */
function dcomms_theme_preprocess_poll_results(&$variables) {
  $node = node_load($variables['nid']);
  $keys = array_keys($node->choice);
  $variables['votes_1'] = $node->choice[$keys[0]]['chvotes'];
  $variables['votes_2'] = $node->choice[$keys[1]]['chvotes'];
}

/**
 * Implements hook_block_view_alter().
 */
function dcomms_theme_block_view_alter(&$data, $block) {
  if ($block->module === 'search' && $block->delta === 'form') {
    $contexts = context_active_contexts();
    if (array_key_exists('display_sso_nav', $contexts) || array_key_exists('clone_of_display_sso_nav', $contexts)) {
      $data['subsite'] = '15';
      $data['subsite_name'] = 'Stay Smart Online';
    }
    if (array_key_exists('display_digitalbusiness_nav', $contexts) || array_key_exists('display_digitalbusiness_nav', $contexts)) {
      $data['subsite'] = '20';
      $data['subsite_name'] = 'Digital Business';
    }
    if (array_key_exists('display_bcr_nav', $contexts) || array_key_exists('clone_of_display_bcr_nav', $contexts)) {
      $data['subsite'] = '40';
      $data['subsite_name'] = 'Bureau of Communications Research';
    }
  }
}

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
  $consultation['percentage'] = _consultation_percentage($consultation);
  $consultation['days_total'] = round($consultation['duration'] / strtotime('1 day', 0));
  $consultation['days_remain'] = _consultation_days_remain($consultation);
  $consultation['submission_enabled'] = $consultation['wrapped_entity']->field_formal_submission_enabled->value();
  $consultation['status_class'] = ($consultation['percentage'] === 100 ? 'progress-bar--complete' : '');
  $consultation['status_message'] = _consultation_status_message($consultation);
  $consultation['submissions_closed_message'] = _consultation_submissions_closed_message($consultation);
  $consultation['hide_form'] = !$consultation['submission_enabled'] || ($consultation['start'] > $consultation['now']) || ($consultation['end'] < $consultation['now']);
  $variables['consultation'] = $consultation;

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
 * Helper function for status message.
 */
function _consultation_status_message($consultation) {

  $status_message = t('Open');

  if ($consultation['in_review']) {
    $status_message = t('Now under review');
  }

  $formal_submission_public = $consultation['wrapped_entity']->field_formal_submission_public->value();
  if ($formal_submission_public) {
    $status_message = t('Submissions now public');
  }

  if ($consultation['archived']) {
    $status_message = t('Archived');
  }

  return $status_message;

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

/**
 * Implements template_preprocess_views_view().
 */
function dcomms_theme_preprocess_views_view(&$variables) {
  if ($variables['name'] === 'formal_submissions') {
    $node = menu_get_object();
    if (isset($node->field_hide_submission_filters[LANGUAGE_NONE][0]['value']) && $node->field_hide_submission_filters[LANGUAGE_NONE][0]['value'] === '1') {
      $variables['exposed'] = FALSE;
    }
  }

  if ($variables['name'] === 'consultations_other') {
    if ($variables['view']->total_rows >= '3' && $variables['display_id'] == 'block') {
      $variables['classes_array'][] = 'grid-stream--grid-at-three';
    }
  }
}


/**
 * Implements hook_theme().
 */
function dcomms_theme_theme($existing, $type, $theme, $path) {
  return array(
    'share_row' => array(
      'template' => 'templates/share-row',
      'variables' => array(
        'title' => NULL,
        'url' => NULL,
      ),
    ),
    'list_arrow' => array(
      'template' => 'templates/list-arrow',
      'variables' => array(
        'items' => NULL,
      ),
    ),
  );
}

/**
 * Implements hook_theme().
 */
function dcomms_theme_item_list($variables) {
  $items = $variables['items'];
  $title = $variables['title'];
  $type = $variables['type'];
  $attributes = $variables['attributes'];

  // Only output the list container and title, if there are any list items.
  // Check to see whether the block title exists before adding a header.
  // Empty headers are not semantic and present accessibility challenges.
  $output = '';
  if (isset($title) && $title !== '') {
    $output .= '<h3>' . $title . '</h3>';
  }

  if (!empty($items)) {
    $output .= "<$type" . drupal_attributes($attributes) . '>';
    $num_items = count($items);
    $i = 0;
    foreach ($items as $item) {
      $attributes = array();
      $children = array();
      $data = '';
      $i++;
      if (is_array($item)) {
        foreach ($item as $key => $value) {
          if ($key == 'data') {
            $data = $value;
          }
          elseif ($key == 'children') {
            $children = $value;
          }
          else {
            $attributes[$key] = $value;
          }
        }
      }
      else {
        $data = $item;
      }
      if (count($children) > 0) {
        // Render nested list.
        $data .= theme_item_list(array(
          'items' => $children,
          'title' => NULL,
          'type' => $type,
          'attributes' => $attributes,
        ));
      }
      if ($i == 1) {
        $attributes['class'][] = 'first';
      }
      if ($i == $num_items) {
        $attributes['class'][] = 'last';
      }
      $output .= '<li' . drupal_attributes($attributes) . '>' . $data . "</li>\n";
    }
    $output .= "</$type>";
  }

  return $output;
}

/**
 * Implements theme_pager().
 */
function dcomms_theme_pager($variables) {
  $tags = $variables['tags'];
  $element = $variables['element'];
  $parameters = $variables['parameters'];
  $quantity = $variables['quantity'];
  global $pager_page_array, $pager_total;

  // Calculate various markers within this pager piece:
  // Middle is used to "center" pages around the current page.
  $pager_middle = ceil($quantity / 2);
  // Current is the page we are currently paged to.
  $pager_current = $pager_page_array[$element] + 1;
  // First is the first page listed by this pager piece (re quantity).
  $pager_first = $pager_current - $pager_middle + 1;
  // Last is the last page listed by this pager piece (re quantity).
  $pager_last = $pager_current + $quantity - $pager_middle;
  // Max is the maximum page number.
  $pager_max = $pager_total[$element];
  // End of marker calculations.

  // Prepare for generation loop.
  $i = $pager_first;
  if ($pager_last > $pager_max) {
    // Adjust "center" if at end of query.
    $i = $i + ($pager_max - $pager_last);
    $pager_last = $pager_max;
  }
  if ($i <= 0) {
    // Adjust "center" if at start of query.
    $pager_last = $pager_last + (1 - $i);
    $i = 1;
  }
  // End of generation loop preparation.

  $li_first = theme('pager_first', array(
    'text' => (isset($tags[0]) ? $tags[0] : t('« first')),
    'element' => $element,
    'parameters' => $parameters,
  ));
  $li_previous = theme('pager_previous', array(
    'text' => (isset($tags[1]) ? $tags[1] : t('‹ previous')),
    'element' => $element,
    'interval' => 1,
    'parameters' => $parameters,
  ));
  $li_next = theme('pager_next', array(
    'text' => (isset($tags[3]) ? $tags[3] : t('next ›')),
    'element' => $element,
    'interval' => 1,
    'parameters' => $parameters,
  ));
  $li_last = theme('pager_last', array(
    'text' => (isset($tags[4]) ? $tags[4] : t('last »')),
    'element' => $element,
    'parameters' => $parameters,
  ));

  if ($pager_total[$element] > 1) {
    if ($li_first) {
      $items[] = array(
        'class' => array('pager-first'),
        'data' => $li_first,
      );
    }
    if ($li_previous) {
      $items[] = array(
        'class' => array('pager-previous'),
        'data' => $li_previous,
      );
    }

    // When there is more than one page, create the pager list.
    if ($i != $pager_max) {
      if ($i > 1) {
        $items[] = array(
          'class' => array('pager-ellipsis'),
          'data' => '…',
        );
      }
      // Now generate the actual pager piece.
      for (; $i <= $pager_last && $i <= $pager_max; $i++) {
        if ($i < $pager_current) {
          $items[] = array(
            'class' => array('pager-item'),
            'data' => theme('pager_previous', array(
              'text' => $i,
              'element' => $element,
              'interval' => ($pager_current - $i),
              'parameters' => $parameters,
            )),
          );
        }
        if ($i == $pager_current) {
          $items[] = array(
            'class' => array('pager-current'),
            'data' => '<span>' . $i . '</span>',
          );
        }
        if ($i > $pager_current) {
          $items[] = array(
            'class' => array('pager-item'),
            'data' => theme('pager_next', array(
              'text' => $i,
              'element' => $element,
              'interval' => ($i - $pager_current),
              'parameters' => $parameters,
            )),
          );
        }
      }
      if ($i < $pager_max) {
        $items[] = array(
          'class' => array('pager-ellipsis'),
          'data' => '…',
        );
      }
    }
    // End generation.
    if ($li_next) {
      $items[] = array(
        'class' => array('pager-next'),
        'data' => $li_next,
      );
    }
    if ($li_last) {
      $items[] = array(
        'class' => array('pager-last'),
        'data' => $li_last,
      );
    }

    $output = '<div class="pager__wrapper">';
    $output .= '<h2 class="element-invisible">' . t('Pages') . '</h2>' . theme('item_list', array(
        'items' => $items,
        'attributes' => array('class' => array('pager')),
      ));
    $output .= "</div>";

    return $output;
  }
}

/**
 * Implements hook_node_view
 *
 * @param $node
 * @param $view_mode
 * @param $langcode
 */
function dcomms_theme_node_view_alter(&$build) {
  if ($build['#node']->type == 'alert' && $build['#view_mode'] == 'rss_feed') {
    $node = $build['#node'];
    if (!empty($node->field_priority_level[LANGUAGE_NONE][0]['tid'])) {
      $priority_level = $node->field_priority_level[LANGUAGE_NONE][0]['tid'];
      if ($priority_level = taxonomy_term_load($priority_level)) {
        $node->title = t('Alert Priority !priority: !title', array(
          '!priority' => $priority_level->name,
          '!title' => $node->title,
        ));
      }
    }
  }
}

/**
 * Clear any previously set element_info() static cache.
 *
 * If element_info() was invoked before the theme was fully initialized, this
 * can cause the theme's alter hook to not be invoked.
 *
 * @see https://www.drupal.org/node/2351731
 */
drupal_static_reset('element_info');

/**
 * Include alter functions.
 */
include_once dirname(__FILE__) . '/includes/alter.inc';





/**
 * Returns HTML for an active facet item (in search)
 *
 * @param $variables
 *   An associative array containing the keys 'text', 'path', and 'options'. See
 *   the l() function for information about these variables.
 *
 * @see l()
 *
 * @ingroup themeable
 */
function dcomms_theme_facetapi_link_active($variables) {

  // Sanitizes the link text if necessary.
  $sanitize = empty($variables['options']['html']);
  $link_text = ($sanitize) ? check_plain($variables['text']) : $variables['text'];

  // Theme function variables fro accessible markup.
  // @see http://drupal.org/node/1316580
  $accessible_vars = array(
    'text' => $variables['text'],
    'active' => TRUE,
  );

  // Builds link, passes through t() which gives us the ability to change the
  // position of the widget on a per-language basis.
  $replacements = array(
    '!facetapi_deactivate_widget' => theme('facetapi_deactivate_widget', $variables),
    '!facetapi_accessible_markup' => theme('facetapi_accessible_markup', $accessible_vars),
  );
  $variables['text'] = t('!facetapi_deactivate_widget !facetapi_accessible_markup', $replacements);
  $variables['options']['html'] = TRUE;
  // return theme_link($variables) . $link_text;
  return $link_text . '<a href="' . check_plain(url($variables['path'], $variables['options'])) . '"'
         . drupal_attributes($variables['options']['attributes']) . '>'
        //  . ($variables['options']['html'] ? $variables['text'] : check_plain($variables['text']))
         . '    <img src="' . drupal_get_path('theme', 'dcomms_theme') . '/images/close--blue.svg"'
         . '         alt="Remove ' . $link_text . ' filter">'
         . '</a>';
}