<?php
/**
 * @file
 * Default theme implementation for blocks.
 */
?>

<div class="header-search__form" id="search-form" role="search" aria-labelledby="search-form-label">
  <form action="/search" method="get" accept-charset="UTF-8">
    <div class="header-search__item">
      <label class="element-invisible" id="search-form-label">Search this website</label>
      <input class="header-search__input" type="text" name="search_api_views_fulltext" placeholder="Search">
    </div>
    <?php if (isset($block->subsite)) : ?>
      <div class="header-search__item">
        <input type="checkbox" name="ss" id="search_subsite_only" checked value="<?php print $block->subsite; ?>">
        <label for="search_subsite_only" class="form__label--inline">Only search within <?php print $block->subsite_name; ?></label>
      </div>
    <?php endif; ?>
    <div class="header-search__button-wrapper">
      <input type="submit" class="header-search__icon--button" value="Search">
    </div>
  </form>
</div>
