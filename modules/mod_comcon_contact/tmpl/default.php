<?php

  defined('_JEXEC') or die;

  $config = JFactory::getConfig();
  $siteKey = $config->get('gSiteKey');
  $doc = JFactory::getDocument();

  $googleURL = "https://www.google.com/recaptcha/api/siteverify";

  // Stylesheet
  $doc->addStylesheet(JUri::base() . 'modules/' . $module->module . '/css/contact.css');

  // Field Check
  $contactformURL = JUri::base() . "modules/" . $module->module . "/js/form.js";
  $proxyURL = /*JUri::base() . */"modules/" . $module->module . "/proxy.php?url=" . $googleURL;
  $contactform =
  "<script type=\"module\">
    import ContactForm from \"" . $contactformURL . "\";
    window.ContactForm = ContactForm; ContactForm.init(\"" . $proxyURL . "\");
    var recaptchaCallback = ContactForm.recaptchaCallback;
    window.recaptchaCallback = recaptchaCallback;
    var recaptchaExpired = ContactForm.recaptchaExpired; window.recaptchaExpired = recaptchaExpired;
  </script>";
  $doc->addCustomTag($contactform);

  // reCaptcha
  $applink = "<script src=\"https://www.google.com/recaptcha/api.js\" async defer></script>";
  $doc->addCustomTag($applink);
?>

<?php require JModuleHelper::getLayoutPath('mod_comcon_contact', 'form'); ?>
