<?php

  defined('_JEXEC') or die;

  $config = JFactory::getConfig();
  $siteKey = $config->get('gSiteKey');
  $doc = JFactory::getDocument();

  // reCaptcha
  $applink = "<script src=\"https://www.google.com/recaptcha/api.js\" async defer></script>";
  $doc->addCustomTag($applink);

  // Field Check
  $doc->addScript(JUri::base() . 'modules/' . $module->module . '/js/fieldCheck.js');
?>

<div class="contact-form__message">
  <p class="text__line">Thank you for getting in touch.</p>
</div>
