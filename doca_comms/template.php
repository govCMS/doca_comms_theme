<?php

/**
 * @file
 * Doca communication site custom theme.
 */

/**
 * Returns HTML for an active facet item (in search).
 *
 * @param $variables
 *   An associative array containing the keys 'text', 'path', and 'options'.
 *
 * @return string
 *   A HTML string.
 */
function dcomms_theme_facetapi_link_active($variables) {

  // Sanitizes the link text if necessary.
  $sanitize = empty($variables['options']['html']);
  $link_text = ($sanitize) ? check_plain($variables['text']) : $variables['text'];

  // Theme function variables fro accessible markup.
  // @see http://drupal.org/node/1316580
  $accessible_vars = [
    'text' => $variables['text'],
    'active' => TRUE,
  ];

  // Builds link, passes through t() which gives us the ability to change the
  // position of the widget on a per-language basis.
  $replacements = [
    '!facetapi_deactivate_widget' => theme('facetapi_deactivate_widget', $variables),
    '!facetapi_accessible_markup' => theme('facetapi_accessible_markup', $accessible_vars),
  ];
  $variables['text'] = t('!facetapi_deactivate_widget !facetapi_accessible_markup', $replacements);
  $variables['options']['html'] = TRUE;

  // return theme_link($variables) . $link_text;
  return $link_text . '<a href="' . check_plain(url($variables['path'], $variables['options'])) . '"'
    . drupal_attributes($variables['options']['attributes']) . '>'
    //  . ($variables['options']['html'] ? $variables['text'] : check_plain($variables['text']))
    . '    <img src="' . drupal_get_path('theme', 'dcomms_theme') . '/dist/images/close--blue.svg"'
    . '         alt="Remove ' . $link_text . ' filter">'
    . '</a>';
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
 * Implements hook_ds_pre_render_alter().
 */
function dcomms_theme_ds_pre_render_alter(&$layout_render_array, $context, &$variables) {
  if (isset($variables['type'])) {
    $feature_types = ['page', 'blog_article', 'alert', 'news_article'];
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
