<?php
	// Top nav layout by Ben Ireland for Commercial Connections Ltd //

	defined('_JEXEC') or die;

	$db = JFactory::getDbo();

	$id = '';

	if ($tagId = $params->get('tag_id', ''))
	{
		$id = ' id="' . $tagId . '"';
	}

	?>
<li class="nav-box"<?php echo $id; ?>>
	<?php

		// Are we creating a direct link or a drop down?
		// If the item has child elements, then it's a dropdown.

		$childArray = [];
		// We have to go through each item to see if there's any children
		foreach ($list as $i => &$item)
		{
			if ($item->parent_id == $base->id)
			{
				array_push($childArray, $item);
			}
		}

	?>
	<a href="<?php echo count($childArray) > 0 ? "#" : $base->link; ?>" class="nav-box__link link-fill">
		<?php
			$query = $db->getQuery(true);

			$query
				->select($db->quoteName('a.title'))
				->select($db->quoteName('a.params'))
				->from($db->quoteName('#__categories', 'a'))
				->where($db->quoteName('a.id') . ' = ' . (int)$base->query["id"] . ';');

			$db->setQuery($query);

			$results = $db->loadObjectList();

			$catparams = json_decode($results[0]->params);

			echo "<img class=\"nav-box__image\" src=\"{$catparams->image}\">\n";
		?>
			<p class="nav-box__caption"><?php echo $base->title; ?></p>
		</a>
		<?php if (count($childArray) > 0): ?>
		<ul class="nav-box__children">
			<?php
				foreach ($childArray as $i => &$item)
				{
					if ($item->level > $base->level)
					{
						$class = 'item-' . $item->id;

						if ($item->id == $default_id)
						{
							$class .= ' default';
						}

						if ($item->id == $active_id || ($item->type === 'alias' && $item->params->get('aliasoptions') == $active_id))
						{
							$class .= ' current';
						}

						if (in_array($item->id, $path))
						{
							$class .= ' active';
						}
						elseif ($item->type === 'alias')
						{
							$aliasToId = $item->params->get('aliasoptions');

							if (count($path) > 0 && $aliasToId == $path[count($path) - 1])
							{
								$class .= ' active';
							}
							elseif (in_array($aliasToId, $path))
							{
								$class .= ' alias-parent-active';
							}
						}

						if ($item->type === 'separator')
						{
							$class .= ' divider';
						}

						if ($item->deeper)
						{
							$class .= ' deeper';
						}

						if ($item->parent)
						{
							$class .= ' parent';
						}

						require JModuleHelper::getLayoutPath('mod_menu', 'nav-main_url');
					}
				}
			?>
		</ul>
	<?php endif; ?>
</li>
