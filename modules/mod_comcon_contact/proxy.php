<?php
  if (!isset($_SERVER['HTTP_X_REQUESTED_WITH']))
  {
    header('HTTP/1.0 403 Forbidden');
    die('You are not allowed to access this file.');
  }
  header('Content-type: application/json');

  // Joomla includes since we're outside the Joomla platform here
  if (!defined('_JEXEC')) { define('_JEXEC', 1); }
  if (!defined('DS')) { define('DS', DIRECTORY_SEPARATOR); }
  if (!defined('JPATH_BASE')) { define('JPATH_BASE', realpath(dirname(__FILE__, 3))); }
  require_once JPATH_BASE . DS . 'includes/defines.php';
  require_once JPATH_BASE . DS . 'includes/framework.php';

  $config = JFactory::getConfig();

  $url = $_GET['url'];
  $response = $_GET['response'];
  $secretKey = $config->get('gSecretKey');
  $params = array('secret' => $secretKey, 'response' => $response);
  $json = file_get_contents($url . '?secret=' . $secretKey . '&response=' . $response);
  echo $json;
?>
