<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_custom
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$images = json_decode($params->get('footer_images'));

foreach ($images->footer_images_image as $key => $image)
{
  echo "<img class=\"footer__image\" src=\"" . $image . "\" alt=\"" . $images->footer_images_alt[$key] . "\">\n";
}

?>
