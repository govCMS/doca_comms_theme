<?php

/**
 * @file
 * Default theme implementation to display the poll results in a block.
 *
 * Variables available:
 * - $title: The title of the poll.
 * - $results: The results of the poll.
 * - $votes: The total results in the poll.
 * - $links: Links in the poll.
 * - $nid: The nid of the poll
 * - $cancel_form: A form to cancel the user's vote, if allowed.
 * - $raw_links: The raw array of links.
 * - $vote: The choice number of the current user's vote.
 *
 * @see template_preprocess_poll_results()
 *
 * @ingroup themeable
 */
?>
<div class="poll-results poll-results--<?php print doca_common_get_poll_type($variables['nid']); ?>">
  <?php print $results; ?>
  <div class="poll-results__total">
    <?php if (doca_common_get_poll_type($variables['nid']) == 'binary'): ?>
      <?php print t('@votes_1 people agree with you, @votes_2 had a different opinion', array(
        '@votes_1' => $votes_1,
        '@votes_2' => $votes_2,
      ));
      ?>
    <?php else: ?>
      <?php print t('Total votes: @votes', array('@votes' => $votes)); ?>
    <?php endif; ?>
  </div>
  <?php if (!empty($cancel_form)): ?>
    <?php print $cancel_form; ?>
  <?php endif; ?>
</div>
