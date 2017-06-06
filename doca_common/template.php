<?php

/**
 * @file
 * Doca common base theme.
 */

/**
 * Include common theme functions.
 */
include_once dirname(__FILE__) . '/includes/common_templates.func.inc';

/**
 * Include internal helper functions.
 */
include_once dirname(__FILE__) . '/includes/helper.inc';

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
 * Include preprocess functions.
 */
include_once dirname(__FILE__) . '/includes/preprocess.inc';

/**
 * Include theme hook functions.
 */
include_once dirname(__FILE__) . '/includes/theme.inc';

/**
 * Include alter functions.
 */
include_once dirname(__FILE__) . '/includes/alter.inc';
