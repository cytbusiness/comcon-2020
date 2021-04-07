<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_custom
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

echo "<div class=\"main-hero\" style=\"background-image: url('{$params->get('hero_image')}');\">\n";
  echo "<div class=\"main-hero__content\">";
    echo "<h1 class=\"main-hero__text\">";
      echo "<span class=\"text__title main-hero__title\">{$params->get('hero_title')}</span>\n";
      echo "<span class=\"text__line main-hero__subtext\">{$params->get('hero_subtext')}</span>\n";
    echo "</h1>\n";

  echo "</div>\n";
echo "</div>\n";

?>
