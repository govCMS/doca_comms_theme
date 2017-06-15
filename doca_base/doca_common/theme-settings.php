<?php

/**
 * @file
 * Theme settings.
 */

/**
 * Include common theme functions.
 */
include_once dirname(__FILE__) . '/includes/common_theme_settings.func.inc';

/**
 * Implements hook_form_system_theme_settings_alter().
 */
function doca_common_form_system_theme_settings_alter(&$form, $form_state) {
  // Horizontal tabs container
  $form['group_tabs'] = [
    '#weight' => -99,
    '#type' => 'vertical_tabs',
    '#attached' => [
      'library' => [
        [
          'field_group',
          'horizontal-tabs',
          'vertical-tabs',
        ],
      ],
    ],
  ];

  // Default tab.
  $form['group_tab_default'] = [
    '#type' => 'fieldset',
    '#title' => t('Theme settings'),
    '#group' => 'group_tabs',
  ];
  // Page top announcements
  $form['page_top_announcement'] = [
    '#type' => 'fieldset',
    '#title' => t('Announcements to appear at the top of selected pages'),
  ];
  $form['page_top_announcement']['page_top_announcement_messages'] = [
    '#type' => 'textarea',
    '#title' => t('Message to display'),
    '#default_value' => theme_get_setting('page_top_announcement_messages'),
    '#description' => t('Message to display in the announcement area.'),
  ];
  $form['page_top_announcement']['page_top_announcement_paths'] = [
    '#type' => 'textarea',
    '#title' => t('Pages the announcements are displayed'),
    '#default_value' => theme_get_setting('page_top_announcement_paths'),
    '#description' => t('Internal paths where the announcements are displayed. Enter one path per line.'),
  ];
  // Cookie message
  $form['cookie_textarea'] = [
    '#type' => 'textarea',
    '#title' => t('Cookie Message'),
    '#default_value' => theme_get_setting('cookie_textarea'),
    '#description' => t("This is the message that will appear in the cookie notification at the top of your site."),
  ];
  // RSS author.
  $form['rss_author'] = [
    '#type' => 'textarea',
    '#title' => t('RSS Author'),
    '#default_value' => theme_get_setting('rss_author'),
    '#description' => t('Set author for each RSS feed. Enter one feed per line as <strong>path to feed,author name</strong> 
            separated by a comma. For example: <strong>news/feed,The Media Team</strong>. If no value is provided, the site 
            name will be used as the default author name.'),
  ];

  foreach ($form as $k => $v) {
    if ($k == 'group_tabs') {
      continue;
    }
    if ($k !== 'group_tab_default') {
      $form['group_tab_default'][$k] = $form[$k];
      $form['group_tab_default'][$k]['#group'] = 'group_tab_default';
      unset($form[$k]);
    }
  }

  // External link popup controls.
  $form['external_link_popup'] = [
    '#type' => 'fieldset',
    '#title' => t('External link popup'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
    '#group' => 'group_tabs',
  ];
  $form['external_link_popup']['external_link_enable_popup'] = [
    '#type' => 'checkbox',
    '#title' => t('Enable external link popup'),
    '#default_value' => theme_get_setting('external_link_enable_popup'),
    '#description' => t('Display a popup modal window when an external link is clicked.'),
  ];
  $form['external_link_popup']['external_link_popup_title'] = [
    '#type' => 'textfield',
    '#title' => t('Title text in the popup window'),
    '#default_value' => theme_get_setting('external_link_popup_title'),
    '#description' => t('Title text to be display in the external link popup.'),
  ];
  $form['external_link_popup']['external_link_popup_text'] = [
    '#type' => 'textarea',
    '#title' => t('Text in the popup window'),
    '#default_value' => theme_get_setting('external_link_popup_text'),
    '#description' => t('Text to be display in the external link popup.'),
  ];

  // Site pages feedback settings.
  $form['feedback'] = [
    '#type' => 'fieldset',
    '#title' => t('Site Pages Feedback'),
    '#description' => t("Site pages feedback settings."),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
    '#group' => 'group_tabs',
  ];
  $form['feedback']['feedback_enabled'] = [
    '#type' => 'checkbox',
    '#title' => t('Enable site pages feedback'),
    '#default_value' => theme_get_setting('feedback_enabled'),
  ];
  $form['feedback']['container'] = [
    '#type' => 'container',
    '#parents' => ['feedback'],
    '#states' => [
      'invisible' => [
        // If the checkbox is not enabled, show the container.
        'input[name="feedback_enabled"]' => ['checked' => FALSE],
      ],
    ],
  ];
  $form['feedback']['container']['feedback_wform_nid'] = [
    '#type' => 'select',
    '#title' => t('Choose site pages feedback form'),
    '#options' => doca_common_get_webform_list(),
    '#default_value' => theme_get_setting('feedback_wform_nid'),
    '#description' => t('Do not change it as this is for internal reference.'),
  ];

  // Have your Say Form settings
  $form['have_your_say'] = [
    '#type' => 'fieldset',
    '#title' => t('Have your Say'),
    '#description' => t("</p>Select the webform to appear on the <strong>Consultation</strong> Content Type as the <em>Have Your Say</em> form.</p>"),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
    '#group' => 'group_tabs',
  ];
  $form['have_your_say']['have_your_say_wform_nid'] = [
    '#type' => 'select',
    '#title' => t('Have your Say form'),
    '#options' => doca_common_get_webform_list(),
    '#default_value' => theme_get_setting('have_your_say_wform_nid'),
    '#description' => t('Choose the <em>Have your Say</em> form. Be careful changing this value as this is for internal reference.'),
  ];
  $form['have_your_say']['funding_default_wform_nid'] = [
    '#type' => 'select',
    '#title' => t('Default Funding and Support form'),
    '#options' => doca_common_get_webform_list(),
    '#default_value' => theme_get_setting('funding_default_wform_nid'),
    '#description' => t('Choose the <em>Default Funding and Support</em> form. Be careful changing this value as this is for internal reference.'),
  ];

  // Load the terms available to be mini-sites
  $vocab = taxonomy_vocabulary_machine_name_load('business_area');
  $minisites = taxonomy_get_tree($vocab->vid);
  $options = [0 => '<-- None -->'];
  foreach ($minisites as $site) {
    $options[$site->tid] = $site->name;
  }

  // Have your Say Form settings
  $form['minisite'] = [
    '#type' => 'fieldset',
    '#title' => t('Mini-site Theme Config'),
    '#description' => t("You can change the Theme settings related to each Sub site by changing the order of the items below."),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
    '#group' => 'group_tabs',
  ];
  $form['minisite']['sub_theme_1'] = [
    '#type' => 'select',
    '#title' => 'Sub Theme 1',
    '#options' => $options,
    '#default_value' => theme_get_setting('sub_theme_1'),
  ];
  $form['minisite']['sub_theme_2'] = [
    '#type' => 'select',
    '#title' => 'Sub Theme 2',
    '#options' => $options,
    '#default_value' => theme_get_setting('sub_theme_2'),
  ];
  $form['minisite']['sub_theme_3'] = [
    '#type' => 'select',
    '#title' => 'Sub Theme 3',
    '#options' => $options,
    '#default_value' => theme_get_setting('sub_theme_3'),
  ];
  $form['minisite']['sub_theme_4'] = [
    '#type' => 'select',
    '#title' => 'Sub Theme 4',
    '#options' => $options,
    '#default_value' => theme_get_setting('sub_theme_4'),
  ];
  $form['minisite']['sub_theme_1_title'] = [
    '#type' => 'hidden',
    '#default_value' => theme_get_setting('sub_theme_1_title'),
  ];
  $form['minisite']['sub_theme_2_title'] = [
    '#type' => 'hidden',
    '#default_value' => theme_get_setting('sub_theme_2_title'),
  ];
  $form['minisite']['sub_theme_3_title'] = [
    '#type' => 'hidden',
    '#default_value' => theme_get_setting('sub_theme_3_title'),
  ];
  $form['minisite']['sub_theme_4_title'] = [
    '#type' => 'hidden',
    '#default_value' => theme_get_setting('sub_theme_4_title'),
  ];
  $form['#validate'][] = '_doca_common_form_system_theme_settings_alter_validate';
  $form['#submit'][] = '_doca_common_form_system_theme_settings_alter_submit';
}

/**
 * An additional validation hook for form_system_theme_settings_alter.
 *
 * @param array &$form
 *        The drupal form array.
 * @param array &$form_state
 *        The drupal form_state array.
 */
function _doca_common_form_system_theme_settings_alter_validate(&$form, &$form_state) {
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
function _doca_common_form_system_theme_settings_alter_submit(&$form, &$form_state) {
  $subsite1 = $form_state['values']['sub_theme_1'];
  $subsite2 = $form_state['values']['sub_theme_2'];
  $subsite3 = $form_state['values']['sub_theme_3'];
  $subsite4 = $form_state['values']['sub_theme_4'];
  // Go through each of the simple contexts that can be changed to the dynamic
  // business areas and change their taxonomy term locations.
  $contexts = context_enabled_contexts();
  $context = $contexts['apply_subsite_class_subsite_2'];
  _doca_common_reset_menu($context, $subsite2);
  $context = $contexts['apply_subsite_class_subsite_3'];
  _doca_common_reset_menu($context, $subsite3);
  $context = $contexts['apply_subsite_class_subsite_1'];
  _doca_common_reset_menu($context, $subsite1);
  $context = $contexts['display_subsite_2_nav'];
  _doca_common_reset_block($context, $subsite2);
  _doca_common_reset_menu($context, $subsite2);
  $context = $contexts['display_subsite_3_nav'];
  _doca_common_reset_block($context, $subsite3);
  _doca_common_reset_menu($context, $subsite3);
  $context = $contexts['display_subsite_1_nav_menu'];
  _doca_common_reset_block($context, $subsite1);
  _doca_common_reset_menu($context, $subsite1);
  $context = $contexts['clone_of_apply_subsite_class_subsite_2'];
  _doca_common_reset_term($context, $subsite2);
  $context = $contexts['clone_of_apply_subsite_class_subsite_3'];
  _doca_common_reset_term($context, $subsite3);
  $context = $contexts['clone_of_apply_subsite_class_subsite_1'];
  _doca_common_reset_term($context, $subsite1);
  $context = $contexts['clone_of_display_subsite_2_nav'];
  _doca_common_reset_block($context, $subsite2);
  _doca_common_reset_term($context, $subsite2);
  $context = $contexts['clone_of_display_subsite_3_nav'];
  _doca_common_reset_block($context, $subsite3);
  _doca_common_reset_term($context, $subsite3);
  $context = $contexts['clone_of_display_subsite_1_nav_menu'];
  _doca_common_reset_block($context, $subsite1);
  _doca_common_reset_term($context, $subsite1);
  // Change the default form ID for the Funding and Support.
  if (!empty($form_state['values']['funding_default_wform_nid'])) {
    $field = field_read_instance('node', 'field_funding_app_webform', 'funding');
    if ($field) {
      $field['default_value'] = [
        0 => [
          'target_id' => $form_state['values']['funding_default_wform_nid'],
        ],
      ];
      field_update_instance($field);
    }
  }
}

/**
 * Helper function to reset the default menu item in the subsite contexts.
 *
 * @param object $context
 *        The drupal context module stdClass object.
 * @param int $tid
 *        The new term id.
 */
function _doca_common_reset_menu($context, $tid) {
  if (!empty($context->conditions['menu']['values']) && is_array($context->conditions['menu']['values'])) {
    reset($context->conditions['menu']['values']);
    $key = key($context->conditions['menu']['values']);
    unset($context->conditions['menu']['values'][$key]);
    $context->conditions['menu']['values']['taxonomy/term/' . $tid] = 'taxonomy/term/' . $tid;
    context_save($context);
  }
}

/**
 * Helper function to reset the Taxonomy term condition on sub site contexts.
 *
 * @param object $context
 *        The drupal context module stdClass object.
 * @param int $tid
 *        The new term id.
 */
function _doca_common_reset_term($context, $tid) {
  if (!empty($context->conditions['menu']['values']) && is_array($context->conditions['menu']['values'])) {
    reset($context->conditions['node_taxonomy']['values']);
    unset($context->conditions['node_taxonomy']['values']);
    $context->conditions['node_taxonomy']['values'] = [$tid => $tid];
    context_save($context);
  }
}

/**
 * Helper function to reset the block reaction in the subsite contexts.
 *
 * @param object $context
 *        The drupal context module stdClass object.
 * @param int $tid
 *        The new term id.
 */
function _doca_common_reset_block(&$context, $tid) {
  if (!empty($context->reactions['block']['blocks']) && is_array($context->reactions['block']['blocks'])) {
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
}
