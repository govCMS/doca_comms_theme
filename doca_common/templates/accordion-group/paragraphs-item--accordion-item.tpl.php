<?php
/**
 * @file
 * Channels theme implementation for accordion items.
 */
?>
<div
  class="accordion__item <?php if (isset($content['field_pbundle_image'])): ?>accordion__item--with-image<?php endif; ?>">
  <button class="accordion__button" aria-expanded="false">
    <?php if (isset($content['field_pbundle_image'])): ?>
      <div class="accordion__image">
        <?php print render($content['field_pbundle_image']); ?>
      </div>
    <?php endif; ?>
    <div>
      <h4 class="accordion__title"><?php print render($content['field_pbundle_title']); ?></h4>
      <?php if (isset($content['field_pbundle_subtitle'])): ?>
        <div class="accordion__subtitle">
          <?php print render($content['field_pbundle_subtitle']); ?>
        </div>
      <?php endif; ?>
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" class="accordion__arrow" version="1.1" viewBox="0 0 800 600"
         preserveAspectRatio="xMidYMid meet" xml:space="preserve"><polygon
        points="672.019,230.77 700,260.625 469.23,507.692 238.461,260.625 266.298,230.77 469.23,447.837 "/></svg>
  </button>
  <div class="accordion__description" aria-hidden="true">
    <?php print render($content['field_pbundle_text']); ?>
  </div>
</div>
