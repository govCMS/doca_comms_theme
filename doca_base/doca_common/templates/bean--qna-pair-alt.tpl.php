<?php

/**
 * @file
 * Channels theme implementation for question-answer groups.
 */
?>
      <div class="spacer--bottom-mid">
        <div class="layout-half__main"><?php print render($content['field_bean_text']); ?></div>
        <a href="#" class="align__right link-default" id="qa-expand">Expand all <span>+</span></a>
      </div>
      <div class="accordion">
        <?php print render($content['field_para_qna_pair']); ?>
      </div>
