<?php
  // Get the file type of the download and capitalise the extension
  function getDownloadExt($url)
  {
    $extension = strtoupper(pathinfo($url, PATHINFO_EXTENSION));

    return $extension;
  }

  // Get the root URL whether we're in the Joomla environment or not
  function rootUrl()
  {
    if (isset($_SERVER['HTTPS']))
    {
        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    }
    else
    {
        $protocol = 'http';
    }
    return $protocol . "://" . $_SERVER['HTTP_HOST'];
  }
?>
