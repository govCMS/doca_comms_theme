<?php
/**
 * @file
 * Template for a statistic paragraph item.
 */
?>
<div class="palette__white-on-black background-image__blue-lines">
  <div class="panel-background-3 layout-max spacer--large">
    <?php print render($content['field_pbundle_title']); ?>

    <div class="layout-one-third__sidebar">
      <?php print render($content['field_pbundle_text']); ?>
    </div>

    <div class="layout-one-two-thirds__main">
      <form method="post" class="spacer--horizontal--medium alert-signup alert-signup__form">
        <?php if ($content['field_hide_name_field']['#items'][0]['value'] === '0'): ?>
            <?php if ($content['field_single_full_name']['#items'][0]['value'] === '0'): ?>
            <div class="form__item">
              <label class="form__label" for="st_FIRST_NAME"><?php print t('First Name'); ?> <span
                  class="form__label__required"><?php print t('(mandatory)'); ?></span></label>
              <input class="form__input" type="text" id="st_FIRST_NAME" required/>
            </div>
            <div class="form__item">
              <label class="form__label" for="st_LAST_NAME"><?php print t('Last Name'); ?> <span
                  class="form__label__required"><?php print t('(mandatory)'); ?></span></label>
              <input class="form__input" type="text" id="st_LAST_NAME" required/>
            </div>
            <?php else: ?>
            <div class="form__item">
              <label class="form__label" for="cu_FULL_NAME"><?php print t('Name'); ?> <span
                  class="form__label__required"><?php print t('(mandatory)'); ?></span></label>
              <input class="form__input" type="text" id="cu_FULL_NAME" required/>
            </div>
          <?php endif; ?>
        <?php endif; ?>
        <div class="form__item">
          <label class="form__label" for="st_EMAIL"><?php print t('Email Address'); ?> <span
              class="form__label__required"><?php print t('(mandatory)'); ?></span></label>
          <input class="form__input" type="email" id="st_EMAIL" placeholder="youremail@email.com" required/>
        </div>
        <?php if ($content['field_hide_contact_number_field']['#items'][0]['value'] === '0'): ?>
          <div class="form__item">
            <label class="form__label" for="cu_CONTACT_NUMBER"><?php print t('Contact number'); ?></label>
            <input class="form__input" type="text" id="cu_CONTACT_NUMBER"/>
          </div>
        <?php endif; ?>
        <input type="hidden" id="cu_DEPARTMENT_ID" value="<?php print render($content['field_department_id']); ?>"/>
        <div class="form__action">
          <input type="submit" value="Subscribe" title="Subscribe to Arts/Works" class="button--normal">
        </div>
      </form>

      <div class="alert-signup__message"></div>
    </div>
  </div>
</div>
