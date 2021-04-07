<?php
  /**
   * @package     Commercial Connections 2019
   * @subpackage  com_content
   *
   * @copyright   Copyright (C) 2019 Commercial Connections Ltd. All rights reserved.
   */

   // AJAX Search //
   if (isset($_POST["search"]))
   {
     if (!defined('DS')) { define('DS', DIRECTORY_SEPARATOR); }
     require_once(dirname(__FILE__) . DS . '..' . DS. '..' . DS . '..' . DS . 'includes/functions/search.php');
     require_once(dirname(__FILE__) . DS . '..' . DS. '..' . DS . '..' . DS . 'includes/functions/article.php');
     require_once(dirname(__FILE__) . DS . '..' . DS. '..' . DS . '..' . DS . 'includes/functions/downloads.php');

     $results = searchDownloads("search");

     if (!empty($results))
     {
       foreach($results as $key => $result)
       {
         printDownload("result", $result);
       }
     }

     exit;
   }

   defined('_JEXEC') or die;

   JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

   $doc = JFactory::getDocument();
   $dir = JUri::base() . 'templates/comcon-2019/';

   // Get the DB object so we can operate with it later
   $db = JFactory::getDbo();

   // Paramter variables
   $params    = $this->item->params;
   $images    = json_decode($this->item->images);
   $urls      = json_decode($this->item->urls);
   $canEdit   = $params->get('access-edit');
   $user      = JFactory::getUser();
   $info      = $params->get('info_block_position', 0);
   $attribs   = json_decode($this->item->attribs);

   // Reference vars
   $productCategories = array(11,19);

   // Custom functions //
   require_once(JPATH_ROOT . '/' . 'templates/comcon-2019/includes/functions/article.php');
   require_once(JPATH_ROOT . '/' . 'templates/comcon-2019/includes/functions/downloads.php');
   require_once(JPATH_ROOT . '/' . 'templates/comcon-2019/includes/functions/search.php');
?>

