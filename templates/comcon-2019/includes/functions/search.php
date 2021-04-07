<?php
  // Search the downloads page by title of the product/document
  function searchDownloads($var)
  {
    // Joomla includes since we're outside the Joomla platform here
    if (!defined('_JEXEC')) { define('_JEXEC', 1); }
    if (!defined('DS')) { define('DS', DIRECTORY_SEPARATOR); }
    if (!defined('JPATH_BASE')) { define('JPATH_BASE', realpath(dirname(__FILE__, 5))); }
    require_once JPATH_BASE . DS . 'includes/defines.php';
    require_once JPATH_BASE . DS . 'includes/framework.php';

    // Create the Application
    $app = JFactory::getApplication('site');

    $db = JFactory::getDbo();

    // Custom functions //
    require_once(JPATH_BASE . DS . 'templates/comcon-2019/includes/functions/article.php');

    $search   = htmlspecialchars($_POST[$var]);

    if (!empty($search))
    {
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
        ->where($db->quoteName('a.title') . ' LIKE ' . $db->quote("%{$search}%"))
        ->order('a.ordering ASC');

      $db->setQuery($query);

      $results = $db->loadObjectList();

      // Store results that actually have download files attached to them
      $resultsArray = [];

      foreach ($results as $result)
      {
        $downloads = getDownloads($result);

        if (count($downloads->brochures) > 0 || count($downloads->specs) > 0 || count($downloads->installs) > 0 || count($downloads->cads) > 0)
        {
          array_push($resultsArray, $result);
        }
      }

      return !empty($resultsArray) ? $resultsArray : null;
    }
  }
?>
