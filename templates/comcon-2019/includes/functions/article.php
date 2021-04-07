<?php
  // Joomla includes since we're outside the Joomla platform here
  if (!defined('_JEXEC')) { define('_JEXEC', 1); }
  if (!defined('DS')) { define('DS', DIRECTORY_SEPARATOR); }
  if (!defined('JPATH_BASE')) { define('JPATH_BASE', realpath(dirname(__FILE__, 5))); }
  require_once JPATH_BASE . DS . 'includes/defines.php';
  require_once JPATH_BASE . DS . 'includes/framework.php';

  // Custom functions
  require_once JPATH_BASE . DS . 'templates/comcon-2019/includes/functions/functions.php';

  // Class to store the article's downloads in for access later
  class Downloads
  {
    public $brochures       = [];
    public $brochure_titles = [];
    public $brochure_types  = [];
    public $specs           = [];
    public $specs_titles    = [];
    public $specs_types     = [];
    public $installs        = [];
    public $installs_titles = [];
    public $installs_types  = [];
    public $cads            = [];
    public $cads_titles     = [];

    // Do we actually have content to return?
    public function notEmpty()
    {
      (!empty($brochures) ||
      !empty($specs) ||
      !empty($installs) ||
      !empty($cads))
      ? true
      : false;
    }
  }

  function getDownloads($article)
  {

    $downloads = new Downloads;

    // Meta data - where brochures are stored in the article object
    $meta = isset($article->metadata) ? json_decode($article->metadata) : null;

    if (!empty($meta))
    {
      // Downloads
      $brochureSet = isset($meta->downloads_brochures) ? json_decode($meta->downloads_brochures) : null;

      if (!empty($brochureSet))
      {
        $downloads->brochures = $brochureSet->downloads_brochure;
        $downloads->brochure_titles = isset($brochureSet->downloads_brochure_title) ? $brochureSet->downloads_brochure_title : null;
        $downloads->brochure_types = isset($brochureSet->downloads_brochure_type) ? $brochureSet->downloads_brochure_type : null;
      }

      $specSet = isset($meta->downloads_specs) ? json_decode($meta->downloads_specs) : null;

      if (!empty($specSet))
      {
        $downloads->specs = $specSet->downloads_spec;
        $downloads->specs_titles = isset($specSet->downloads_spec_title) ? $specSet->downloads_spec_title : null;
        $downloads->specs_types = isset($specSet->downloads_spec_type) ? $specSet->downloads_spec_type : null;
      }

      $installSet = isset($meta->downloads_installs) ? json_decode($meta->downloads_installs) : null;

      if (!empty($installSet))
      {
        $downloads->installs = $installSet->downloads_install;
        $downloads->installs_titles = isset($installSet->downloads_install_title) ? $installSet->downloads_install_title : null;
        $downloads->installs_types = isset($installSet->downloads_install_types) ? $installSet->downloads_install_types : null;
      }

      $cadSet = isset($meta->downloads_cads) ? json_decode($meta->downloads_cads) : null;

      if (!empty($cadSet))
      {
        $downloads->cads = $cadSet->gallery_cad;
        $downloads->cads_titles = $cadSet->gallery_cad_title;
      }
    }

    return $downloads;
  }

  function getArticleURL($article)
  {
    // Get link to the article
    // $rootURL    = rootUrl();
    // $subpathURL = JURI::base(true);
    //
    // if (!empty($subpathURL) && $subpathURL != '/')
    // {
    //   $rootURL = substr($rootURL, 0, -1 * strlen($subpathURL));
    // }
    $url = /*$rootURL .*/ JRoute::_(ContentHelperRoute::getArticleRoute($article->id, $article->catid));

    return $url;
  }

  function printArticle($article, $cta)
  {
    $images = json_decode($article->images);

    $url = getArticleURL($article);

    // echo "<li class=\"category__item\">\n";
    // echo "<a href=\"" . $url . "\" class=\"category__link link-fill\">\n";
    // echo "<img class=\"category__image\" src=\"" . $images->image_intro . "\" alt=\"" . $article->title . "\">\n";
    // echo "<p class=\"category__label text__line\">" . $article->title . "</p>\n";
    // echo "</a>\n";
    // echo "</li>\n";

    echo "<li class=\"category__item\">\n";
      echo "<div class=\"category__imagebox\">\n";
        echo "<a href=\"" . $url ."\" class=\"category__link link-fill\">\n";
         echo "<img class=\"category__image\" src=\"" . $images->image_intro . "\" alt=\"" . htmlspecialchars($article->title) . "\">\n";
        echo "</a>\n";
      echo "</div>\n";
      echo "<div class=\"category__content\">\n";
       echo "<h2 class=\"text__xsheading\">\n";
         echo htmlspecialchars($article->title);
       echo "</h2>\n";
       echo "<p class=\"text__line\">\n";
        echo htmlspecialchars($article->alternative_readmore);
      echo "</p>\n";
      echo "</div>";
      echo "<p class=\"category__label text__line\">\n";
       echo "<a href=\"" . $url ."\" class=\"category__link link-fill\">\n";
         echo $cta;
       echo "</a>\n";
      echo "</p>\n";
    echo "</li>\n";
  }

  // Different HTML content to article
  function printBlog($article)
  {
    $images = json_decode($article->images);

    $url = getArticleURL($article);

    // echo "<li class=\"category__item\">\n";
    // $date = new DateTime($article->created);
    // echo "<time class=\"tag__date\" datetime=\"" . $date->format('Y-m-d') . "\">" . $date->format('d F Y') . "</time>\n";
    // echo "<a href=\"" . $url . "\" class=\"category__link link-fill\">\n";
    // echo "<img class=\"category__image\" src=\"" . $images->image_intro . "\" alt=\"" . $article->title . "\">\n";
    // echo "<p class=\"category__label text__line\">" . $article->title . "</p>\n";
    // echo "</a>\n";
    // echo "</li>\n";

    echo "<li class=\"category__item\">\n";
      echo "<div class=\"category__imagebox\">\n";
        echo "<a href=\"" . $url ."\" class=\"category__link link-fill\">\n";
         echo "<img class=\"category__image\" src=\"" . $images->image_intro . "\" alt=\"" . htmlspecialchars($article->title) . "\">\n";
        echo "</a>\n";
      echo "</div>\n";
      echo "<div class=\"category__content\">\n";
      $date = new DateTime($article->created);
      echo "<time class=\"tag__date\" datetime=\"" . $date->format('Y-m-d') . "\">" . $date->format('d F Y') . "</time>\n";
       echo "<h2 class=\"text__xsheading\">\n";
         echo htmlspecialchars($article->title);
       echo "</h2>\n";
       echo "<p class=\"text__line\">\n";
        echo htmlspecialchars($article->alternative_readmore);
      echo "</p>\n";
      echo "</div>";
      echo "<p class=\"category__label text__line\">\n";
       echo "<a href=\"" . $url ."\" class=\"category__link link-fill\">\n";
         echo "Read More";
       echo "</a>\n";
      echo "</p>\n";
    echo "</li>\n";
  }

  // Format the resulting size into something human-readable
  function formatSize($bytes)
  {
      if ($bytes >= 1073741824)
      {
          $bytes = number_format($bytes / 1073741824, 2) . ' GB';
      }
      elseif ($bytes >= 1048576)
      {
          $bytes = number_format($bytes / 1048576, 2) . ' MB';
      }
      elseif ($bytes >= 1024)
      {
          $bytes = number_format($bytes / 1024, 2) . ' KB';
      }
      elseif ($bytes > 1)
      {
          $bytes = $bytes . ' bytes';
      }
      elseif ($bytes == 1)
      {
          $bytes = $bytes . ' byte';
      }
      else
      {
          $bytes = '0 bytes';
      }

      return $bytes;
  }

  // Used for getting file download size
  function getFileSize($url)
  {
    return formatSize(filesize($url));
  }

?>
