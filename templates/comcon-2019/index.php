<?php
  defined('_JEXEC') or die('Restricted access');

  $doc = JFactory::getDocument();
  $dir = JUri::base() . 'templates/comcon-2019/';

  // Stylesheets //
  $doc->addStyleSheet($dir . "css/style.css" . "?ver=1.0.5");

  // JS libraries //
  $doc->addScript(JUri::base() . 'templates/comcon-2019/js/jquery.min.js');

  // Dropdown menu
  $applink = "<script type=\"module\">import {navtop} from \"" . $dir . "js/comcon/init.js\"; navtop.init();</script>";
  $doc->addCustomTag($applink);

  // Remove generator tag
  $this->setGenerator(null);

  // Add JSON-LD to page
  $jsonldLocalBusiness =  '
                            <script type="application/ld+json">
                              {
                                "@context": "http://schema.org",
                                "@type": "LocalBusiness",
                                "name": "Commercial Connections Ltd",
                                "image": "' . $dir . 'images/assets/logos/logo-background.png",
                                "telephone": "+442844831227",
                                "address":
                                {
                                  "@type": "PostalAddress",
                                  "name": "Commercial Connections Ltd",
                                  "streetAddress": "37 Ballywillin Road",
                                  "addressLocality": "Crossgar",
                                  "postalCode": "BT30 9LE",
                                  "addressCountry":
                                  {
                                    "@type": "Country",
                                    "name": "Northern Ireland"
                                  }
                                }
                              }
                            </script>
                          ';
    $doc->addCustomTag($jsonldLocalBusiness);

?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
  <head>
    <jdoc:include type="head" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
  </head>
  <body>
    <div class="top-bar">
      <div class="top-bar__content">
        <div class="top-bar__logos">
          <a href="<?php echo JUri::base(); ?>" class="link-fill">
            <img src="<?php echo $dir; ?>images/assets/logos/logo.png" alt="Commercial Connections Ltd" class="top-bar__logo">
            <img src="<?php echo $dir; ?>images/assets/logos/logo-small.png" alt="Commercial Connections Ltd" class="top-bar__logo top-bar__logo--small">
            <img src="<?php echo $dir; ?>images/assets/logos/logo-only.png" alt="Commercial Connections Ltd" class="top-bar__logo top-bar__logo--only">
          </a>
        </div>
        <div class="top-bar__contact">
          <a href="tel:+442844831227" class="top-bar__phonetext link-text">Call us: 028 4483 1227</a>
          <div class="top-bar__social">
            <a href="https://linkedin.com/company/commercial-connections-limited" target="_blank">
              <img src="<?php echo $dir; ?>images/assets/icons/linkedin-white.svg" alt="Follow us on LinkedIn" class="top-bar__smicon">
            </a>
            <a href="https://twitter.com/comconacoustics" target="_blank">
              <img src="<?php echo $dir; ?>images/assets/icons/twitter-white.svg" alt="Follow us on Twitter" class="top-bar__smicon">
            </a>
          </div>
        </div>
      </div>
    </div>
    <nav class="nav-top">
      <div class="nav-top__container">
        <ul class="nav-top__items">
          <jdoc:include type="modules" name="nav-top"/>
        </ul>
        <jdoc:include type="modules" name="top-bar-search" />
      </div>
    </nav>
    <div class="container">
      <?php if ($this->countModules('breadcrumbs')) : ?>
      <nav class="breadcrumbs">
        <jdoc:include type="modules" name="breadcrumbs" />
      </nav>
      <?php endif; ?>
      <?php if ($this->countModules('hero')): ?>
        <jdoc:include type="modules" name="hero" />
      <?php endif; ?>
      <?php if ($this->countModules('nav-main')): ?>
        <div class="main-nav-wrap">
          <div class="hr"></div>
          <h2 class="text__title">How can we help?</h2>
          <div class="hr"></div>
        </div>
        <nav class="main-nav">
          <ul class="main-nav__items">
            <jdoc:include type="modules" name="nav-main" />
          </ul>
        </nav>
        <div class="main-nav-wrap">
          <div class="hr"></div>
        </div>
      <?php endif ?>
      <jdoc:include type="component"/>
      <div class="main-bottom">
        <?php if ($this->countModules('items-left')): ?>
          <jdoc:include type="modules" name="items-left" />
        <?php endif; ?>
        <?php if ($this->countModules('items-right')): ?>
          <jdoc:include type="modules" name="items-right" />
        <?php endif; ?>
      </div>
    </div>
    <div class="contact-phone contact-phone--fixed">
      <a href="tel:+442844831227" class="contact-phone__link link-fill">
        <img src="<?php echo $dir; ?>images/assets/icons/phone.png" alt="Phone" class="contact-phone__image">
      </a>
    </div>
    <footer class="footer">
      <div class="footer__content">
        <div class="footer__top">
          <jdoc:include type="modules" name="footer-partners" />
        </div>
        <div class="footer__columns">
          <div class="footer__text">
            <jdoc:include type="modules" name="footer-text" />
          </div>
          <div class="footer__links">
            <jdoc:include type="modules" name="footer-links" />
          </div>
          <address class="footer__address">
            <ul itemscope itemtype="https://schema.org/PostalAddress">
              <li>Commercial Connections Ltd</li>
              <li itemprop="streetAddress">37 Ballywillin Road</li>
              <li itemprop="addressLocality">Crossgar</li>
              <li itemprop="postalCode">BT30 9LE</li>
              <li itemprop="addressCountry">Northern Ireland</li>
            </ul>
          </address>
          <div class="footer__contact">
            <jdoc:include type="modules" name="footer-contact" />
            <div class="footer-social">
              <jdoc:include type="modules" name="footer-social" />
            </div>
          </div>
        </div>
      </div>
    </footer>
    <script type="text/javascript" src="<?php echo $dir . "js/comcon/nav-box/app.js"; ?>">

    </script>
    <script type="text/javascript">
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-86468332-1', 'auto');
      ga('send', 'pageview');
    </script>
  </body>
</html>
