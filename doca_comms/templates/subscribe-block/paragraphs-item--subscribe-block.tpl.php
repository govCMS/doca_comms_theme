<?php
/**
 * @file
 * Template for a statistic paragraph item.
 */
?>
<div class="alert-signup layout-two-column">
  <div class="layout-two-column__item">

    <?php print render($content['field_pbundle_title']); ?>
    <?php print render($content['field_pbundle_text']); ?>

    <form method="post" class="alert-signup__form">
      <?php if($content['field_hide_name_field']['#items'][0]['value'] === '0'): ?>
        <div class="form__item">
          <label class="form__label" for="cu_FULL_NAME"><?php print t('Name'); ?> <span class="form__label__required"><?php print t('(mandatory)'); ?></span></label>
          <input class="form__input" type="text" id="cu_FULL_NAME" required />
        </div>
      <?php endif; ?>
      <div class="form__item">
        <label class="form__label" for="st_EMAIL"><?php print t('Email Address'); ?> <span class="form__label__required"><?php print t('(mandatory)'); ?></span></label>
        <input class="form__input" type="email" id="st_EMAIL" placeholder="youremail@email.com" required />
      </div>
      <?php if($content['field_hide_contact_number_field']['#items'][0]['value'] === '0'): ?>
        <div class="form__item">
          <label class="form__label" for="cu_CONTACT_NUMBER"><?php print t('Contact number'); ?></label>
          <input class="form__input" type="text" id="cu_CONTACT_NUMBER" />
        </div>
      <?php endif; ?>
      <input type="hidden" id="cu_DEPARTMENT_ID" value="<?php print render($content['field_department_id']); ?>" />
      <div class="form__action">
        <input type="submit" value="Subscribe" title="Subscribe to the alert service" class="button--alert">
      </div>
    </form>

    <div class="alert-signup__message"></div>

  </div>
  <div class="layout-two-column__item show-at__medium">
    <?php if(isset($content['field_pbundle_image']['#items'])): ?>
      <?php print render($content['field_pbundle_image']); ?>
    <?php else: ?>
      <img class="alert-signup__svg" src="<?php print base_path() . drupal_get_path('theme', 'dcomms_theme'); ?>/images/SSO-alert-service.svg" />
    <?php endif; ?>
  </div>
</div>
