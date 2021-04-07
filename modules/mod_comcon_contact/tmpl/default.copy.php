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
  $proxyURL = JUri::base() . "modules/" . $module->module . "/proxy.php?url=" . $googleURL;
  $contactform = "<script type=\"module\">import ContactForm from \"" . $contactformURL . "\"; ContactForm.init(\"" . $proxyURL . "\");</script>";
  $doc->addCustomTag($contactform);

  $recaptchaScript =
  "
    function handleAJAXError(jqXHR, textStatus, errorThrown)
    {
      console.log(jqXHR.responseText);
    }

    let recaptchaCallback = function(response)
    {
      // console.log(response);
      var url = \"" . $proxyURL . "\";

      var request =  $.ajax({url: url,
        type: \"GET\",
        contentType: 'application/json',
        dataType: 'json',
        data: { response: response.toString() },
        success: function(response)
        {
          if (response.success.toString() === \"true\")
          {
            $(\"#submit\").removeAttr('disabled');
            $(\"#submit\").addClass('btn--cta');
          }
        },
        error: handleAJAXError
      });
    };

    let recaptchaExpired = function(expired)
    {
      $(\"#submit\").attr('disabled', true);
      $(\"#submit\").removeClass('btn--cta');
    };

    window.recaptchaCallback = recaptchaCallback;
    window.recaptchaExpired = recaptchaExpired;
  ";

  $doc->addScriptDeclaration($recaptchaScript);

  // reCaptcha
  $applink = "<script src=\"https://www.google.com/recaptcha/api.js\" async defer></script>";
  $doc->addCustomTag($applink);
?>

<?php require JModuleHelper::getLayoutPath('mod_comcon_contact', 'form'); ?>
