<?php
  /**
   * @package     Commercial Connections 2019
   * @subpackage  com_content
   *
   * @copyright   Copyright (C) 2019 Commercial Connections Ltd. All rights reserved.
   */

   defined('_JEXEC') or die;

   JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

   $doc = JFactory::getDocument();
   $dir = JUri::base() . 'templates/comcon-2019/';
   // Get the DB object so we can operate with it later
   $db = JFactory::getDbo();

   // Custom functions
   require_once(JPATH_ROOT . '/' . 'templates/comcon-2019/includes/functions/article.php');
   require_once(JPATH_ROOT . '/' . 'templates/comcon-2019/includes/functions/functions.php');

   // Paramter variables
   $params    = $this->item->params;
   $images    = json_decode($this->item->images);
   $urls      = json_decode($this->item->urls);
   $canEdit   = $params->get('access-edit');
   $user      = JFactory::getUser();
   $info      = $params->get('info_block_position', 0);
   $attribs   = json_decode($this->item->attribs);
   $meta      = json_decode($this->item->metadata);

   // Get directory to template
   $dir = JUri::base() . 'templates/comcon-2019/';

   // Get images for the gallery
   $gallery = isset($images->gallery_images) ? json_decode($images->gallery_images) : null;
?>

<main class="home-content">
  <div class="home-content__container">
    <h3 class="home-content__title text__title"><?php echo $this->item->title; ?></h3>
    <!-- <h3 class="home-content__title text__title">Noise problem? No problem.</h3> -->
    <article class="home-content__body">
      <?php echo $this->item->text; ?>
      <!-- <p class="text__line">Commercial Connections Ltd delivers effective acoustic performance to architectural, public sector and industrial projects across the UK & Ireland. We supply soundproofing, fire and thermal products to projects of all scales, from local schools and village halls, to clients such as Danske Bank, Google and Queen's University, Belfast. Our consultants will help you to implement the right solution.</p>
      <p class="text__line">As well as sound testing, we also offer acoustic design advice to help you to meet performance requirements for existing projects, notably for compliance with Part G 2012, BB93 Acoustic Design of Schools, and BS8233 for Open Plan Offices.</p>
      <p class="text__line">Audiometric screening, hand arm vibration tests, and noise at work assessments are also available, enabling you to identify problem areas, reduce health risks, and meet legal requirements in your working environment.</p> -->
    </article>
    <div class="home-content__contact">
      <div class="contact-phone">
        <a href="tel:+442844831227" class="contact-phone__link link-fill">
          <img src="<?php echo $dir; ?>images/assets/icons/phone.png" alt="Phone" class="contact-phone__image">
          <p class="contact-phone__text text__cta">Call us: 028 4483 1227</p>
        </a>
      </div>
      <div class="contact-email">
        <a href="mailto:info@commercialconnections.co.uk" class="contact-email__link link-fill">
          <img src="<?php echo $dir; ?>images/assets/icons/email.svg" alt="Email" class="contact-phone__image">
          <p class="contact-phone__text text__cta">info@commercialconnections.co.uk</p>
        </a>
      </div>
    </div>
  </div>
</main>
