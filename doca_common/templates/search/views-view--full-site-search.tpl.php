<?php

/**
 * @file
 * Main view template for contextual policy listings.
 *
 * @ingroup views_templates
 */
?>
<svg xmlns="http://www.w3.org/2000/svg" style="display:none;">
  <symbol id="alert" fill="none" fill-rule="evenodd" viewBox="0 0 32 32">
    <title>Alert</title>
    <path stroke="#00478C" stroke-width="1.224"
          d="M29.1 13.7L16.3.9c-.7-.7-2-.7-2.8 0L.9 13.7c-.7.7-.7 2 0 2.8l12.7 12.7c.7.7 2 .7 2.8 0l12.7-12.7c.8-.9.8-2.1 0-2.8z"/>
    <path stroke="#00478C" stroke-width="1.224"
          d="M29.1 13.7L16.3.9c-.7-.7-2-.7-2.8 0L.9 13.7c-.7.7-.7 2 0 2.8l12.7 12.7c.7.7 2 .7 2.8 0l12.7-12.7c.8-.9.8-2.1 0-2.8z"/>
    <path fill="#00478C"
          d="M15.7 19.7c.1 0 .2.1.2.2v1.6c0 .1-.1.2-.2.2h-1.5c-.1 0-.2-.1-.2-.2V20c0-.1.1-.2.2-.2l1.5-.1zm0-11.4c.1 0 .2.1.2.2v8.9c0 .1-.1.2-.2.2h-1.4c-.1 0-.2-.1-.2-.2V8.5c0-.1.1-.2.2-.2h1.4z"/>
  </symbol>
  <symbol id="blog-article" fill="none" fill-rule="evenodd" stroke="#00478C" stroke-width="1.224"
          transform="translate(0 35)">
    <title>Blog Article</title>
    <path
      d="M15.4.7C7.4.7.8 6.5.8 13.6c0 3.6 1.7 6.9 4.4 9.2 0 4.2-3.8 6.3-4.6 7 3.9 1 9.2-1.5 11.8-3.6 1 .2 2 .3 3.1.3 8 0 14.6-5.8 14.6-12.9C29.9 6.5 23.5.7 15.4.7z"/>
    <path
      d="M16.8 15.3c-.1-.5 0-.8 0-1.3.2-.1.6-.9.7-1.5.2 0 .4-.2.5-.9.1-.4-.1-.6-.2-.6.3-.9.9-3.5-1.1-3.7-.2-.4-.7-.5-1.4-.5-2.7.1-3.1 2-2.4 4.3-.1.1-.3.2-.2.6.1.7.4.9.6.9.1.6.5 1.3.7 1.5v1.3c-.6 1.4-4.2 1-4.3 3.7h11.6c-.4-2.8-4-2.4-4.5-3.8z"/>
  </symbol>
  <symbol id="consultation" fill="none" fill-rule="evenodd" stroke="#00478C" stroke-width="1.111"
          transform="translate(0 70)">
    <title>Consultation</title>
    <path
      d="M8 9.7V8.4c.2-.1.7-.9.7-1.5.2 0 .4-.2.6-.9.1-.4-.1-.6-.2-.7.3-.9.9-3.6-1.2-3.9C7.7 1 7.1.8 6.5.8 3.7.9 3.3 2.9 4 5.3c-.1.1-.3.3-.2.7.1.7.4.9.6.9.1.7.5 1.4.7 1.5 0 .4 0 .8-.1 1.3-.6 1.5-4.3 1.1-4.5 3.9h12.1c-.3-2.8-4-2.4-4.6-3.9zm17.4 13.8c-.1-.5-.1-.9-.1-1.3.2-.1.7-.9.7-1.5.2 0 .4-.2.6-.9.1-.4-.1-.6-.2-.7.3-.9.9-3.6-1.2-3.9-.2-.4-.8-.6-1.5-.6-2.8.1-3.2 2.1-2.6 4.5-.1.1-.3.3-.2.7.1.7.4.9.6.9.1.7.5 1.4.7 1.5 0 .4 0 .8-.1 1.3-.6 1.5-4.3 1-4.5 3.9h12.1c0-2.8-3.7-2.4-4.3-3.9zm-1.6-12.4V5.6c0-1.5-.9-2.5-2.5-2.5h-7.8M3.4 20.9l3-3 3.1 3m-3.1-3v5.5c0 1.5.9 2.5 2.5 2.5h4.9m13-17.8l-3 3-3.1-3"/>
  </symbol>
  <symbol id="document" fill="none" fill-rule="evenodd" transform="translate(4 105)">
    <title>Document</title>
    <path fill="#00478C" d="M13.6 0H.1v29.1H22V8.5L13.6 0zm.3 2L20 8.2h-6.1V2zm6.9 26H1.3V1.2h11.5v8.2h8V28z"/>
    <path stroke="#00478C" stroke-width="1.3" d="M4.2 14.9h12.6M4.2 18h12.6M4.2 21.2h8.4"/>
  </symbol>
  <symbol id="news-article" fill="none" fill-rule="evenodd" transform="translate(3 140)">
    <title>News Article</title>
    <path stroke="#00478C" stroke-width="1.224"
          d="M13.7 20H0m13.7-3.4H0m0 6.6h13.7m11.1 3.2H0m0 3.3h24.8m-.2-21h-8.4m8.4-3.3h-8.4m0 6.5h8.4"/>
    <path fill="#00478C"
          d="M12.4 5.9v5.6H1.2V5.9h11.2zm1.3-1.3H0v8h13.7v-8zm9.8 12.5v5.6h-6v-5.6h6zm1.2-1.2h-8.4v8h8.4v-8zM0 .7h24.6v1.8H0V.7z"/>
  </symbol>
  <symbol id="policy" fill="none" fill-rule="evenodd" stroke="#00478C" stroke-width="1.333"
          transform="translate(3 175)">
    <title>Policy</title>
    <path
      d="M.7 30.7V.7h25v30H.7zM5.1 7h16.2H5.1zm12.8 9.3h3.4-3.4zm-12.8 0h9.5-9.5zm0 4h9.5-9.5zm12.8 0h3.4-3.4zm-12.8 4h9.5-9.5zm12.8 0h3.4-3.4z"/>
  </symbol>
  <symbol id="poll" fill="none" fill-rule="evenodd" stroke="#00478C" stroke-width="1.224" transform="translate(0 210)">
    <title>Poll</title>
    <path
      d="M15 .6C7 .6.4 6.4.4 13.5c0 3.6 1.7 6.9 4.4 9.2 0 4.2-3.8 6.3-4.6 7 3.9 1 9.2-1.5 11.8-3.6 1 .2 2 .3 3.1.3 8 0 14.6-5.8 14.6-12.9C29.6 6.4 23 .6 15 .6z"/>
    <path d="M7 9.7h2.6v10.6H7V9.7zm4.3 2.3h2.6v8.4h-2.6V12zm8.8 1.3h2.6v7.1h-2.6v-7.1zm-4.4-7.5h2.6v14.6h-2.6V5.8z"/>
  </symbol>
  <symbol id="publication" fill="none" fill-rule="evenodd" stroke="#00478C" stroke-width="1.224"
          transform="translate(0 245)">
    <title>Publication</title>
    <path
      d="M3.7 4.6h-2c-.6 0-1.1.5-1.1 1.2V26c0 .6.5 1.1 1.1 1.1h10.5s1 1.8 3.1 1.8 3.1-1.8 3.1-1.8h10.5c.6 0 1.1-.5 1.1-1.1V5.7c0-.6-.5-1.2-1.1-1.2h-2"/>
    <path
      d="M15.3 4.6v20.7s2.5-2.4 11.6-2.4V1C17.8.9 15.3 4.6 15.3 4.6zm0 0v20.7s-2.5-2.4-11.6-2.4V1c9.2-.1 11.6 3.6 11.6 3.6z"/>
  </symbol>
  <symbol id="standard-page" fill="none" fill-rule="evenodd" transform="translate(0 280)">
    <title>Standard page</title>
    <path stroke="#00478C" stroke-width="1.154" d="M.6.9h29.7v23.8H.6V.9z"/>
    <circle cx="20.3" cy="4.3" r="1.2" fill="#00478C"/>
    <circle cx="23.8" cy="4.3" r="1.2" fill="#00478C"/>
    <circle cx="27.3" cy="4.3" r="1.2" fill="#00478C"/>
  </symbol>
  <symbol id="statistic" fill="none" fill-rule="evenodd" stroke="#00478C" stroke-width="1.224"
          transform="translate(0 315)">
    <title>Statistic</title>
    <path
      d="M15.4 4.4c.5-.1 1.1-.1 1.7-.1 7.1 0 12.9 5.8 12.9 12.9C30 24.3 24.2 30 17.1 30 10 30 4.2 24.2 4.2 17.1c0-.6.1-1.2.1-1.8m9.2-1.8H.6C.6 6.4 6.4.6 13.5.6v12.9z"/>
  </symbol>
  <symbol id="research-data" fill="none" fill-rule="evenodd" transform="translate(0 350)">
    <title>Research Data</title>
    <path stroke="#00478C" stroke-width="1.224" d="M.6 18.2v-6.3l4.9 1.2 8.6-6.2 8.6 2.5L30 .7v10.1"/>
    <path stroke="#00478C" stroke-width="1.224" d="M.6 18.1l9.8 2.5 6.1-8.7 8.6 3.1 4.9-4.2v17.4H.6V18.1z"/>
    <g fill="#00478C" transform="translate(0 4.356)">
      <circle cx="17.8" cy="5" r=".6"/>
      <circle cx="14.1" cy="5" r=".6"/>
      <circle cx="14.1" cy="8.8" r=".6"/>
      <circle cx="10.4" cy="8.8" r=".6"/>
      <circle cx="10.4" cy="12.5" r=".6"/>
      <circle cx="6.7" cy="12.5" r=".6"/>
      <circle cx="15.9" cy="3.2" r=".6"/>
      <circle cx="15.9" cy="6.9" r=".6"/>
      <circle cx="26.9" cy="3.2" r=".6"/>
      <circle cx="26.9" cy="6.9" r=".6"/>
      <circle cx="12.2" cy="10.6" r=".6"/>
      <circle cx="12.2" cy="6.9" r=".6"/>
      <circle cx="6.7" cy="8.8" r=".6"/>
      <circle cx="8.6" cy="10.6" r=".6"/>
      <circle cx="8.6" cy="14.4" r=".6"/>
      <circle cx="4.9" cy="14.4" r=".6"/>
      <circle cx="4.9" cy="10.6" r=".6"/>
      <circle cx="3.1" cy="12.5" r=".6"/>
      <circle cx="3.1" cy="8.8" r=".6"/>
      <circle cx="1.2" cy="10.6" r=".6"/>
      <circle cx="8.6" cy="6.9" r=".6"/>
      <circle cx="28.8" cy="1.3" r=".6"/>
      <circle cx="28.8" cy="5" r=".6"/>
      <circle cx="19.6" cy="6.9" r=".6"/>
      <circle cx="23.3" cy="6.9" r=".6"/>
      <circle cx="21.4" cy="5" r=".6"/>
      <circle cx="21.4" cy="8.8" r=".6"/>
      <circle cx="25.1" cy="5" r=".6"/>
      <circle cx="25.1" cy="8.8" r=".6"/>
    </g>
  </symbol>
  <symbol id="research-report" fill="none" fill-rule="evenodd" stroke="#00478C" stroke-width="1.224"
          transform="translate(2 385)">
    <title>Research Report</title>
    <path d="M.9.9h20.9v26.9H.9V.9z"/>
    <path d="M3.4 27.9v2.4h20.9V3.4h-2.5"/>
    <circle cx="10.3" cy="12.8" r="5.3"/>
    <path d="M14.1 16.8l4.4 4.4"/>
  </symbol>
  <symbol id="newsletter" fill="none" fill-rule="evenodd" transform="translate(0 420)">
    <title>Newsletter</title>
    <path stroke="#00478C" stroke-width="1.154" d="M.6.2h29.7v25.5H.6V.2z"/>
    <circle cx="20.3" cy="3.7" r="1.2" fill="#00478C"/>
    <circle cx="23.8" cy="3.7" r="1.2" fill="#00478C"/>
    <circle cx="27.3" cy="3.7" r="1.2" fill="#00478C"/>
    <path stroke="#00478C" stroke-width="1.154"
          d="M7.2 9.2h16.6v11.6H7.2V9.2zm5.3 6l-5.3 4.2 5.3-4.2zm5.9 0l5.2 4.2-5.2-4.2z"/>
    <path stroke="#00478C" stroke-width="1.154"
          d="M23.7 10.6s-6.3 5.5-6.9 5.9c-.5.5-1 .6-1.4.6-.3 0-.9-.1-1.4-.6-.5-.5-6.9-5.9-6.9-5.9"/>
  </symbol>
