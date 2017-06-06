<?php
/**
 * @file
 * Main panel pane template
 */
?>
<?php if ($pane_prefix): ?>
  <?php print $pane_prefix; ?>
<?php endif; ?>

<div class="alert-signup layout-two-column" <?php print $id; ?> <?php print $attributes; ?>>
  <div class="layout-two-column__item">
    <?php if ($admin_links): ?>
      <?php print $admin_links; ?>
    <?php endif; ?>

    <?php print render($title_prefix); ?>
    <?php if ($title): ?>
      <h2<?php print $title_attributes; ?>><?php print $title; ?></h2>
    <?php endif; ?>
    <?php print render($title_suffix); ?>

    <?php print render($content); ?>

    <form method="post" class="em_wfe_form serviceSubscribe" id="em_subscribe_form" name="em_subscribe_form" action="https://alerts.staysmartonline.gov.au/em/forms/subscribe.php?db=367399&s=82046&a=38192&k=20950e0&wt=1" enctype="multipart/form-data" target="_blank">
      <div class="form__action">
        <input type="submit" value="Subscribe" title="Subscribe to the Stay Smart Online alert service" class="button--alert">
      </div>
    </form>
  </div>
  <div class="layout-two-column__item show-at__medium">
    <img class="alert-signup__svg" src="<?php print base_path() . drupal_get_path('theme', 'dcomms_theme'); ?>/images/SSO-alert-service.svg" />
  </div>
</div>

<?php if ($pane_suffix): ?>
  <?php print $pane_suffix; ?>
<?php endif; ?>
