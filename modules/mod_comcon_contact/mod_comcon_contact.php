<?php

  defined('_JEXEC') or die;

  require_once('helper.php');

  // $_GET values for empty form
  $title          = isset($_GET['title']) ? htmlspecialchars($_GET['title']) : '';
  $name           = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : '';
  $surname        = isset($_GET['surname']) ? htmlspecialchars($_GET['surname']) : '';

  $type           = isset($_GET['type']) ? htmlspecialchars($_GET['type']) : '';
  $org            = isset($_GET['org']) ? htmlspecialchars($_GET['org']) : '';

  $address1       = isset($_GET['address1']) ? htmlspecialchars($_GET['address1']) : '';
  $address2       = isset($_GET['address2']) ? htmlspecialchars($_GET['address2']) : '';
  $town           = isset($_GET['town']) ? htmlspecialchars($_GET['town']) : '';
  $county         = isset($_GET['county']) ? htmlspecialchars($_GET['county']) : '';
  $postcode       = isset($_GET['postcode']) ? htmlspecialchars($_GET['postcode']) : '';

  $tele           = isset($_GET['tele']) ? htmlspecialchars($_GET['tele']) : '';
  $email          = isset($_GET['email']) ? htmlspecialchars($_GET['email']) : '';

  $status         = isset($_GET['status']) ? htmlspecialchars($_GET['status']) : '';
  $info           = isset($_GET['info']) ? htmlspecialchars($_GET['info']) : '';
  $products       = isset($_GET['products']) ? htmlspecialchars($_GET['products']) : '';
  $comments       = isset($_GET['comments']) ? htmlspecialchars($_GET['comments']) : '';

  if (isset($_POST['send']))
  {
    // Return to the form if required values aren't set
    if  (
          !isset($_POST['name'])       ||
          !isset($_POST['surname'])    ||
          !isset($_POST['type'])       ||
          !isset($_POST['address1'])   ||
          !isset($_POST['town'])       ||
          !isset($_POST['county'])     ||
          !isset($_POST['tele'])       ||
          !isset($_POST['status'])     ||
          !isset($_POST['info'])
        )
    {
      require JModuleHelper::getLayoutPath('mod_comcon_contact', $params->get('layout', 'error'));
    }
    else
    {
      $jinput = JFactory::getApplication()->input;

      // $title          = $jinput->get('title', '', 'STRING');
      // $name           = $jinput->get('name', '', 'STRING');;
      // $surname        = $jinput->get('surname', '', 'STRING');
      //
      // $type           = $jinput->get('type', '', 'STRING');
      // $org            = $jinput->get('org', '', 'STRING');
      //
      // $address1       = $jinput->get('address1', '', 'STRING');
      // $address2       = $jinput->get('address2', '', 'STRING');
      // $town           = $jinput->get('town', '', 'STRING');
      // $county         = $jinput->get('county', '', 'STRING');
      // $postcode       = $jinput->get('postcode', '', 'STRING');
      //
      // $tele           = $jinput->get('tele', '', 'STRING');
      // $email          = $jinput->get('email', '', 'STRING');
      //
      // $status         = $jinput->get('status', '', 'STRING');
      // $info           = $jinput->get('info', '', 'RAW');
      // $products       = $jinput->get('products', '', 'RAW');
      // $comments       = $jinput->get('comments', '', 'RAW');

      $post = $jinput->getArray($_POST);

      if (ContactHelper::saveData($post['title'], $post['name'], $post['surname'], $post['type'], $post['org'], $post['address1'], $post['address2'], $post['town'], $post['county'], $post['postcode'], $post['tele'], $post['email'], $post['status'], $post['info'], $post['products'], $post['comments']))
      {
        // Unset $_POST data
        header("Refresh: 5");
        require JModuleHelper::getLayoutPath('mod_comcon_contact', $params->get('layout', 'success'));
      }
    }
  }
  else
  {
    require JModuleHelper::getLayoutPath('mod_comcon_contact', $params->get('layout', 'default'));
  }

?>
