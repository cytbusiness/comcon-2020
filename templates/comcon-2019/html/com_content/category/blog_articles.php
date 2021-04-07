<?php
  /**
   * @package     Commercial Connections 2019
   * @subpackage  com_content
   *
   * @copyright   Copyright (C) 2019 Commercial Connections Ltd. All rights reserved.
   */

   defined('_JEXEC') or die;

   // Property shortcuts
   $params      = &$this->item->params;
   $n           = count($this->items);
   $listOrder   = $this->escape($this->state->get('list.ordering'));
   $listDir     = $this->escape($this->state->get('list.direction'));
   $langFilter  = false;

   $root = $_SERVER["REQUEST_URI"];
?>

<?php

  if (empty($this->items))
  {
    if ($this->params->get('show_no_articles', 1))
    {
      echo "<p class=\"text__line\">No articles in this category.</p>";
    }
  }
  else
  {
    // Store the items so we can manipulate them after
    $articleArray = [];

    foreach ($this->items as $i => $article)
    {
      array_push($articleArray, $article);
    }

    // Split the articles into chunks so we can paginate them
    $counter = 0;
    $articleChunks = [];

    for ($i = 0; $i < count($articleArray); ++$i)
    {
      if (($i % 8) != 0)
      {
        if (!isset($articleChunks[$counter]) || empty($articleChunks[$counter]))
        {
          $articleChunks[$counter] = [];
          $articleChunks[$counter] += array($i => $articleArray[$i]);
        }
        else
        {
          $articleChunks[$counter] += array($i => $articleArray[$i]);
        }
      }
      else
      {
        ++$counter;
        $articleChunks[$counter] = [];
        $articleChunks[$counter] += array($i => $articleArray[$i]);
      }
    }

    // Now that we've split the articles into chunks, we can print them out - by page
    function printArticles($articleChunks, $page)
    {
      foreach ($articleChunks[$page] as $key => $article)
      {
        printBlog($article);
      }
    }

    echo "<ul id=\"items\" class=\"category__items\">\n";
      // Check what page we're on - if no page set, it's the first page
      isset($_GET["page"]) && !empty($_GET["page"]) ? $page = htmlspecialchars($_GET["page"]) : $page = 1;
      printArticles($articleChunks, $page);
    echo "</ul>";

    // What page is previous and next?
    $pagePrev = (($page - 1) > 0 ? ($page - 1) : 1);
    $pageNext = (($page + 1) <= count($articleChunks) ? ($page + 1) : count($articleChunks));

    if (count($articleChunks) > 1)
    {
      echo "<div class=\"pagination\">\n";
      echo "<div class=\"pagination__controls\">\n";
      echo "<a rel=\"prev\" data-pagination=\"". $pagePrev . "\"href=\"" . $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] . explode("?", $_SERVER["REQUEST_URI"], 2)[0] . "?page=" . $pagePrev . "\" class=\"pagination__btn pagination__btn--left\"></a>\n";
      echo "<p class=\"pagination__pages text__line tex__line--min\">\n";
      echo "<span class=\"pagination__page\">" . $page . "</span> of <span class=\"pagination__page\">" . count($articleChunks) . "</span>\n";
      echo "</p>\n";
      echo "<a rel=\"next\" data-pagination=\"". $pageNext . "\"href=\"" . $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] . explode("?", $_SERVER["REQUEST_URI"], 2)[0] . "?page=" . $pageNext . "\" class=\"pagination__btn pagination__btn--right\"></a>\n";
      echo "</div>\n";
      echo "</div>\n";
    }
  }
?>
