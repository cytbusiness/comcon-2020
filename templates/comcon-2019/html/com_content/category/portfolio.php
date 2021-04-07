<?php
  /**
   * @package     Commercial Connections 2019
   * @subpackage  com_content
   *
   * @copyright   Copyright (C) 2019 Commercial Connections Ltd. All rights reserved.
   */

  defined('_JEXEC') or die;

  $app            = JFactory::getApplication();
  $templateParams = $app->getTemplate(true)->params;

  // Get the DB object so we can operate with it later
	$db = JFactory::getDbo();

  $query = $db->getQuery(true);

  $query
    ->select($db->quoteName('a.params'))
    ->from($db->quoteName('#__categories', 'a'))
    ->where($db->quoteName('a.id') . ' = ' . $this->category->id)
    ->setLimit('1');

  $db->setQuery($query);

  $result = $db->loadObjectList();

  $image = json_decode($result[0]->params)->image;

  JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

  $showCategoryHeadingTitleText = $this->params->get('show_category_heading_title_text', 1) == 1;

  // Custom functions //
  require_once(JPATH_ROOT . '/' . 'templates/comcon-2019/includes/functions/article.php');

  // Add canonical link to page for SEO
  $doc = JFactory::getDocument();
  // URL
  $href = $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] . explode("?", $_SERVER["REQUEST_URI"], 2)[0];
  // Set array for attributes
  $attribs = array('type' => 'text/html');
  // Add to head of document
  $doc->addHeadLink($href, 'canonical', 'rel', $attribs);
?>
<?php
  if ($showPageHeading = $this->params->get('show_page_heading'))
  {
    echo "<div class=\"hero\">\n";
      echo "<div class=\"hero__content\">";
        echo "<header class=\"hero__texts\">\n";
          echo "<h1 class=\"text__title\">" . $this->escape($this->params->get('page_heading')) . "</h1>";
          if ($this->params->get('show_description', 1))
          {
            echo $this->category->description;
          }
        echo "</header>\n";
      echo "</div>";
    echo "</div>\n";
  }
?>
<main class="main <?php echo $this->pageclass_sfx; ?>">
  <?php

  if ($this->params->get('show_featured') == "show")
  {
    // Get featured products from this category to highlight at the top.
    $featuredArray = [];
    foreach ($this->items as $item)
    {
      if (isset($item->featured) && (!empty($item->featured)))
      {
        if ($item->featured == 1)
        {
          array_push($featuredArray, $item);
        }
      }
    }
    if (count($featuredArray) > 0)
    {
      echo "<div class=\"category-featured\">\n";
      if (!empty($this->params->get('page_subheading')))
      {
        echo "<h2 class=\"text__heading\">" . $this->params->get('page_subheading') . "</h2>\n";
      }
      echo "<div class=\"category\">\n";
      echo "<ul id=\"featured\" class=\"category__items\">\n";
      // Only print out 3 featured articles
      for ($i = 0; $i < 3; ++$i)
      {
        printArticle($featuredArray[$i], "View Project");
      }
      echo "</ul>\n";
      echo "</div>\n";
      echo "</div>\n";
      echo "<div class=\"hr\"></div>\n";
    }
  }

  ?>
  <div class="category category--portfolio">
    <?php echo $this->loadTemplate('projects'); ?>
  </div>

</main>
