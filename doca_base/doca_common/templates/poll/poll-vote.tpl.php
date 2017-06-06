<?php

/**
 * @file
 * Default theme implementation to display voting form for a poll.
 *
 * - $choice: The radio buttons for the choices in the poll.
 * - $title: The title of the poll.
 * - $block: True if this is being displayed as a block.
 * - $vote: The vote button
 * - $rest: Anything else in the form that may have been added via
 *   form_alter hooks.
 *
 * @see template_preprocess_poll_vote()
 *
 * @ingroup themeable
 */
$nid = $variables['form']['#node']->nid;
?>
<div class="poll-form poll-form--<?php print doca_common_get_poll_type($nid); ?>">
  <?php if ($block): ?>
    <div class="poll-form__title" id="poll_<?php print $nid; ?>__title"><?php print $title; ?></div>
  <?php endif; ?>
  <div class="poll-form__choices" role="radiogroup" aria-labelledby="poll_<?php print $nid; ?>__title">
    <?php print $choice; ?>
  </div>
  <?php print $vote; ?>
  <?php print $rest ?>
</div>
