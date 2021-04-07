<?php

  defined('_JEXEC') or die;

  // Unset $_POST data
  $_POST = array();

  $config = JFactory::getConfig();
  $siteKey = $config->get('gSiteKey');
  $doc = JFactory::getDocument();

  // reCaptcha
  $applink = "<script src=\"https://www.google.com/recaptcha/api.js\" async defer></script>";
  $doc->addCustomTag($applink);

  // Field Check
  $doc->addScript(JUri::base() . 'modules/' . $module->module . '/js/fieldCheck.js');
?>

<p class="text__line text__error">Please ensure all required fields are completed.</p>

<?php require JModuleHelper::getLayoutPath('mod_comcon_contact', 'form'); ?>
