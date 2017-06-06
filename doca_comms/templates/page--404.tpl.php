<?php
/**
 * @file
 * Returns the HTML for a single Drupal page.
 *
 * Complete documentation for this file is available online.
 * @see https://drupal.org/node/1728148
 */
?>


<div class="page-404__page-wrapper">

  <?php if (isset($logo)): ?>
    <div class="layout-max spacer--large">
      <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" class="header__logo" id="logo">
        <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" class="header__logo-image" />
      </a>
    </div>
  <?php endif; ?>


  <div class="page-404__wrapper">

    <div class="page-404__two-column">
      <div class="page-404__column-title">
        <h1>
          <div class="page-404__title">404</div>
          <div class="page-404__sub-title">page not found</div>
        </h1>
      </div>
    </div>

    <div class="page-404__two-column">
      <div class="page-404__message">

        <div class="spacer--vertical--medium">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 37.2 37.2" preserveAspectRatio="xMidYMid meet" style="height:38px; width: 38px;">
            <path fill="none" stroke="#033" stroke-width="1.6" stroke-miterlimit="10" d="M10.8 26.4s3-3 7.8-3 7.8 3 7.8 3" stroke-linecap="round" stroke-linejoin="round"/>
            <path fill="none" stroke="#033" stroke-width="1.2" stroke-miterlimit="10" d="M18.6.6c-10 0-18 8-18 18s8 18 18 18 18-8 18-18-8-18-18-18z" stroke-linecap="round" stroke-linejoin="round"/>
            <circle cx="24.9" cy="16.3" r="2.3" fill="#033"/>
            <circle cx="12.4" cy="16.3" r="2.3" fill="#033"/>
          </svg>
        </div>

        <h2 class="heading--3--light">Oops</h2>

        <p>It looks like you haven't been able to find what you're looking for.</p>

        <p>This could be because we have a brand new website.</p>

        <p>Try again with the link below and use search to find the information you're after.</p>

        <p><a class="read-more" href="https://www.communications.gov.au">www.communications.gov.au</a></p>
      </div>
    </div>

  </div>

</div>

<?php print render($page['bottom']); ?>

</div>
