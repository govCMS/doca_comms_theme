<?php
/**
 * @file
 * Channels theme implementation for q&a pair.
 */
?>
<div class="accordion__item qnapair__item">
  <button class="accordion__button qnapair__button" aria-expanded="false">
    <div>
      <h4 class="qnapair__title"><?php print render($content['field_question']); ?></h4>
      <svg xmlns="http://www.w3.org/2000/svg" class="qnapair__arrow" version="1.1" viewBox="0 0 800 600" width="32"
           height="24" preserveAspectRatio="xMidYMid meet" xml:space="preserve"><polygon
          points="672.019,230.77 700,260.625 469.23,507.692 238.461,260.625 266.298,230.77 469.23,447.837 "/></svg>
    </div>
  </button>
  <div class="accordion__description" aria-hidden="true">
    <?php print render($content['field_answer']); ?>
  </div>
</div>
