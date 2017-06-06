<?php
/**
 * @file
 * Channels theme implementation for a container around three column items.
 */
?>
<div class="twitter-stream spacer">

    <h2 class="heading--2--spaced"><?php print $content['field_pbundle_title'][0]['#markup']; ?></h2>

    <a class="twitter-timeline"
       data-chrome="noheader noborders transparent nofooter"
       data-link-color="#00478c"
       data-dnt="true"
       data-tweet-limit="3"
       data-widget-id="<?php print $content['field_twitter_widget_id'][0]['#markup']; ?>"
       href="https://twitter.com/CommsAu"></a>

    <a class="twitter-account" href="https://twitter.com/CommsAu">
      <img class="twitter-account__avatar" src="<?php print base_path() . drupal_get_path('theme', 'dcomms_theme'); ?>/sass/components/twitter-account/twitter-avatar.png" alt="@CommsAu avatar" />
      <b class="twitter-account__title">Dept. Communications</b>
      <i class="twitter-account__icon">on Twitter</i> @CommsAu
    </a>
</div>
