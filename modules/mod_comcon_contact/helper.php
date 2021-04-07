<?php

  defined('_JEXEC') or die;

  class ContactHelper
  {
    public static function saveData(
        $title, $name, $surname,
        $type, $org,
        $address1, $address2, $town, $county, $postcode,
        $tele, $email,
        $status, $info, $products, $comments
        )
    {
      $db = JFactory::getDbo();

      $query = $db->getQuery(true);

      $columns = array(
                        'title', 'name', 'surname',
                        'type', 'org',
                        'address1', 'address2', 'town', 'county', 'postcode',
                        'tele', 'email',
                        'status', 'info', 'products', 'comments'
                      );
      $values = array(
                      htmlspecialchars($title), htmlspecialchars($name), htmlspecialchars($surname),
                      htmlspecialchars($type), htmlspecialchars($org),
                      htmlspecialchars($address1), htmlspecialchars($address2), htmlspecialchars($town), htmlspecialchars($county), htmlspecialchars($postcode),
                      htmlspecialchars($tele), htmlspecialchars($email),
                      htmlspecialchars($status), htmlspecialchars($info), htmlspecialchars($products), htmlspecialchars($comments)
                    );

      $query
        ->insert($db->quoteName('#__comcon_contact_inbox'))
        ->columns($db->quoteName($columns))
        ->values(implode(',', $db->quote($values)));

      $db->setQuery($query);
      if ($result = $db->execute())
      {
        return true;
      }
      else
      {
        return false;
      }

      if ($db->execute())
      {
        self::sendEmail(
            $title, $name, $surname,
            $type, $org,
            $address1, $address2, $town, $county, $postcode,
            $tele, $email,
            $status, $info, $products, $comments
          );

          return true;
      }
      else
      {
        return false;
      }
    }

    public static function sendEmail(
                                      $title, $name, $surname,
                                      $type, $org,
                                      $address1, $address2, $town, $county, $postcode,
                                      $tele, $email,
                                      $status, $info, $products, $comments
                                    )
    {
      // Remove mail tags from the string
      function cleanString($string)
      {
        $bad = array('content-type', 'bcc:', 'to:', 'cc:', 'href');
        return htmlspecialchars(str_replace($bad, "", $string));
      }

      $mailer = JFactory::getMailer();
      $config = JFactory::getConfig();

      $sender = array($params->get('contact_sender'), $params->get('contact_sendername'));
      $mailer->setSender($sender);
      $mailer->addRecipient($params->get('contact_receiver'));
      $mailer->setSubject('Enquiry Form - ' . cleanString($org));

      $body =   "<h1>Enquiry</h1>";
      $body .=  "<p><b>Name:</b> " . cleanString($title) . " " . cleanString($name) . " " . cleanString($surname) . "</p>";
      $body .=  "<p><b>Type of enquiry:</b> " . cleanString($type) . "</p>";
      $body .=  "<p><b>Organisation:</b> " . cleanString($org) . "</p>";
      $body .=  "<h2>Address</h2>";
      $body .=  "<address style=\"font-style: normal\">\n";
      $body .=  "<ul class=\"address__items\" style=\"list-style: none;\">";
      $body .=  "<li>" . cleanString($address1) . "</li>";
      $body .=  "<li>" . cleanString($address2) . "</li>";
      $body .=  "<li>" . cleanString($town) . "</li>";
      $body .=  "<li>" . cleanString($county) . "</li>";
      $body .=  "<li>" . cleanString($postcode) . "</li>";
      $body .=  "</address>";
      $body .=  "<h2>Contact Details</h2>";
      $body .=  "<p><b>Contact Telephone number:</b> " . cleanString($tele) . "</p>";
      $body .=  "<p><b>Email address:</b> " . cleanString($email) . "</p>";
      $body .=  "<h2>Project Details</h2>";
      $body .=  "<p><b>Project Status:</b> " . cleanString($status) . "</p>";
      $body .=  "<p><b>Project Information:</b></p>";
      $body .=  "<p>" . cleanString($info) . "</p>";
      $body .=  "<p><b>Requested Products:</b></p>";
      $body .=  "<p>" . cleanString($products) . "</p>";
      $body .=  "<p><b>Further Comments:</b></p>";
      $body .=  "<p>" . cleanString($comments) . "</p>";

      $mailer->setBody($body);
      $mailer->isHTML(true);
      $mailer->send();
    }
  }

?>
