<?php
  /**
   * @package     Commercial Connections 2019
   * @subpackage  com_content
   *
   * @copyright   Copyright (C) 2019 Commercial Connections Ltd. All rights reserved.
   */

   defined('_JEXEC') or die;

   if ($this->maxLevelcat != 0 && count ($this->items[$this->parent->id]) > 0)
   {
     // echo "<ul class=\"category__items\">\n";
     // foreach ($this->items[$this->parent->id] as $id => $item)
     // {
     //   // Only create the link if there's something to display
     //   if ($item->numitems > 0)
     //   {
     //     echo "<li class=\"category__item\">\n";
     //     echo "<a href=\"" . JRoute::_(ContentHelperRoute::getCategoryRoute($item->id)) ."\" class=\"category__link link-fill\">\n";
     //     echo "<img class=\"category__image\" src=\"" . $item->getParams()->get('image') . "\" alt=\"" . htmlspecialchars($item->getParams()->get('image_alt')) . "\">\n";
     //     echo "<p class=\"category__label text__line\">" . $this->escape($item->title) . "</p>\n";
     //     echo "</a>\n";
     //     echo "</li>\n";
     //   }
     // }
     // echo "</ul>";

     echo "<ul class=\"category__items\">\n";
     foreach ($this->items[$this->parent->id] as $id => $item)
     {
       // Only create the link if there's something to display
       if ($item->numitems > 0)
       {
         echo "<li class=\"category__item\">\n";
           echo "<div class=\"category__imagebox\">\n";
             echo "<a href=\"" . JRoute::_(ContentHelperRoute::getCategoryRoute($item->id)) ."\" class=\"category__link link-fill\">\n";
              echo "<img class=\"category__image\" src=\"" . $item->getParams()->get('image') . "\" alt=\"" . htmlspecialchars($item->getParams()->get('image_alt')) . "\">\n";
             echo "</a>\n";
           echo "</div>\n";
           echo "<div class=\"category__content\">\n";
            echo "<h2 class=\"text__xsheading\">\n";
              echo $this->escape($item->title);
            echo "</h2>\n";
            echo $item->description;
           echo "</div>";
           echo "<p class=\"category__label text__line\">\n";
            echo "<a href=\"" . JRoute::_(ContentHelperRoute::getCategoryRoute($item->id)) ."\" class=\"category__link link-fill\">\n";
              echo "View Category";
            echo "</a>\n";
           echo "</p>\n";
         echo "</li>\n";
       }
     }
     echo "</ul>";
   }
?>
