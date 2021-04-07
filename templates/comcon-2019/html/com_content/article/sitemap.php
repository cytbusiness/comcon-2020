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
   require_once(JUri::base(true) . 'templates/comcon-2019/includes/functions/article.php');
   require_once(JUri::base(true) . 'templates/comcon-2019/includes/functions/functions.php');

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

   // Functions for this page
   function getCategoriesDeepestLevel($categories)
   {
     // Keep track of the deepest level
     $deepest = 0;

     for ($i = 0; $i < count($categories); ++$i)
     {
       $categories[$i]->level > $deepest ? $deepest = $categories[$i]->level : false;
     }

     return $deepest;
   }

   // Get the deepest menu level
   function getMenusDeepestLevel($menus)
   {
     // Keep track of the deepest level
     $deepest = 0;

     for ($i = 0; $i < count($menus); ++$i)
     {
       $menus[$i]->level > $deepest ? $deepest = $menus[$i]->level : false;
     }

     return $deepest;
   }

   // Returns the type of content the menu displays
   function getMenuView($menu)
   {
     // Get the view and id from the menu link
     $mview = preg_match('/(?<=view=)([a-zA-Z])\w+/', $menu->link, $matches);
     return $matches;
   }

   // Returns the ID of the content the menu displays
   function getMenuContentId($menu)
   {
     $mcid = preg_match('/(?<=id=)([0-9])\w+/', $menu->link, $matches);
     return $matches;
   }

   // Puts the articles into their parent categories
   function categoriseArticles($articles, &$categories)
   {
     foreach ($articles as $article)
     {
       foreach ($categories as $category)
       {
         if (!isset($category->articles))
         {
           $category->articles = array();
         }

         if ($article->catid == $category->id)
         {
           $category->articles[$article->id] = $article;
         }
       }
     }
   }

   // Returns the parent category
   function getCategoryParent($parent_id, $categories)
   {
     foreach ($categories as $category)
     {
       if ($parent_id == $category->id)
       {
         $parent = $category;
         break;
       }
     }
     return isset($parent) ? $parent : null;
   }

   // Puts categories into their parent categories
   function categoriseCategories(&$categories)
   {
     $deepest = getCategoriesDeepestLevel($categories);

     for ($i = $deepest; $i > 0; $i--)
     {
       foreach ($categories as $key => $category)
       {
         if ($category->level == $deepest)
         {
           $parent = getCategoryParent($category->parent_id, $categories);

           if (!is_null($parent))
           {
             if (!isset($parent->categories))
             {
               $parent->categories = array();
             }

             $parent->categories[$category->id] = $category;

             unset($categories[$key]);
           }
         }
       }
     }
   }

   // Put the categories into their menus
   function setMenuCategories($menus, $categories)
   {
     $deepest = getMenusDeepestLevel($menus);

     // Work from the deepest level to the shallowest
     for ($i = $deepest; $i > 0; $i--)
     {
       foreach ($menus as $menu)
       {
         // Only work with the current level
         if ($menu->level == $deepest)
         {
           foreach ($categories as $category)
           {
             // Getting the view and id of the content to match with the category
             $mview = getMenuView($menu);
             $mcid = getMenuContentId($menu);

             if ($mview[0] == "category" || $mview == "categories")
             {
               if (!isset($menu->categories))
               {
                 $menu->categories = array();
               }

               if ((int)$mcid[0] == (int)$category->id)
               {
                 // Push the category into the menu
                 $menu->categories[$category->id] = $category;
               }
             }
           }
         }
       }
     }
   }

   // Recursive print all of the content now that it has been sorted
   function printAll($items, $type)
   {
     foreach ($items as $item)
     {
        echo "<li>\n";
          // Print link by item type
          switch ($type)
          {
            case "article":
              echo "<p class=\"text__line\"><a class=\"link-text\" href=\"" . getArticleURL($item) . "\">" . $item->title . "</a></p>\n";
              break;
            case "category":
              echo "<p class=\"text__line\"><a class=\"link-text\" href=\"" .  JRoute::_(ContentHelperRoute::getCategoryRoute($item->id)) . "\">" . $item->title . "</a></p>\n";
              break;
            case "menu":
              echo "<p class=\"text__line\"><a class=\"link-text\" href=\"" .  $item->link . "\">" . $item->title . "</a></p>\n";
              break;
          }

          if (isset($item->articles))
          {
            echo "<ul class=\"text__list\">\n";
              printAll($item->articles, "article");
            echo "</ul>\n";
          }

          if (isset($item->categories))
          {
            echo "<ul class=\"text__list\">\n";
              printAll($item->categories, "category");
            echo "</ul>\n";
          }
        echo "</li>\n";
     }
   }
?>

<article class="main main--sitemap">
  <h1 class="text__title"><?php echo $this->item->title; ?></h1>
  <p class="text__line"><?php echo $attribs->alternative_readmore; ?></p>

  <?php
    $query = $db->getQuery(true);

    $query
      ->select($db->quoteName('a.id'))
      ->select($db->quoteName('a.catid'))
      ->select($db->quoteName('a.title'))
      ->from($db->quoteName('#__content', 'a'))
      ->where($db->quoteName('a.state') . ' = 1;');

    $db->setQuery($query);

    $articles = $db->loadObjectList();

    $query = $db->getQuery(true);

    $query
      ->select($db->quoteName('b.id'))
      ->select($db->quoteName('b.title'))
      ->select($db->quoteName('b.level'))
      ->select($db->quoteName('b.parent_id'))
      ->from($db->quoteName('#__categories', 'b'))
      // Filter out the ROOT and uncategorised
      ->where($db->quoteName('b.id') . ' != 1')
      //->where($db->quoteName('b.title') . ' != "Uncategorised"')
      ->where($db->quoteName('b.published') . ' = 1;');

    $db->setQuery($query);

    $categories = $db->loadObjectList();

    $query = $db->getQuery(true);

    $query
      ->select($db->quoteName('c.id'))
      ->select($db->quoteName('c.title'))
      ->select($db->quoteName('c.path'))
      ->select($db->quoteName('c.link'))
      ->select($db->quoteName('c.level'))
      ->from($db->quoteName('#__menu', 'c'))
      // Filter out the ROOT
      ->where($db->quoteName('c.id') . ' != 1')
      // Filter out Joomla component menus
      ->where($db->quoteName('c.title') . ' NOT LIKE "%com_%"')
      ->where($db->quoteName('c.published') . ' = 1;');

    $db->setQuery($query);

    $menus = $db->loadObjectList();
  ?>

  <ul class="text__list">
  <?php
    categoriseArticles($articles, $categories);
    categoriseCategories($categories);
    setMenuCategories($menus, $categories);

    printAll($menus, "menu");
  ?>
  </ul>
</article>