</svg>


<div class="document-list <?php print $classes; ?>">
  <?php print render($title_prefix); ?>
  <?php if ($title): ?>
    <?php print $title; ?>
  <?php endif; ?>
  <?php print render($title_suffix); ?>
  <?php if ($header): ?>
    <div class="view-header">
      <?php print $header; ?>
    </div>
  <?php endif; ?>

  <?php if ($exposed): ?>
    <div class="view-filters">
      <?php print $exposed; ?>
    </div>
  <?php endif; ?>

  <?php if ($attachment_before): ?>
    <div class="attachment attachment-before">
      <?php print $attachment_before; ?>
    </div>
  <?php endif; ?>

  <?php if ($rows): ?>
    <div class="view-count">
      <p class="font__small">
        <?php echo t('Showing !count of !total results, most relevant first.', array('!count' => count($view->result), '!total' => $view->total_rows)); ?>
      </p>
    </div>
    <div class="view-content">
      <?php print $rows; ?>
    </div>
  <?php elseif ($empty): ?>
    <div class="view-empty">
      <?php print $empty; ?>
    </div>
  <?php endif; ?>

  <?php if ($pager): ?>
    <?php print $pager; ?>
  <?php endif; ?>

  <?php if ($attachment_after): ?>
    <div class="attachment attachment-after">
      <?php print $attachment_after; ?>
    </div>
  <?php endif; ?>

  <?php if ($more): ?>
    <?php print $more; ?>
  <?php endif; ?>

  <?php if ($footer): ?>
    <div class="view-footer">
      <?php print $footer; ?>
    </div>
  <?php endif; ?>

  <?php if ($feed_icon): ?>
    <div class="feed-icon">
      <?php print $feed_icon; ?>
    </div>
  <?php endif; ?>

</div><?php /* class view */ ?>
