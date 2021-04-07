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
   $applink = "<script type=\"module\">import {stringsBase, stringsCollage, stringsDownloads, stringsFullscreen, stringsProduct, collage, downloads} from \"" . $dir . "js/comcon/init.js\"; collage.init([[stringsBase, stringsCollage, stringsFullscreen], 2, stringsCollage.collageProject]);</script>";
   $doc->addCustomTag($applink);
?>

<article class="main main--project">
  <section class="project">
    <header class="header">
      <div class="header__text">
        <h1 class="text__title"><?php echo $this->item->title; ?></h1>
        <p class="text__line"><?php echo $attribs->alternative_readmore; ?></p>
      </div>
    </header>
    <section class="project__top">
      <div class="collage collage--project">
        <div class="collage__items">
          <?php

            // Only make the first 2 items visible
            $count = 0;
            if (!empty($gallery))
            {
              foreach ($gallery->gallery_image as $key => $val)
              {
                if ($count < 2)
                {
                  // Output the images to the gallery
                  //echo $key . "<br>" . $val . "<br>" . $gallery->gallery_image_alt[$key] . "<br>" . $gallery->gallery_image_description[$key] . "<br><br>";
                  $url = $val;
                  $alt = $gallery->gallery_image_alt[$key];
                  $title = $gallery->gallery_image_title[$key];
                  $desc = $gallery->gallery_image_description[$key];

                  echo "<a href=\"$url\" class=\"collage__item collage__item--visible link\"><img src=\"$val\" alt=\"$alt\" title=\"$title\" data-text=\"$desc\" class=\"collage__image\"></a>";
                  $count++;
                }
                else
                {
                  $url = $val;
                  $alt = $gallery->gallery_image_alt[$key];
                  $title = $gallery->gallery_image_title[$key];
                  $desc = $gallery->gallery_image_description[$key];

                  echo "<a href=\"$url\" class=\"collage__item collage__item link\"><img src=\"$val\" alt=\"$alt\" title=\"$title\" data-text=\"$desc\" class=\"collage__image\"></a>";
                  $count++;
                }
              }
            }
          ?>
        </div>
      </div>
    </section>

    <section class="project__main">
      <section class="project__content">
        <?php echo $this->item->text; ?>
      </section>

      <aside class="aside aside--project">
        <section class="aside__section aside__section--featured">
          <?php
            // Find products associated with this project
            $query = $db->getQuery(true);

            // Get all products
            $query
              ->select('DISTINCT' . $db->quoteName('a.id'))
              ->select($db->quoteName('a.title'))
              ->select($db->quoteName('a.catid'))
              ->select($db->quoteName('a.metadata'))
              ->select($db->quoteName('a.images'))
              ->select($db->quoteName('a.attribs'))
              ->from($db->quoteName('#__content', 'a'))
              ->join('INNER', $db->quoteName('#__categories', 'b') . ' ON ' . $db->quoteName('a.catid') . ' = ' . $db->quoteName('b.id') . ' AND ' . $db->quoteName('b.parent_id') . ' = ' . ' 10 ' . ' OR ' . $db->quoteName('b.parent_id') . ' = ' . '11;');

            $db->setQuery($query);

            $results = $db->loadObjectList();

            // Array to store what products are used in this project
            $featuredProducts = [];

            foreach($results as $result)
            {
              $resultMeta = json_decode($result->metadata);

              if (!empty($resultMeta))
              {
                $resultFeatured = isset($resultMeta->featured_projects) ? json_decode($resultMeta->featured_projects) : null;
                $resultFeaturedItems = (isset($resultFeatured) && count($resultFeatured->featured_projects_item) > 0) ? $resultFeatured->featured_projects_item : [];

                // We'll keep this product if the id matches with this project's id
                if (isset($resultFeaturedItems) && count($resultFeaturedItems) > 0)
                {
                  if (in_array($this->item->id, $resultFeaturedItems))
                  {
                    array_push($featuredProducts, $result);
                  }
                }
              }
            }

            if (count($featuredProducts) > 0)
            {
              echo "<h4 class=\"text__subsubheading\">Featured Products</h4>\n";
              foreach($featuredProducts as $product)
              {
                $url = getArticleURL($product);

                $productImages   = json_decode($product->images);
                $productAttribs  = json_decode($product->attribs);

                echo "<div class=\"aside-module\">\n";
                echo "<img src=\"" . $productImages->image_intro . "\" alt=\"" . $product->title . "\" class=\"aside-module__image\">\n";
                echo "<div class=\"aside-module__text\">\n";
                echo "<h5 class=\"text__xsheading\"><a href=\"" . $url . "\" class=\"link-text\">" . $product->title . "</a></h5>\n";
                echo "<p class=\"text__line text__line--small\">" . $productAttribs->alternative_readmore . "</p>\n";
                echo "</div>\n";
                echo "</div>\n";
              }
            }
          ?>
        </section>
      </aside>
    </section>
  </section>
</article>
