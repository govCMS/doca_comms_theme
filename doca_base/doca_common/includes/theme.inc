<?php

/**
 * @file
 * Common theme hook functions.
 */

/**
 * Implements theme_breadcrumb().
 */
function doca_common_breadcrumb($variables) {
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
 * Implements theme_file_icon().
 */
function doca_common_file_icon($variables) {
  $file = $variables['file'];
  $icon_directory = drupal_get_path('theme', 'doca_common') . '/dist/images/document';

  $mime = check_plain($file->filemime);
  $icon_url = file_icon_path($file, $icon_directory);

  if ($icon_url == FALSE) {
    $icon_url = $icon_directory . '/generic.png';
  }

  return '<img alt="" class="file__icon" src="' . base_path() . $icon_url . '" title="' . $mime . '" />';
}

/**
 * Implements hook_theme().
 */
function doca_common_item_list($variables) {
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
      $attributes = [];
      $children = [];
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
        $data .= theme_item_list([
          'items' => $children,
          'title' => NULL,
          'type' => $type,
          'attributes' => $attributes,
        ]);
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
 * Implements theme_menu_tree__MENU_NAME().
 */
function doca_common_menu_tree__main_menu($variables) {
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
    $output .= l(t('Search'), 'search', ['attributes' => ['class' => ['header-search__icon--link']]]);
    $output .= '</li>';

    $output .= '</ul>';
  }

  return $output;
}

/**
 * Implements theme_menu_link__MENU_NAME().
 */
function doca_common_menu_link__main_menu(array $variables) {
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
function doca_common_menu_tree__menu_footer_menu($variables) {
  return '<ul class="footer-menu">' . $variables['tree'] . '</ul>';
}

/**
 * Implements theme_menu_link__MENU_NAME().
 */
function doca_common_menu_link__menu_footer_menu(array $variables) {
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
function doca_common_menu_tree__menu_footer_sub_menu($variables) {
  return '<ul class="list-unstyled list-inline">' . $variables['tree'] . '</ul>';
}

/**
 * Implements theme_menu_link__MENU_NAME().
 */
function doca_common_menu_link__menu_footer_sub_menu(array $variables) {
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
 * Implements theme_pager().
 */
function doca_common_pager($variables) {
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

  $li_first = theme('pager_first', [
    'text' => (isset($tags[0]) ? $tags[0] : t('« first')),
    'element' => $element,
    'parameters' => $parameters,
  ]);
  $li_previous = theme('pager_previous', [
    'text' => (isset($tags[1]) ? $tags[1] : t('‹ previous')),
    'element' => $element,
    'interval' => 1,
    'parameters' => $parameters,
  ]);
  $li_next = theme('pager_next', [
    'text' => (isset($tags[3]) ? $tags[3] : t('next ›')),
    'element' => $element,
    'interval' => 1,
    'parameters' => $parameters,
  ]);
  $li_last = theme('pager_last', [
    'text' => (isset($tags[4]) ? $tags[4] : t('last »')),
    'element' => $element,
    'parameters' => $parameters,
  ]);

  if ($pager_total[$element] > 1) {
    if ($li_first) {
      $items[] = [
        'class' => ['pager-first'],
        'data' => $li_first,
      ];
    }
    if ($li_previous) {
      $items[] = [
        'class' => ['pager-previous'],
        'data' => $li_previous,
      ];
    }

    // When there is more than one page, create the pager list.
    if ($i != $pager_max) {
      if ($i > 1) {
        $items[] = [
          'class' => ['pager-ellipsis'],
          'data' => '…',
        ];
      }
      // Now generate the actual pager piece.
      for (; $i <= $pager_last && $i <= $pager_max; $i++) {
        if ($i < $pager_current) {
          $items[] = [
            'class' => ['pager-item'],
            'data' => theme('pager_previous', [
              'text' => $i,
              'element' => $element,
              'interval' => ($pager_current - $i),
              'parameters' => $parameters,
            ]),
          ];
        }
        if ($i == $pager_current) {
          $items[] = [
            'class' => ['pager-current'],
            'data' => '<span>' . $i . '</span>',
          ];
        }
        if ($i > $pager_current) {
          $items[] = [
            'class' => ['pager-item'],
            'data' => theme('pager_next', [
              'text' => $i,
              'element' => $element,
              'interval' => ($i - $pager_current),
              'parameters' => $parameters,
            ]),
          ];
        }
      }
      if ($i < $pager_max) {
        $items[] = [
          'class' => ['pager-ellipsis'],
          'data' => '…',
        ];
      }
    }
    // End generation.
    if ($li_next) {
      $items[] = [
        'class' => ['pager-next'],
        'data' => $li_next,
      ];
    }
    if ($li_last) {
      $items[] = [
        'class' => ['pager-last'],
        'data' => $li_last,
      ];
    }

    $output = '<div class="pager__wrapper">';
    $output .= '<h2 class="element-invisible">' . t('Pages') . '</h2>' . theme('item_list', [
          'items' => $items,
          'attributes' => ['class' => ['pager']],
        ]
      );
    $output .= "</div>";

    return $output;
  }
}

/**
 * Implements hook_theme().
 */
function doca_common_theme($existing, $type, $theme, $path) {
  return [
    'share_row' => [
      'template' => 'templates/share-row',
      'variables' => [
        'title' => NULL,
        'url' => NULL,
      ],
    ],
    'list_arrow' => [
      'template' => 'templates/list-arrow',
      'variables' => [
        'items' => NULL,
      ],
    ],
  ];
}