<article class="main main--downloads">
  <h1 class="text__title"><?php echo $this->item->title; ?></h1>
  <section class="dlpage">
    <section class="dlpage__content">
      <?php echo JHtml::_('content.prepare', $this->item->introtext); ?>
    </section>
    <form action="<?php echo JUri::getInstance(); ?>" class="dlpage__form" method="post">
      <div class="dlpage__filters">
        <div class="dlpage__dropdowns">
          <select name="dlcategory" id="dlcategory" class="dlpage__select">
            <option value="">All Categories</option>
            <?php
              foreach ($productCategories as $productCategory)
              {
                $query = $db->getQuery(true);

                $query
                  ->select($db->quoteName('a.id'))
                  ->select($db->quoteName('a.title'))
                  ->from($db->quoteName('#__categories', 'a'))
                  ->where($db->quoteName('a.published') . ' = 1')
                  ->where($db->quoteName('a.parent_id') . ' = ' . $productCategory . ';');

                $db->setQuery($query);

                $results = $db->loadObjectList();

                foreach($results as $result)
                {
                  echo "<option value=\"{$result->id}\">{$result->title}</option>\n";
                }
              }
            ?>
          </select>
        </div>
        <div class="dlpage__submit">
          <input id="search" type="search" class="dlpage__search" placeholder="Search Downloads">
          <!--<input type="submit" value="Search" id="submit" class="dlpage__btnsubmit">-->
        </div>
      </div>
    </form>

    <section id="list" class="dlpage__results">
      <?php
        foreach ($productCategories as $productCategory) :
      ?>

      <?php
        $catArray = [];

        // Get all product categories, so we can get the articles from them
        $query = $db->getQuery(true);
        $query
          ->select($db->quoteName('a.id'))
          ->select($db->quoteName('a.title'))
          ->from($db->quoteName('#__categories', 'a'))
          ->where($db->quoteName('a.parent_id') . ' = ' . $productCategory . ";");

        $db->setQuery($query);

        $results = $db->loadObjectList();

        foreach ($results as $key => $val)
        {
          $catArray[$val->id] = $val->title;
        }

        foreach ($catArray as $key => $cat) :
      ?>
      <div data-catid="<?php echo $key; ?>" class="dlpage__downloads">
        <?php
          $articleArray = [];
          // Get all articles from this category
          $query = $db->getQuery(true);
          $query
            ->select($db->quoteName('a.id'))
            ->select($db->quoteName('a.catid'))
            ->select($db->quoteName('a.title'))
            ->select($db->quoteName('a.images'))
            ->select($db->quoteName('a.attribs'))
            ->select($db->quoteName('a.metadata'))
            ->select($db->quoteName('a.ordering'))
            ->from($db->quoteName('#__content', 'a'))
            ->where($db->quoteName('a.catid') . ' = ' . $key . ' ')
            ->order('a.ordering ASC');

          $db->setQuery($query);

          $results = $db->loadObjectList();

          foreach ($results as $result)
          {
            array_push($articleArray, $result);
          }

        ?>
        <?php

          // Only display the title if there are corresponding articles
          // in the category
          $showTitle = false;

          // Go through each article to look for downloads
          foreach ($articleArray as $key => $article)
          {
            $downloads = getDownloads($article);

            if ($showTitle == false && (count($downloads->brochures) > 0 || count($downloads->specs) > 0 || count($downloads->installs) > 0 || count($downloads->cads) > 0))
            {
              $showTitle = true;
            }
          }
        ?>
        <?php if ($showTitle): ?>
          <h3 class="text__heading"><?php echo $cat; ?></h3>
        <?php endif; ?>
          <?php if (count($articleArray) > 0): ?>
        <?php

          foreach ($articleArray as $key => $article) :
        ?>
        <?php
          $images   = json_decode($article->images);
          $attribs  = json_decode($article->attribs);

          $downloads = getDownloads($article);

          if ($downloads !== null) :
        ?>
        <?php
          if (!empty($downloads->brochures) || !empty($downloads->specs) || !empty($downloads->brochures) || !empty($downloads->cads)) :
        ?>
        <?php printDownload("list", $article); ?>
        <?php endif; ?>
        <?php endif; ?>
        <?php endforeach; ?>
        <?php else: ?>
        <?php endif; ?>
      </div>
      <?php endforeach; ?>
      <?php endforeach; ?>
      <section class="dlpage__downloads--search">
        <h3 class="text__heading">Search Results</h3>
        <div id="result" class="dlpage__downloads">

        </div>
      </section>
    </section>
  </section>
</article>
<script type="text/javascript">
  // AJAX request for download search
  $(document).ready(function()
  {
    // Stop the form from submitting by default when using AJAX
    $(".dlpage__form").submit(function(e)
    {
      e.preventDefault();
    });

    $("#dlcategory").change(function()
    {
      // Get the current value from the dropdown, to match with the download elements
      var val = $(this).val();

      if (val != "")
      {
        $(".dlpage__downloads").each(function()
        {
          // Skip the search results
          if (!($(this).is("#result")))
          {
            if ($(this).data("catid") != val)
            {
              $(this).css("display", "none");
            }
            else if ($(this).data("catid") == val)
            {
              $(this).css("display", "block");
            }
          }
        });
      }
      else
      {
        $(".dlpage__downloads").each(function()
        {
          $(this).css("display", "block");
        });
      }
    });

    $("#search").on("keydown", function(e)
    {
      var search = $("#search").val();

      if (search.length >= 3)
      {
        $.ajax(
          {
            url: "<?php echo $dir . "html/com_content/article/downloads.php"?>",
            data: {search: search},
            type: "POST",
            success: function(data)
            {
              $("#result").html(data);
            },
            error: function(xhr, status, error)
            {
              $("#result").text(xhr.responseText);
            }
          }
        );

        if ($("#result").children("dl-result").length > 0)
        {
          if (!($("#result").hasClass("dlpage__downloads--search")))
          {
            $("#result").addClass("dlpage__downloads--search");
          }
        }
        else
        {
          if ($("#result").hasClass("dlpage__downloads--search"))
          {
            $("#result").removeClass("dlpage__downloads--search");
          }
        }
      }
      else
      {
        $("#result").empty();
      }
    });
  });
</script>
