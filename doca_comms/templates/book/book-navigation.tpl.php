<?php

/**
 * @file
 * Default theme implementation to navigate books.
 *
 * Presented under nodes that are a part of book outlines.
 *
 * Available variables:
 * - $tree: The immediate children of the current node rendered as an unordered
 *   list.
 * - $current_depth: Depth of the current node within the book outline. Provided
 *   for context.
 * - $prev_url: URL to the previous node.
 * - $prev_title: Title of the previous node.
 * - $parent_url: URL to the parent node.
 * - $parent_title: Title of the parent node. Not printed by default. Provided
 *   as an option.
 * - $next_url: URL to the next node.
 * - $next_title: Title of the next node.
 * - $has_links: Flags TRUE whenever the previous, parent or next data has a
 *   value.
 * - $book_id: The book ID of the current outline being viewed. Same as the node
 *   ID containing the entire outline. Provided for context.
 * - $book_url: The book/node URL of the current outline being viewed. Provided
 *   as an option. Not used by default.
 * - $book_title: The book/node title of the current outline being viewed.
 *   Provided as an option. Not used by default.
 *
 * @see template_preprocess_book_navigation()
 *
 * @ingroup themeable
 */
?>

<?php if ($tree || $has_links): ?>
    <div id="book-navigation-<?php print $book_id; ?>" class="book-navigation pt-5">

      <?php if ($tree && $parent_url): ?>
          <h2>In this section</h2>
        <?php print $tree; ?>
      <?php endif; ?>
      <?php if ($has_links): ?>
        <?php if (!$prev_url): ?>
              <div class="text-center"><h3>Start reading</h3></div>
        <?php endif; ?>

          <div class="book-navigation-links clearfix border-top border-bottom py-3 row align-items-center">
              <div class="link-prev">
                <?php if ($prev_url): ?>
                    <a href="<?php print $prev_url; ?>" class="page-previous" title="<?php print t('Go to previous page'); ?>"><img class="arrow-left" src="/<?php print path_to_theme();?>/images/arrow.svg" alt="an arrow" /> <span class="link-title-full"><?php print $prev_title; ?></span> <span class="nav-mob-helper">Prev</span></a>
                <?php endif; ?>
              </div>

              <div class="link-up">
                <?php if ($parent_url): ?>
                    <a href="<?php print $parent_url; ?>" title="<?php print t('Go to parent page'); ?>"><img src="/<?php print path_to_theme();?>/images/bars.svg" alt="menu bars" /> <span class="sr-only">up</span></a>
                <?php endif; ?>
              </div>

              <div class="link-next">
                <?php if ($next_url): ?>
                    <a href="<?php print $next_url; ?>" class="page-next" title="<?php print t('Go to next page'); ?>"><span class="link-title-full"><?php print $next_title; ?></span> <span class="nav-mob-helper">Next</span><img class="arrow-right" src="/<?php print path_to_theme();?>/images/arrow.svg" alt="an arrow" /></a>
                <?php endif; ?>
              </div>

          </div>
      <?php endif; ?>

    </div>
<?php endif; ?>
