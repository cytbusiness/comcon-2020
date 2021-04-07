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

   // Get downloads
   $downloads = getDownloads($this->item);

  // Setting constituent downloads so we can access them later
   $brochures       = $downloads->brochures;
   $brochure_titles = $downloads->brochure_titles;
   $brochure_types  = $downloads->brochure_types;
   $specs           = $downloads->specs;
   $specs_titles    = $downloads->specs_titles;
   $specs_types     = $downloads->specs_types;
   $installs        = $downloads->installs;
   $installs_titles = $downloads->installs_titles;
   $installs_types  = $downloads->specs_types;
   $cads            = $downloads->cads;
   $cads_titles     = $downloads->cads_titles;

   // Remove downloads from meta tags
   $doc->setMetaData('downloads_brochures', null);
   $doc->setMetaData('downloads_specs', null);
   $doc->setMetaData('downloads_installs', null);
   $doc->setMetaData('featured_projects', null);

   // Open Graph meta tags
   $doc->setMetaData('og:title', $this->item->title);
   $doc->setMetaData('og:type', "article");
   $doc->setMetaData('og:description', $this->item->metadesc);
   isset($gallery->gallery_image_alt[0]) ? $doc->setMetaData('og:image', rootUrl() . '/' . $gallery->gallery_image[0]) : null;
   isset($gallery->gallery_image_alt[0]) ? $doc->setMetaData('og:image:alt', $gallery->gallery_image_alt[0]) : null;

   $query = $db->getQuery(true);

   // Get category name
   $query
    ->select($db->quoteName('a.title'))
    ->from($db->quoteName('#__categories', 'a'))
    ->where($db->quoteName('a.id') . ' = ' . $this->item->catid . ";")
    ->limit(1);

   $db->setQuery($query);

   $catname = $db->loadObjectList();

   $jsonldService = '
                      <script type="application/ld+json">
                        {
                          "@context": "http://schema.org",
                          "@type": "Service",
                          "serviceType": "' . $this->item->title . '",
                          "category": "' . $catname[0]->title . '"
                        }
                      </script>
                    ';
  $doc->addCustomTag($jsonldService);
?>

