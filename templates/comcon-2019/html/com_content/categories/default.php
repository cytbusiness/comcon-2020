<?php
	/**
	 * @package     Commercial Connections 2019
	 * @subpackage  com_content
	 *
	 * @copyright   Copyright (C) 2019 Commercial Connections Ltd. All rights reserved.
	 */

	defined('_JEXEC') or die;

	$params = json_decode($this->parent->params);
	$image = $params->image;

	// Get the DB object so we can operate with it later
	$db = JFactory::getDbo();

	// Add canonical link to page for SEO
  $doc = JFactory::getDocument();
  // URL
  $href = $_SERVER["REQUEST_SCHEME"] . "://" . $_SERVER["HTTP_HOST"] . explode("?", $_SERVER["REQUEST_URI"], 2)[0];
  // Set array for attributes
  $attribs = array('type' => 'text/html');
  // Add to head of document
  $doc->addHeadLink($href, 'canonical', 'rel', $attribs);
?>
<?php
	if (json_decode($this->params)->show_description == 1)
	{
		$query = $db->getQuery(true);
		$query
			->select($db->quoteName('description'))
			->from($db->quoteName('#__categories'))
			->where($db->quoteName('id') . ' = ' . $this->parent->id)
			->setLimit('1');

		$db->setQuery($query);

		$results = $db->loadObjectList();

		$desc = $results[0]->description;

		echo "<div class=\"hero\">\n";
			echo "<div class=\"hero__content\">\n";
	    	echo "<header class=\"hero__texts\">\n";
	    		echo "<h1 class=\"hero__title text__title\">" . $this->escape($this->params->get('page_heading')) . "</h1>";
	    			if ($this->params->get('show_description', 1))
	    			{
	      			echo (isset($desc)) ? JHtml::_('content.prepare', $desc, '', 'com_content.categories') : "";
	    			}
	    	echo "</header>\n";
			echo "</div>";
    echo "</div>\n";
	}
	//echo JLayoutHelper::render('joomla.content.categories_default', $this);
?>
<div class="main <?php echo $this->pageclass_sfx; ?>">
	<div class="category">
		<?php echo $this->loadTemplate('items'); ?>
	</div>
</div>
