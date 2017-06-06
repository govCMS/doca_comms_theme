<?php
/**
 * @file
 * Returns the HTML for a node.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728164
 */

?>

<?php if (isset($service_links)): ?>
  <div class="layout-max spacer">
    <?php print $service_links; ?>
  </div>
<?php endif; ?>

<div class="document-list">
  <article class="document-list__item"<?php print $attributes; ?>>
    <div class="document-list__inner">
      <?php if ($title_prefix || $title_suffix || $display_submitted || $unpublished || !$page && $title): ?>
        <header>
          <?php print render($title_prefix); ?>
          <h3 class="document-list__title"><?php print $title; ?></h3>
          <?php print render($title_suffix); ?>

          <p class="document-list__date">
            <?php print $submitted; ?>
          </p>

          <?php if ($unpublished): ?>
            <mark class="unpublished"><?php print t('Unpublished'); ?></mark>
          <?php endif; ?>
        </header>
      <?php endif; ?>

      <div class="file__wrapper">
        <?php print render($content['field_file_pdf']); ?>
        <?php print render($content['field_file_word']); ?>
      </div>

      <div class="document-list__desc">
        <?php print render($content['body']); ?>
      </div>

      <?php print render($content['links']); ?>
      <?php print render($content['comments']); ?>
    </div>
  </article>
</div>

<?php print render($content['field_creative_commons_license']); ?>
