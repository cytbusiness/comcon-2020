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

   // Add the gallery app
   $applink = "<script type=\"module\">import {stringsBase, stringsCollage, stringsDownloads, stringsFullscreen, stringsProduct, collage, downloads} from \"" . $dir . "js/comcon/init.js\"; collage.init([[stringsBase, stringsCollage, stringsFullscreen], 3, stringsCollage.collageProduct]); downloads.init([[stringsBase, stringsDownloads, stringsFullscreen, stringsProduct]]);</script>";
   $doc->addCustomTag($applink);

   // Get the recommended products
   $recommended = isset($meta->recommended_products) ? json_decode($meta->recommended_products) : null;
   $recommendedItems = isset($recommended) ? $recommended->recommended_products_item : null;

   // Remove recommended_products from meta tags
   $doc->setMetaData('recommended_products', null);

   if ($recommendedItems != null)
   {
     $recommendedArray = [];

     foreach ($recommendedItems as $key => $value)
     {
       $query = $db->getQuery(true);

       $query
        ->select($db->quoteName('a.id'))
        ->select($db->quoteName('a.catid'))
        ->select($db->quoteName('a.title'))
        ->select($db->quoteName('a.images'))
        ->select($db->quoteName('a.attribs'))
        ->from($db->quoteName('#__content', 'a'))
        ->where($db->quoteName('a.id') . ' = ' . $value);

       $db->setQuery($query);

       $results = $db->loadObjectList();

       array_push($recommendedArray, $results);
     }
   }
?>

<article class="main main--soundproofing">
  <h1 class="text__title" itemprop="name"><?php echo $this->item->title; ?></h1>
  <p class="text__line" itemprop="headline"><?php echo $attribs->alternative_readmore; ?></p>
  <section class="soundproofing">
    <section class="soundproofing__top">
      <div class="collage collage--product">
        <div class="collage__items">
          <?php

            // Only make the first 3 items visible
            $count = 0;
            if (!empty($gallery))
            {
              foreach ($gallery->gallery_image as $key => $val)
              {
                if ($count < 3)
                {
                  // Output the images to the gallery
                  //echo $key . "<br>" . $val . "<br>" . $gallery->gallery_image_alt[$key] . "<br>" . $gallery->gallery_image_description[$key] . "<br><br>";
                  $url = $val;
                  $alt = $gallery->gallery_image_alt[$key];
                  $title = $gallery->gallery_image_title[$key];
                  $desc = $gallery->gallery_image_description[$key];

                  echo "<a href=\"$url\" class=\"collage__item collage__item--visible link\" target=\"_blank\"><img src=\"$val\" alt=\"$alt\" title=\"$title\" data-text=\"$desc\" class=\"collage__image\"></a>";
                  $count++;
                }
                else
                {
                  $url = $val;
                  $alt = $gallery->gallery_image_alt[$key];
                  $title = $gallery->gallery_image_title[$key];
                  $desc = $gallery->gallery_image_description[$key];

                  echo "<a href=\"$url\" class=\"collage__item collage__item link\" target=\"_blank\"><img src=\"$val\" alt=\"$alt\" title=\"$title\" data-text=\"$desc\" class=\"collage__image\"></a>";
                  $count++;
                }
              }
            }
          ?>
        </div>
      </div>

      <div class="product__topright">
        <div class="product__contact">
          <h2 class="text__heading">Need more information?</h2>
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

        <div class="product__downloads">
          <?php
            if  (
                  (isset($brochures) && count($brochures) > 0) ||
                  (isset($specs) && count($specs) > 0) ||
                  (isset($installs) && count($installs) > 0) ||
                  (isset($cads) && count($cads) > 0)
                ):
          ?>
          <h4 class="text__subsubheading">Downloads</h4>
          <?php endif; ?>

          <?php if (isset($brochures) && count($brochures) > 0): ?>
          <div class="product__dlitem">
            <a href="#brochures" class="product__dlbtn btn btn--cta">Brochures</a>
            <p class="product__dlnum text__line text__line--nogap"><?php echo isset($brochures) ? count($brochures) : "0"; ?> item<?php echo (isset($brochures) && (count($brochures) > 1 || count($brochures) == 0)) ? "s" : ""; ?></p>
          </div>
          <?php endif; ?>

          <?php if (isset($specs) && count($specs) > 0): ?>
          <div class="product__dlitem">
            <a href="#specs" class="product__dlbtn btn btn--cta">Technical Specifications</a>
            <p class="product__dlnum text__line text__line--nogap"><?php echo isset($specs) ? count($specs) : "0"; ?> item<?php echo (isset($specs) && (count($specs) > 1 || count($specs) == 0)) ? "s" : ""; ?></p>
          </div>
          <?php endif; ?>

          <?php if (isset($installs) && count($installs) > 0): ?>
          <div class="product__dlitem">
            <a href="#installs" class="product__dlbtn btn btn--cta">Installation Guides</a>
            <p class="product__dlnum text__line text__line--nogap"><?php echo isset($installs) ? count($installs) : "0"; ?> item<?php echo (isset($installs) && (count($installs) > 1 || count($installs) == 0)) ? "s" : ""; ?></p>
          </div>
          <?php endif; ?>

          <?php if (isset($cads) && count($cads) > 0): ?>
          <div class="product__dlitem">
            <a href="#cad" class="product__dlbtn btn btn--cta">CAD Models</a>
            <p class="product__dlnum text__line text__line--nogap"><?php echo isset($cads) ? count($cads) : "0"; ?> items<?php echo (isset($cads) && (count($cads) > 1 || count($cads) == 0)) ? "s" : ""; ?></p>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </section>

    <section class="soundproofing__main">
      <section class="soundproofing__content">
        <?php echo $this->item->text; ?>
      </section>
    </section>
  </section>
  <div class="hr"></div>
  <?php
    if (count($recommended) > 0):
  ?>
  <div class="category">
    <h3 class="text__heading">Recommended Products</h3>
    <ul class="category__items">
      <?php
        foreach ($recommendedArray as $key => $item)
        {
          $images = json_decode($item[0]->images);
          $url = getArticleURL($item[0]);

          // echo "<li class=\"category__item\">\n";
          // echo "<a href=\"{$url}\" class=\"category__link link-fill\">\n";
          // echo "<img class=\"category__image\" src=\"{$images->image_intro}\" alt=\"{$item[0]->title}\">\n";
          // echo "<p class=\"category__label text__line\">{$item[0]->title}</p>\n";
          // echo "</a>\n";
          // echo "</li>\n";

          echo "<li class=\"category__item\">\n";
            echo "<div class=\"category__imagebox\">\n";
              echo "<a href=\"" . $url ."\" class=\"category__link link-fill\">\n";
               echo "<img class=\"category__image\" src=\"" . $images->image_intro . "\" alt=\"" . htmlspecialchars($item[0]->title) . "\">\n";
              echo "</a>\n";
            echo "</div>\n";
            echo "<div class=\"category__content\">\n";
             echo "<h2 class=\"text__xsheading\">\n";
               echo htmlspecialchars($item[0]->title);
             echo "</h2>\n";
             echo "<p class=\"text__line\">\n";
              echo htmlspecialchars(json_decode($item[0]->attribs)->alternative_readmore);
            echo "</p>\n";
            echo "</div>";
            echo "<p class=\"category__label text__line\">\n";
             echo "<a href=\"" . $url ."\" class=\"category__link link-fill\">\n";
               echo "View Product";
             echo "</a>\n";
            echo "</p>\n";
          echo "</li>\n";
        }
      ?>
    </ul>
  </div>
  <?php
    endif;
  ?>
</article>
