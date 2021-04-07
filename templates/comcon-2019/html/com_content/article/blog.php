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
?>

<article class="main main--blog" itemscope itemtype="https://schema.org/Article">
  <h1 class="text__title" itemprop="name"><?php echo $this->item->title; ?></h1>
  <p class="text__line" itemprop="headline"><?php echo $attribs->alternative_readmore; ?></p>
  <?php
    $date = new DateTime($this->item->created);
  ?>
  <p class="text__line">
    <time datetime="<?php echo $date->format('Y-m-d'); ?>" itemprop="datePublished"><?php echo $date->format('d F Y'); ?></time>
  </p>
  <?php
    if (isset($images->image_intro)) :
  ?>
  <div class="hr"></div>
  <div class="blog-hero" style="background-image: url('<?php echo JUri::base() . $images->image_intro; ?>')" itemprop="image"></div>
  <p class="text__line"><i><?php echo $images->image_intro_caption; ?></i></p>
  <div class="hr"></div>
  <?php
    endif;
  ?>
  <section class="blog" itemprop="mainEntityOfPage">
    <section class="blog__content" itemprop="articleSection">
      <?php echo $this->item->text; ?>
    </section>

    <aside class="aside aside--blog">
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

          foreach ($featuredArray as $featured)
          {
            $item     = $featured[0];

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
    </aside>
  </section>
  <div class="hr"></div>
</article>
