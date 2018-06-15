<?php

/**
 * @file
 * Theme alter hooks.
 */

/**
 * Implements hook_block_view_alter().
 */
function doca_common_block_view_alter(&$data, $block) {
  if ($block->module === 'search' && $block->delta === 'form') {
    $contexts = context_active_contexts();
    if (array_key_exists('display_sso_nav', $contexts) || array_key_exists('clone_of_display_sso_nav', $contexts)) {
      $data['subsite'] = theme_get_setting('sub_theme_1');
      $data['subsite_name'] = theme_get_setting('sub_theme_1_title');
    }
    if (array_key_exists('display_digitalbusiness_nav', $contexts) || array_key_exists('display_digitalbusiness_nav', $contexts)) {
      $data['subsite'] = theme_get_setting('sub_theme_3');
      $data['subsite_name'] = theme_get_setting('sub_theme_3_title');
    }
    if (array_key_exists('display_bcr_nav', $contexts) || array_key_exists('clone_of_display_bcr_nav', $contexts)) {
      $data['subsite'] = theme_get_setting('sub_theme_2');
      $data['subsite_name'] = theme_get_setting('sub_theme_2_title');
    }
  }
}

/**
 * Implements hook_ds_pre_render_alter().
 */
function doca_common_ds_pre_render_alter(&$layout_render_array, $context, &$variables) {
  if (isset($variables['type'])) {
    $feature_types = ['page', 'blog_article', 'alert', 'news_article'];
    if ($variables['type'] === 'consultation' || $variables['type'] === 'poll' || $variables['type'] === 'funding') {
      // If viewed in iframe mode - add additional class.
      if (isset($variables['view']) && $variables['view']->name === 'consultations_iframe') {
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
      if ($variables['view_mode'] === 'grid_stream_portrait_small' && $variables['type'] === 'funding') {
        $variables['classes_array'][] = 'grid-stream__item--vertical';
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
      if (isset($variables['field_business_area'][LANGUAGE_NONE]) && is_array($variables['field_business_area'][LANGUAGE_NONE][0])) {
        $business_area_tid = $variables['field_business_area'][LANGUAGE_NONE][0]['tid'];
      }
      else {
        $business_area_tid = $variables['field_business_area'][0]['tid'];
      }

      $subsites = doca_common_get_subsites();
      $business_area_name = isset($subsites[$business_area_tid]) ? $subsites[$business_area_tid] : $business_area_tid;

      $variables['classes_array'][] = 'grid-stream__item--business-area';
      $variables['classes_array'][] = 'subsite__' . $business_area_name;

      if ($hide_stream === TRUE) {
        $variables['classes_array'][] = 'grid-stream__item--business-area--hide-stream';
      }
    }

    // Add different classes to relevant priority levels of SSO Alerts.
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
 * Implements hook__field_group_build_pre_render_alter().
 */
function doca_common_field_group_build_pre_render_alter(&$element) {
  if (isset($element['#node'])) {
    $object = $element['#node'];
    if ($object->type != 'funding') {
      $object = NULL;
    }
  }
  if (!empty($object) && !empty($object->field_funding_item) && $object->field_funding_item[LANGUAGE_NONE][0]['value'] == 'support') {
    $element['group_formal_submissions']['#prefix'] = str_replace('Funding applications', 'Support applications', $element['group_formal_submissions']['#prefix']);
  }
}

/**
 * Implements hook_form_alter().
 */
function doca_common_form_alter(&$form, &$form_state, $form_id) {
  if ($form_id == 'webform_client_form_' . theme_get_setting('have_your_say_wform_nid')) {
    $component_key = "privacy";
    if (isset($form['field_short_comments_enabled'][$component_key])) {
      $form['actions'][$component_key] = $form['field_short_comments_enabled'][$component_key];
      unset($form['submitted'][$component_key]);
    }
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

  if (($form_id == 'views_exposed_form') && ($form['#id'] == 'views-exposed-form-book-search-default') || $form['#id'] == 'views-exposed-form-book-search-book-search') {
    // Change label for winners all.
    $form['field_winner_value']['#options']['All'] = 'Shortlists';
    $form['field_winner_value']['#options'][1] = 'Winners';
    unset($form['field_winner_value']['#options'][0]);
  }
}

/**
 * Implements hook_js_alter().
 */
function doca_common_js_alter(&$javascript) {
  $tabs_js_path = drupal_get_path('module', 'field_group') . '/horizontal-tabs/horizontal-tabs.js';
  unset($javascript[$tabs_js_path]);

  // jQuery update.
  $node_replace_paths = [
    'media-centre/media-gallery',
  ];
  $replace_jquery = FALSE;
  foreach ($node_replace_paths as $node_replace_path) {
    if (drupal_match_path(current_path(), $node_replace_path)) {
      $replace_jquery = TRUE;
    }
  }
  $node = menu_get_object();
  if ($node->type == 'gallery') {
    $replace_jquery = TRUE;
  }
  // Swap out jQuery to use an updated version of the library.
  if ($replace_jquery) {
    $javascript['misc/jquery.js']['data'] = path_to_theme() . '/../doca_base/doca_common/vendor/js/jquery-1.11.3.min.js';
    $javascript['misc/jquery.js']['version'] = '1.11.3';
  }
}

/**
 * Implements hook_media_wysiwyg_token_to_markup_alter().
 */
function doca_common_media_wysiwyg_token_to_markup_alter(&$element, &$tag_info, $settings) {
  // Add the relevant styles to the generated media wysiwyg dom elements. This
  // needs to be done in slightly different ways for certain view modes.
  if (isset($element['content']['file']['#attributes']['style'])) {
    $styles = $element['content']['file']['#attributes']['style'];
    $parts = explode(";", $styles);
    for ($i = 0; $i < count($parts); $i++) {
      if (substr(trim($parts[$i]), 0, 5) == 'float') {
        // Move the float to the parent element.
        $element['content']['#attributes']['class'][] = 'doca-media-' . trim(explode(':', $parts[$i])[1]);
        $element['content']['#attributes']['style'] = $parts[$i];
        unset($parts[$i]);
        $element['content']['file']['#attributes']['style'] = implode(";", $parts);
        break;
      }
    }
  }
}

/**
 * Implements hook_node_view.
 *
 * @param array &$build
 *        A renderable array representing the node content.
 */
function doca_common_node_view_alter(&$build) {
  if ($build['#node']->type == 'alert' && $build['#view_mode'] == 'rss_feed') {
    $node = $build['#node'];
    if (!empty($node->field_priority_level[LANGUAGE_NONE][0]['tid'])) {
      $priority_level = $node->field_priority_level[LANGUAGE_NONE][0]['tid'];
      if ($priority_level = taxonomy_term_load($priority_level)) {
        $node->title = t('Alert Priority !priority: !title', [
          '!priority' => $priority_level->name,
          '!title' => $node->title,
        ]);
      }
    }
  }
}

/**
 * Implements hook_form_FORM_ID_alter().
 */
function doca_common_form_webform_client_form_alter(&$form, &$form_state, $form_id) {
  $wf_nid = theme_get_setting('feedback_wform_nid');
  $wf_enabled = theme_get_setting('feedback_enabled');
  if ($wf_enabled && !empty($wf_nid) && ($form_id == 'webform_client_form_' . $wf_nid)) {
    $webform = $form['#node']->webform;

    // Reset webform action.
    $form['#action'] = url('node/' . $form['#node']->nid);

    // Add sid.
    // Add wrapper id.
    $form['site_feedback_sid'] = [
      '#type' => 'hidden',
    ];

    // Add wrapper id.
    $form['site_feedback_ajax_wrapper_id'] = [
      '#type' => 'hidden',
    ];

    // Set wrapper value.
    $form['site_feedback_ajax_wrapper_id']['#value'] = drupal_html_id('site-feedback-ajax-wrapper-' . $form['#node']->nid);

    // Wrap form into wrapper.
    $form['#prefix'] = '<div id="' . $form['site_feedback_ajax_wrapper_id']['#value'] . '">' . (isset($form['#prefix']) ? $form['#prefix'] : '');
    $form['#suffix'] = (isset($form['#suffix']) ? $form['#suffix'] : '') . '</div>';

    // Ajax button.
    foreach (['previous', 'next', 'submit', 'draft'] as $button) {
      if (isset($form['actions'][$button])) {
        $form['actions'][$button]['#ajax'] = [
          'callback' => 'site_feedback_webform_ajax_callback',
          'wrapper' => $form['site_feedback_ajax_wrapper_id']['#value'],
          'progress' => [
            'message' => '',
            'type' => 'throbber',
          ],
        ];
        if (in_array($button, ['next', 'submit'])) {
          $form['actions'][$button]['#ajax']['event'] = 'click';
        }
        // Workaround for Drupal core bug http://drupal.org/node/1548976.
        // As long as buttons HTML id are causing problems, and it has bad
        // consequences on pages where Webform AJAX is active, we'll force
        // custom ids on AJAXed Webform's buttons.
        $submit_id = drupal_html_id('edit-site-feedback-ajax-' . $button . '-' . $form['#node']->nid);
        $form['actions'][$button]['#attributes']['id'] = $submit_id;
        $form['actions'][$button]['#id'] = $submit_id;
      }
    }

    // Add submit handler.
    array_unshift($form['#submit'], 'site_feedback_webform_submit');
  }
}

/**
 * AJAX callback for Webform.
 */
function site_feedback_webform_ajax_callback($form, &$form_state) {
  $output = [];
  // If user completed his submission, determine what to do.
  if (!empty($form_state['webform_completed']) && empty($form_state['save_draft'])) {
    $text = '<h2 class="site-feedback-thanks">Thanks for your feedback</h2>
             <p>This window will be automatically closed in <span class="site-feedback-thanks-countdown">5</span> seconds</p>';
    $status_messages = drupal_get_messages('status', FALSE);
    if (isset($status_messages['status'])) {
      // This is the message we want to erase.
      $confirmation = check_markup($form['#node']->webform['confirmation'], $form['#node']->webform['confirmation_format'], '', TRUE);
      $index = array_search($confirmation, $status_messages['status']);
      if ($index !== FALSE) {
        unset($status_messages['status'][$index]);
        drupal_get_messages('status');
        foreach ($status_messages['status'] as $message) {
          drupal_set_message($message);
        }
      }
    }
    $output = [
      '#type' => 'ajax',
      '#commands' => [
        ajax_command_replace('.site-feedback-form__content', $text),
        ajax_command_invoke('.site-feedback-thanks', 'trigger', ['click']),
      ],
    ];
  }
  // Else, we're just switching page, or saving draft.
  else {
    $output = $form;
  }

  return $output;
}

/**
 * Add site feedback webform submit handler.
 */
function site_feedback_webform_submit($form, &$form_state) {
  if (!empty($form_state['values']['site_feedback_sid'])) {
    $sid = $form_state['values']['site_feedback_sid'];
    $form_state['values']['details']['sid'] = $sid;
  }
}