<article class="main main--product">
  <h1 class="text__title"><?php echo $this->item->title; ?></h1>
  <p class="text__line"><?php echo $attribs->alternative_readmore; ?></p>
  <section class="product">
    <section class="product__top">
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
          <h2 class="text__heading">Contact us about this service</h2>
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

    <section class="product__main">
      <section class="product__content">
        <?php echo $this->item->text; ?>
      </section>

      <aside class="aside aside--product">
        <?php
          $featuredSet = isset($meta->featured_projects) ? json_decode($meta->featured_projects) : null;

          // IDs of the articles to appear in the featured project section
          $featured = (isset($featuredSet) && count($featuredSet->featured_projects_item) > 0) ? $featuredSet->featured_projects_item : [];
        ?>
        <?php if (isset($featured) && count($featured) > 0): ?>
        <section class="aside__section aside__section--featured">
          <h4 class="text__subsubheading">Featured Projects</h4>

          <?php
            // Store the results
            $featuredArray = [];

            foreach ($featured as $key => $id)
            {
              $query = $db->getQuery(true);
              $query
                ->select($db->quoteName('a.id'))
                ->select($db->quoteName('a.catid'))
                ->select($db->quoteName('a.title'))
                ->select($db->quoteName('a.attribs'))
                ->select($db->quoteName('a.images'))
                ->from($db->quoteName('#__content', 'a'))
                ->where($db->quoteName('a.id') . ' = ' . $id . ';');

              $db->setQuery($query);

              $results = $db->loadObjectList();

              array_push($featuredArray, $results);
            }

            for ($i = 0; $i < 3; ++$i)
            {
              $item     = $featuredArray[$i][0];

              // Get link to the article
              $rootURL    = rtrim(JURI::base(), '/');
              $subpathURL = JURI::base(true);

              if (!empty($subpathURL) && $subpathURL != '/')
              {
                $rootURL = substr($rootURL, 0, -1 * strlen($subpathURL));
              }
              $url = $rootURL . JRoute::_(ContentHelperRoute::getArticleRoute($item->id, $item->catid));

              $images   = json_decode($item->images);
              $attribs  = json_decode($item->attribs);

              echo "<div class=\"aside-module\" itemscope itemtype=\"https://schema.org/Article\">\n";
              echo "<img src=\"" . $images->image_intro . "\" alt=\"" . $item->title . "\" class=\"aside-module__image\" itemprop=\"image\">\n";
              echo "<div class=\"aside-module__text\">\n";
              echo "<h5 class=\"text__xsheading\" itemprop=\"name\"><a href=\"" . $url . "\" class=\"link-text\" itemprop=\"relatedLink\">" . $item->title . "</a></h5>\n";
              echo "<p class=\"text__line text__line--small\" itemprop=\"headline\">" . $attribs->alternative_readmore . "</p>\n";
              echo "</div>\n";
              echo "</div>\n";
            }
          ?>
        </section>
        <?php endif; ?>

        <?php

          // Store the results so we can compare them to rank results
          $resultsArray = [];

          // Get articles with the same tag
          foreach ($this->item->tags->itemTags as $tag)
          {
            $query = $db->getQuery(true);
            $query
              ->select($db->quoteName('a.id'))
              ->select($db->quoteName('a.catid'))
              ->select($db->quoteName('a.title'))
              ->select($db->quoteName('a.attribs'))
              ->select($db->quoteName('a.images'))
              ->select($db->quoteName('b.tag_id'))
              ->from($db->quoteName('#__content', 'a'))
              ->join('INNER', $db->quoteName('#__contentitem_tag_map', 'b') . ' ON ' . $db->quoteName('a.id') . ' = ' . $db->quoteName('b.content_item_id'))
              ->where($db->quoteName('b.tag_id') . ' = ' . $tag->tag_id)
              ->where($db->quoteName('a.id') . ' != ' . $this->item->id)
              ->where($db->quoteName('a.catid') . ' = ' .  $this->item->catid)
              // Limit to 10 relevant articles
              ->setLimit('10')
              ->order('uuid()');

            // $query->select($db->quoteName(array('content_item_id')));
            // $query->from($db->quoteName('flrob_contentitem_tag_map'));
            // $query->where($db->quoteName('tag_id') . ' = ' . $tag->tag_id);

            $db->setQuery($query);

            $results = $db->loadObjectList();

            // Push the results into the array for comparison
            $resultsArray[$tag->tag_id] = $results;
          }

          // Adding results to an array so we can see if there's any duplicates.
          // if there are duplicates, we give them more weight to appear higher
          // in the order
          $idArray = [];

          foreach ($resultsArray as $result)
          {
            if (!(empty($result)))
            {
              foreach ($result as $item)
              {
                $newArray = array("id" => $item->id, "count" => 1);
                array_push($idArray, $newArray);
              }
            }
          }

          // Count duplicates
          for ($i = 0; $i < count($idArray); ++$i)
          {
            // Loop through the array again
            for ($j = 0; $j < count($idArray); ++$j)
            {
              // Ignore the current item
              if ($j != $i)
              {
                // Found a match?
                if ($idArray[$j]["id"] == $idArray[$i]["id"])
                {
                  $idArray[$i]["count"]++;
                }
              }
            }
          }

          // Remove duplicates
          foreach ($idArray as $key => $item)
          {
            // Loop through again
            foreach ($idArray as $jkey => $jtem)
            {
              // Ignore the current item
              if ($jkey == $key)
              {
                break;
              }
              else
              {
                if ($jtem["id"] == $item["id"])
                {
                  unset($idArray[$jkey]);
                }
              }
            }
          }

          // Sort array based on which article has the highest count
          function sortByOrder($a, $b)
          {
            return $b["count"] - $a["count"];
          }
          usort($idArray, 'sortByOrder');
        ?>
        <?php if (count($resultsArray) > 0): ?>
        <section class="aside__section aside__section--featured">
          <h4 class="text__subsubheading">Related Products</h4>
          <?php

          // Limit to first two relevant articles
          $counter = 0;

          // Print out the articles now that we've sorted them
          foreach ($resultsArray as $key => $set)
          {
            // Loop through each result set
            foreach ($set as $ikey => $item)
            {
              foreach ($idArray as $idkey => $iditem)
              {
                if ($counter < 2)
                {
                  // Does the article match?
                  if ($item->id == $iditem["id"])
                  {
                    // Get link to the article
                    $rootURL    = rtrim(JURI::base(), '/');
                    $subpathURL = JURI::base(true);

                    if (!empty($subpathURL) && $subpathURL != '/')
                    {
                      $rootURL = substr($rootURL, 0, -1 * strlen($subpathURL));
                    }
                    $url = $rootURL . JRoute::_(ContentHelperRoute::getArticleRoute($item->id, $item->catid));

                    $attr   = json_decode($item->attribs);
                    $img    = json_decode($item->images);

                    // Print out the article
                    echo "<div class=\"aside-module\" itemscope itemtype=\"https://schema.org/Article\">\n";
                    echo "<img src=\"" . $img->image_intro . "\" class=\"aside-module__image\" alt=\"" . $item->title . "\" itemprop=\"image\">\n";
                    echo "<div class=\"aside-module__text\">\n";
                    echo "<h5 class=\"text__xsheading\" itemprop=\"name\"><a href=\"" . $url . "\" class=\"link-text\" itemprop=\"relatedLink\">" . $item->title . "</a></h5>\n";
                    echo "<p class=\"text__line text__line--small\" itemprop=\"headline\">" . $attr->alternative_readmore . "</p>\n";
                    echo "</div>\n";
                    echo "</div>\n";

                    // We've got the article, don't need to search for it again
                    unset($idArray[$idkey]);

                    $counter++;
                  }
                }
              }
            }
          }

          ?>
        </section>
        <?php endif; ?>
      </aside>
    </section>
  </section>

  <?php if (!empty($brochures) || !empty($specs) || !empty($installs) || !empty($cads)) : ?>

  <h3 class="downloads__title text__heading">Downloads</h3>
  <?php if (!empty($brochures)) : ?>
  <div id="brochures" class="downloads">
    <h4 class="downloads__title text__subheading">Product Brochures</h4>
    <ul class="downloads__items">
      <?php

        for ($i = 0; $i < count($brochures); ++$i)
        {
          echo "<li class=\"downloads__item\">\n";
          echo "<a href=\"" . $brochures[$i] . "\" class=\"downloads__link\" target=\"_blank\">\n";
          echo "<div class=\"downloads__icon\">\n";
          echo "<div class=\"downloads__icontext\">" . getDownloadExt($brochures[$i]) . "</div>\n";
          echo "</div>\n";
          echo "<div class=\"downloads__itemtext\">\n";
          echo "<p class=\"downloads__linktext text__cta\">" . $brochure_titles[$i] . "</p>\n";
          echo "<p class=\"downloads__filesize text__cta\">" . getFileSize($brochures[$i]) . "</p>\n";
          echo "</div>\n";
          echo "</a>\n";
          echo "</li>\n";
        }

      ?>
    </ul>
  </div>
  <?php endif; ?>

  <?php if (!empty($specs)) : ?>
  <div id="specs" class="downloads">
    <h4 class="downloads__title text__subheading">Technical Specifications</h4>
    <ul class="downloads__items">
      <?php

        for ($i = 0; $i < count($specs); ++$i)
        {
          echo "<li class=\"downloads__item\">\n";
          echo "<a href=\"" . $specs[$i] . "\" class=\"downloads__link link-fill\" target=\"_blank\">\n";
          echo "<div class=\"downloads__icon\">\n";
          echo "<div class=\"downloads__icontext\">" . getDownloadExt($specs[$i]) . "</div>\n";
          echo "</div>\n";
          echo "<p class=\"downloads__linktext text__cta\">" . $specs_titles[$i] . "</p>\n";
          echo "</a>\n";
          echo "<p class=\"downloads__filesize text__cta\">" . getFileSize($specs[$i]) . "</p>\n";
          echo "</li>\n";
        }

      ?>
    </ul>
  </div>
  <?php endif ?>

  <?php if (!empty($installs)) : ?>
  <div id="installs" class="downloads">
    <h4 class="downloads__title text__subheading">Installation Guides</h4>
    <ul class="downloads__items">
      <?php

        for ($i = 0; $i < count($installs); ++$i)
        {
          echo "<li class=\"downloads__item\">\n";
          echo "<a href=\"" . $installs[$i] . "\" class=\"downloads__link link-fill\" target=\"_blank\">\n";
          echo "<div class=\"downloads__icon\">\n";
          echo "<div class=\"downloads__icontext\">" . getDownloadExt($installs[$i]) . "</div>\n";
          echo "</div>\n";
          echo "<p class=\"downloads__linktext text__cta\">" . $installs_titles[$i] . "</p>\n";
          echo "</a>\n";
          echo "<p class=\"downloads__filesize text__cta\">" . getFileSize($installs[$i]) . "</p>\n";
          echo "</li>\n";
        }

      ?>
    </ul>
  </div>
  <?php endif; ?>

  <?php if (!empty($cads)) : ?>
  <div id="cad" class="downloads">
    <h4 class="downloads__title text__subheading">CAD Models</h4>
    <ul class="downloads__items">
      <?php

        for ($i = 0; $i < count($cads); ++$i)
        {
          echo "<li class=\"downloads__item\">\n";
          echo "<a href=\"" . $cads[$i] . "\" class=\"downloads__link link-fill\" target=\"_blank\">\n";
          echo "<div class=\"downloads__icon\">\n";
          echo "<div class=\"downloads__icontext\">" . getDownloadExt($cads[$i]) . "</div>\n";
          echo "</div>\n";
          echo "<p class=\"downloads__linktext text__cta\">" . $cads_titles[$i] . "</p>\n";
          echo "</a>\n";
          echo "<p class=\"downloads__filesize text__cta\">" . getFileSize($cads[$i]) . "</p>\n";
          echo "</li>\n";
        }

      ?>
    </ul>
  </div>
  <?php endif; ?>
  <?php endif; ?>
</article>
