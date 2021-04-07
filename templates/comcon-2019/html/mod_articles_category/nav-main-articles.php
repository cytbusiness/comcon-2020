<?php

	defined('_JEXEC') or die;

	$db = JFactory::getDbo();
?>
<li class="nav-box">
	<a href="<?php echo count($list) > 0 ? "#" : $list[0]->link; ?>" class="nav-box__link link-fill">
		<?php
			$categories = $params->get('catid');

			$query = $db->getQuery(true);

			$query
				->select($db->quoteName('a.params'))
				->from($db->quoteName('#__categories', 'a'))
				->where($db->quoteName('a.id') . ' = ' . (int)$categories[0]);

			$db->setQuery($query);

			$results = $db->loadObjectList();

			$catparams = json_decode($results[0]->params);
		?>
		<img class="nav-box__image" src="<?php echo $catparams->image; ?>">
		<p class="nav-box__caption"><?php echo $module->title; ?></p>
		<?php if (count($list) > 0): ?>
			<ul class="nav-box__children">
				<?php
					foreach ($list as $item):
				?>
					<li class="nav-box__child">
						<a href="<?php echo $item->link; ?>" class="nav-box__childlink"><?php echo $item->title; ?></a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</a>
</li>
