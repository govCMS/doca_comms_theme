<?php

/**
 * @file
 * Theme preprocess functions.
 */

/**
 * Implements hook_preprocess_page().
 */
function doca_common_preprocess_html(&$variables, $hook) {
  // Add offscreen class to body for mobile navigation.
  $variables['classes_array'][] = 'offscreen';
}

/**
 * Implements hook_preprocess_page().
 */
function doca_common_preprocess_page(&$variables, $hook) {
  // Add pathToTheme to Drupal.settings in JS.
  drupal_add_js('jQuery.extend(Drupal.settings, { "pathToTheme": "' . path_to_theme() . '" });', 'inline');

  // Site pages feedback.
  if (theme_get_setting('feedback_enabled')) {
    $wf_nid = theme_get_setting('feedback_wform_nid');
    drupal_add_js(['sitePagesFeedback' => ['nid' => $wf_nid]], 'setting');
    $variables['site_pages_feedback_form'] = _doca_common_webform_render($wf_nid);
  }

  // Add the correct google analytics code for the active environment.
  $ga_code = variable_get('googleanalytics_account');
  drupal_add_js(['gaSettings' => ['gaCode' => $ga_code]], 'setting');

  // Create template variables for the header menu block.
  $variables['header_search'] = doca_common_block_render('search', 'form');
  $variables['header_menu'] = doca_common_block_render('system', 'main-menu');
  // Create template variables for the footer menu blocks.
  $variables['footer_menu'] = doca_common_block_render('menu', 'menu-footer-menu');
  $variables['footer_auxilary_menu'] = doca_common_block_render('menu', 'menu-footer-sub-menu');

  $header = drupal_get_http_header("status");
  if ($header === "404 Not Found") {
    $variables['theme_hook_suggestions'][] = 'page__404';
    $element = [
      '#tag' => 'meta',
      '#attributes' => [
        'http-equiv' => 'refresh',
        'content' => '10;url=/',
      ],
    ];
    drupal_add_html_head($element, 'page_404_redirect');
  }

  if ($header === "403 Forbidden") {
    $variables['theme_hook_suggestions'][] = 'page__403';
  }

  // If this is the 'iframe_portrait' or 'iframe_landscape' Consultation page.
  if (array_search('page__consultations__iframe_portrait', $variables['theme_hook_suggestions']) || array_search('page__consultations__iframe_landscape', $variables['theme_hook_suggestions'])) {
    // Extend the theme hook suggestions to include a stripped page.
    $variables['theme_hook_suggestions'][] = 'page__stripped';
  }

  // Define page top announcement variable.
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
 * Implements hook_preprocess_panels_pane().
 */
function doca_common_preprocess_panels_pane(&$variables) {
  if (isset($variables['content']['bean'])) {
    $bean = reset($variables['content']['bean']);
    if ($bean['#bundle'] == 'qna_pair_alt') {
      $variables['theme_hook_suggestions'][] = 'panels_pane__qna_pair_alt';
    }
    elseif ($bean['#bundle'] == 'qna_pair') {
      $variables['theme_hook_suggestions'][] = 'panels_pane__qna_pair';
    }
  }
}

/**
 * Implements hook_preprocess_node().
 */
function doca_common_preprocess_node(&$variables, $hook) {
  $node = $variables['node'];
  // Adjust the submitted date format.
  $variables['pubdate'] = '<time pubdate datetime="' . format_date($variables['node']->created, 'custom', 'c') . '">' . format_date($variables['node']->created, 'custom', 'jS M Y') . '</time>';
  if ($variables['display_submitted']) {
    $variables['submitted'] = t('Published !datetime', ['!datetime' => $variables['pubdate']]);
  }

  // Add a theme hook suggestion for type and view mode.
  $variables['theme_hook_suggestions'][] = 'node__' . $variables['type'] . '__' . $variables['view_mode'];

  // Conditionally remove Progress bar from all view modes where relevant.
  if ($variables['type'] == 'consultation') {
    // Add first/second update item to grid_stream_landscape view mode if exist.
    if ($variables['view_mode'] == 'grid_stream_landscape') {
      $wrapped_entity = entity_metadata_wrapper('node', $variables['node']);
      if (isset($wrapped_entity->field_updates[0]) && isset($wrapped_entity->field_updates[1])) {
        $variables['update_1'] = $wrapped_entity->field_updates[0]->view('teaser');
        $variables['update_2'] = $wrapped_entity->field_updates[1]->view('teaser');
      }
    }

    // Conditionally remove Formal Submission fields where relevant.
    if ($variables['view_mode'] == 'full') {

      // Include Consultation specific script.
      drupal_add_js(drupal_get_path('theme', 'doca_common') . '/dist/js/script-consultation.js', ['file']);
      drupal_add_js(['doca_common' => ['webform_nid' => theme_get_setting('have_your_say_wform_nid')]], 'setting');

      _consultation_vars($variables, $variables['node']);
      $consultation = $variables['consultation'];

      // Return if formal submissions are not accepted.
      if (!empty($consultation['hide_form'])) {
        field_group_hide_field_groups($variables['elements'], ['group_formal_submission_form']);
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
        drupal_add_js([
          'doca_common' => [
            'formalSubmissionNotify' => check_plain($variables['content']['field_formal_submission_notify']['#items'][0]['value']),
          ],
        ], 'setting');
      }
      hide($variables['content']['field_formal_submission_notify']);

    }

    // Create the entity metadata wrapper.
    $wrapper = entity_metadata_wrapper('node', $node);

    _consultation_vars($variables, $variables['node']);
    $consultation = $variables['consultation'];

    if ($consultation['date_status'] === 'upcoming') {
      field_group_hide_field_groups($variables['elements'], ['group_formal_submissions']);
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
    drupal_add_js([
      'doca_common' => [
        'shortCommentsEnabled' => $short_comments_enabled,
        'fileUploadsEnabled' => $file_uploads_enabled,
      ],
    ], 'setting');

    // Get the end consultation date.
    $end_consultation_date = _doca_admin_return_end_consultation_date($node, $wrapper);
    // Get the current timestamp.
    $time = time();

    // Check if a fso has been provided.
    if (isset($_GET['fso'])) {
      // Check if the node is able to accept late submissions.
      $accept_late_submissions = _doca_admin_accept_late_submission($node);
      // If the node can accept late submissions.
      if ($accept_late_submissions) {
        // Get the salted hash for this nid.
        $salted_hash = _doca_admin_return_salted_hash($node->nid);
        // If the salted hash and the fso are equal.
        if ($_GET['fso'] == $salted_hash) {
          // Show the relevant HYS sections.
          show($variables['content']['formal_submission_webform']);

          // Build up the message to let the user know of the special case.
          $message = t("Please note that acceptance of submissions for this round of the consultation has closed. It is at the Departments' discretion if late submissions are accepted. Thank you.");
          // Output the status message.
          $variables['status_message'] = $message;
        }
      } // If the 'Enable late submissions' value is not TRUE and the end consultation date is less than now.
      elseif (isset($node->field_enable_late_submissions) && $wrapper->field_enable_late_submissions->value() !== TRUE && $end_consultation_date < $time) {
        // Redirect the user to the custom 404 page.
        drupal_goto('page-404-consultations');
      }
    }

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

    // Check to see if $user has the administrator role then show form.
    global $user;
    $submit_formal_submission_roles = [
      "Site builder",
      "Site editor",
      "Publisher",
      "administrator",
    ];

    if (array_intersect($submit_formal_submission_roles, array_values($user->roles))) {
      $variables['formal_submission_block'] = module_invoke('webform', 'block_view', 'client-block-' . theme_get_setting('have_your_say_wform_nid'));
    }
  }

  // Conditionally remove Progress bar from all view modes where relevant.
  if ($variables['type'] == 'funding') {
    // Add first/second update item to grid_stream_landscape view mode if exist.
    $wrapper = entity_metadata_wrapper('node', $node);

    if ($variables['view_mode'] == 'grid_stream_landscape') {
      // Create an entity metadata wrapper.

      $wrapped_entity = entity_metadata_wrapper('node', $variables['node']);
      if (isset($wrapped_entity->field_updates[0]) && isset($wrapped_entity->field_updates[1])) {
        $variables['update_1'] = $wrapped_entity->field_updates[0]->view('teaser');
        $variables['update_2'] = $wrapped_entity->field_updates[1]->view('teaser');
      }
    }

    // Conditionally remove Formal Submission fields where relevant and add support class.
    if ($variables['view_mode'] == 'full') {
      if ($wrapper->field_funding_item->value() == 'support') {
        $variables['classes_array'][] = 'palette__dark-grey--group';
      }
      // Include Funding specific script.
      hide($variables['content']['field_funding_app_webform']);
      if (isset($variables['field_funding_app_webform'][0]) && isset($variables['field_funding_app_webform'][0]['target_id'])) {
        drupal_add_js(drupal_get_path('theme', 'doca_common') . '/dist/js/script-consultation.js', ['file']);
        drupal_add_js(['doca_common' => ['fund_webform_nid' => $variables['field_funding_app_webform'][0]['target_id']]], 'setting');
      }
      else {
        hide($variables['content']['formal_submission_webform']);
      }

      _consultation_vars($variables, $variables['node']);
      $funding = $variables['consultation'];

      // Return if formal submissions are not accepted.
      if (!empty($funding['hide_form'])) {
        field_group_hide_field_groups($variables['elements'], ['group_formal_submission_form']);
        hide($variables['content']['formal_submission_webform']);
        // Only hide inro/outro if there is no embedded webform.
        if (empty($variables['content']['field_other_embedded_webform'])) {
          hide($variables['content']['field_formal_submission_cta_1']);
          hide($variables['content']['field_formal_submission_cta_2']);
        }
      }

      if ($funding['in_review']) {
        show($variables['content']['field_formal_submission_cta_1']);
      }

      // Add formal submission field to JS Drupal.settings if a value is present.
      if (isset($variables['content']['field_formal_submission_notify']['#items'][0]['value'])) {
        drupal_add_js([
          'doca_common' => [
            'formalSubmissionNotify' => check_plain($variables['content']['field_formal_submission_notify']['#items'][0]['value']),
          ],
        ], 'setting');
      }
      hide($variables['content']['field_formal_submission_notify']);

    }

    // Create the entity metadata wrapper.
    $wrapper = entity_metadata_wrapper('node', $node);

    _consultation_vars($variables, $variables['node']);
    $funding = $variables['consultation'];

    $hide_progress = $wrapper->field_hide_progress_bar->value();
    $hide_cta = $wrapper->field_hide_cta->value();
    if ($funding['date_status'] === 'upcoming' || ($hide_progress && $hide_cta)) {
      field_group_hide_field_groups($variables['elements'], ['group_formal_submissions']);
      hide($variables['content']['formal_submission_webform']);
      hide($variables['content']['field_formal_submission_cta_1']);
      hide($variables['content']['field_formal_submission_cta_2']);
      hide($variables['content']['field_other_embedded_webform']);
    }
    if ($hide_progress) {
      hide($variables['content']['hys_progress_bar']);
    }
    if ($hide_cta) {
      hide($variables['content']['field_formal_submission_cta_1']);
      hide($variables['content']['field_formal_submission_cta_2']);
    }

    // Set default values.
    $short_comments_enabled = $file_uploads_enabled = FALSE;

    // Add the above results to javascript.
    drupal_add_js([
      'doca_common' => [
        'shortCommentsEnabled' => $short_comments_enabled,
        'fileUploadsEnabled' => $file_uploads_enabled,
      ],
    ], 'setting');

    // Get the end funding date.
    $end_consultation_date = _doca_admin_return_end_consultation_date($node, $wrapper);
    // Get the current timestamp.
    $time = time();

    // Hide 'Discussion Forum' related fields initially.
    hide($variables['content']['field_discussion_forum_heading']);
    hide($variables['content']['field_discussion_forum_intro']);
    // Create an entity metadata wrapper.
    $wrapper = entity_metadata_wrapper('node', $node);

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

  // Variables for optional display of child links grid, 'on this page', suggested content.
  if (in_array($variables['type'], [
      'alert',
      'bcr_data',
      'blog_article',
      'consultation',
      'funding',
      'news_article',
      'policy',
      'page',
    ])
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
      $variables['content']['related_content'] = doca_common_related_content($variables['node']);
    }
  }

  $variables['read_more_text'] = t('Learn more');
  if (!empty($node->field_read_more_text[LANGUAGE_NONE][0]['safe_value'])) {
    $variables['read_more_text'] = $node->field_read_more_text[LANGUAGE_NONE][0]['safe_value'];
  }

  // Find out whether the node has an 'External source' filled in.
  $external_source = _doca_admin_return_node_has_external_source($node);
  $variables['external_source'] = $external_source;

  // Build service links.
  $variables['service_links'] = NULL;
  // If 'Hide social links' field is not set/empty.
  if (!isset($variables['field_social_links'][LANGUAGE_NONE]) || $variables['field_social_links'][LANGUAGE_NONE][0]['value'] == 0) {
    // And it's the full view mode.
    if ($variables['view_mode'] === 'full') {
      $options = ['absolute' => TRUE];
      $variables['service_links'] = theme('share_row', [
        'title' => $node->title,
        'url' => url('node/' . $node->nid, $options),
      ]);
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
 * Implements hook_preprocess_entity().
 */
function doca_common_preprocess_entity(&$variables, $hook) {
  if ($variables['entity_type'] === 'bean' && $variables['bean']->type === 'standard_page_children' && $variables['view_mode'] === 'coloured_links_grid') {
    // Get menu link of current page.
    $item = menu_link_get_preferred();

    // Get children menu items that are standard pages.
    $nids = doca_common_get_standard_page_menu_children($item);

    // Render the nodes in coloured grid view mode.
    $node_elements = [];
    foreach ($nids as $nid) {
      $node = node_load($nid);
      $node_elements[] = [
        '#type' => 'container',
        '#attributes' => [
          'class' => ['featured__grid-item'],
        ],
        'node' => node_view($node, 'coloured_links_grid'),
      ];
    }

    // Render content.
    if (!empty($node_elements)) {
      $variables['content'] = [
        '#type' => 'container',
        '#attributes' => [
          'class' => ['featured-palette__wrapper'],
        ],
        'content' => [
          '#type' => 'container',
          '#attributes' => [
            'class' => ['featured__grid-container', 'featured-palette'],
          ],
          'nodes' => $node_elements,
        ],
      ];
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
      drupal_add_js([
        'doca_common' => [
          'alertHideName' => $variables['field_hide_name_field'][0]['value'],
          'alertFullName' => $variables['field_single_full_name'][0]['value'],
          'alertHideNumber' => $variables['field_hide_contact_number_field'][0]['value'],
          'alertMailGroup' => $variables['field_mail_groups'][0]['value'],
          'microSite' => variable_get('doca_common_micro_site', 'http://ministryofthearts.e-newsletter.com.au'),
          'apicall' => variable_get('doca_common_api_call', 'updateall'),
          'errorMessage' => variable_get('doca_common_error_message', t('Please check your email address and try again, if you are still having issues please <a href="mailto:media@communications.gov.au?Subject=Arts website newsletter subscriber">email us</a> your details.')),
          'alertSuccessMessage' => $variables['field_success_message'][0]['value'],
        ],
      ], 'setting');
    }
  }
}

/**
 * Implements hook_preprocess_block().
 */
function doca_common_preprocess_block(&$variables) {
  // Theming various blocks.
  switch ($variables['block_html_id']) {
    case 'block-system-main-menu':
      $variables['classes_array'][] = 'header-menu';
      $variables['title_attributes_array']['class'] = ['element-invisible'];
      break;

    case 'block-menu-menu-footer-menu':
      $variables['classes_array'][] = 'layout-centered';
      $variables['classes_array'][] = 'clearfix';
      $variables['title_attributes_array']['class'] = ['element-invisible'];
      break;

    case 'block-menu-menu-footer-sub-menu':
      $variables['classes_array'][] = 'layout-centered';
      $variables['classes_array'][] = 'clearfix';
      $variables['title_attributes_array']['class'] = ['element-invisible'];
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
 * Implements template_preprocess_views_view().
 */
function doca_common_preprocess_views_view(&$variables) {
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
  if ($variables['name'] == 'whats_new_grid' && $variables['display_id'] == 'block_1') {
    if (count($variables['view']->result) == 2) {
      $variables['classes_array'][] = 'grid-stream__2-col';
    }
  }
}

/**
 * Implements template_preprocess_views_view_fields().
 */
function doca_common_preprocess_views_view_field(&$variables) {
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
 * Implements template_preprocess_field().
 */
function doca_common_preprocess_field(&$variables, $hook) {
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
      $variables['items'][$delta]['#markup'] = doca_common_trim($markup, $trim_length);
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
  $consultation_fields = [
    'hys_progress_bar',
    'field_formal_submission_cta_1',
    'field_consultation_date',
  ];
  $is_consultation_field = in_array($variables['element']['#field_name'], $consultation_fields);
  if ($is_consultation_field) {
    _consultation_vars($variables, $element['#object']);
  }

  if ($element['#field_name'] == 'field_consultation_date') {
    if (isset($element['#object']->field_display_fund_period[LANGUAGE_NONE]) && $element['#object']->field_display_fund_period[LANGUAGE_NONE][0]['value']) {
      $variables['hide_date'] = TRUE;
    }
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
      [
        '—',
        '–',
        '“',
        '”',
        '’',
        '&nbsp;',
      ],
      [
        '-',
        '-',
        '"',
        '"',
        '\'',
        ' ',
      ],
      $variables['items'][0]['#markup']
    );

  }

  // Get the node.
  $node = $element['#object'];
  // Return whether a node has the 'External source' field filled in.
  $external_source = _doca_admin_return_node_has_external_source($node);
  $variables['external_source'] = $external_source;

  if ($variables['element']['#field_name'] == 'field_stackla_embed_para') {
    drupal_add_js(drupal_get_path('theme', 'doca_common') . '/vendor/js/stackla.js', ['file']);
  }
  if ($element['#field_name'] === 'formal_submission_webform') {
    if ($element['#bundle'] == 'funding') {
      if (isset($element['#object']->field_funding_app_webform[LANGUAGE_NONE])) {
        $variables['form_id'] = $element['#object']->field_funding_app_webform[LANGUAGE_NONE][0]['target_id'];
      }
    }
    else {
      $variables['form_id'] = theme_get_setting('have_your_say_wform_nid');
    }
  }

  if ($element['#field_name'] === 'field_feature_image' || $element['#field_name'] === 'field_pbundle_image' || $element['#field_name'] === 'field_image') {
    $img_class = '';
    $img_url = '';
    $has_caption = 0;
    $img_caption = '';
    $img_hover = '';
    $caption_d = '';
    $caption_mob = '';
    $variables['img_caption'] = '';
    foreach ($variables['items'] as $delta => $item) {
      if (isset($item['#item']['field_artist'][LANGUAGE_NONE][0]['safe_value'])) {
        $img_class = 'featured-with-caption';
        $has_caption = 1;
        $caption_d = '<span class="visible--md">' . $item['#item']['field_artist'][LANGUAGE_NONE][0]['safe_value'] . '<span class="feature-caption-link"> (detail) +</span></span>';
        $img_hover = '<div class="featured-overlay">' . $item['#item']['field_artist'][LANGUAGE_NONE][0]['safe_value'];
      }
      if (isset($item['#item']['field_file_image_title_text'][LANGUAGE_NONE][0]['safe_value'])) {
        $img_hover .= ' - ' . $item['#item']['field_file_image_title_text'][LANGUAGE_NONE][0]['safe_value'];
      }
      if (isset($item['#item']['field_read_more_text'][LANGUAGE_NONE][0]['safe_value'])) {
        $img_hover .= '<span>' . $item['#item']['field_read_more_text'][LANGUAGE_NONE][0]['safe_value'] . '</span>';
      }
      $img_hover .= '</div>';
      if (isset($item['#item']['field_link_to'][LANGUAGE_NONE][0]['url'])) {
        $img_url = $item['#item']['field_link_to'][LANGUAGE_NONE][0]['url'];
        $caption_mob = '<span class="visible--xs">Image credit +</span>';
      }
      if ($has_caption) :
        $img_caption .= '<div class="featured-with-caption__caption no-url">';
        if ($img_url) :
          $img_caption = '<div class="featured-with-caption__caption"><a href="' . $img_url . '"target="_blank">';
        endif;
        $img_caption .= $caption_mob;
        $img_caption .= $caption_d;
        if ($img_url) :
          $img_caption .= '</a>';
        endif;
        $img_caption .= '</div>' . $img_hover;
      endif;
      $variables['img_caption'] = $img_caption;
    }
    $variables['img_class'] = $img_class;
  }
}

/**
 * Implements template_preprocess_poll_results().
 */
function doca_common_preprocess_poll_results(&$variables) {
  $node = node_load($variables['nid']);
  $keys = array_keys($node->choice);
  $variables['votes_1'] = $node->choice[$keys[0]]['chvotes'];
  $variables['votes_2'] = $node->choice[$keys[1]]['chvotes'];
}
