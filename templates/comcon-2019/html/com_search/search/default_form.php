<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_search
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('bootstrap.tooltip');

$lang = JFactory::getLanguage();
$upper_limit = $lang->getUpperLimitSearchWord();

?>
<form id="searchForm" action="<?php echo JRoute::_('index.php?option=com_search'); ?>" method="post">
	<div class="btn-toolbar">
		<div class="btn-group pull-left">
			<label for="search-searchword" class="element-invisible">
				<?php echo JText::_('COM_SEARCH_SEARCH_KEYWORD'); ?>
			</label>
			<input type="text" name="searchword" title="<?php echo JText::_('COM_SEARCH_SEARCH_KEYWORD'); ?>" placeholder="<?php echo JText::_('COM_SEARCH_SEARCH_KEYWORD'); ?>" id="search-searchword" size="30" maxlength="<?php echo $upper_limit; ?>" value="<?php echo $this->escape($this->origkeyword); ?>" class="inputbox" />
		</div>
		<div class="btn-group pull-left">
			<button name="Search" onclick="this.form.submit()" class="btn hasTooltip" title="<?php echo JHtml::_('tooltipText', 'COM_SEARCH_SEARCH');?>">
				<span class="icon-search"></span>
				<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>
			</button>
		</div>
		<input type="hidden" name="task" value="search" />
		<div class="clearfix"></div>
	</div>
	<div class="searchintro<?php echo $this->params->get('pageclass_sfx'); ?>">
		<?php if (!empty($this->searchword)) : ?>
			<p>
				<?php echo JText::plural('COM_SEARCH_SEARCH_KEYWORD_N_RESULTS', '<span class="badge badge-info">' . $this->total . '</span>'); ?>
			</p>
		<?php endif; ?>
	</div>
	<?php if ($this->total > 0) : ?>
		<div class="form-limit">
			<label for="limit">
				<?php echo JText::_('JGLOBAL_DISPLAY_NUM'); ?>
			</label>
			<?php echo $this->pagination->getLimitBox(); ?>
		</div>
		<p class="counter">
			<?php echo $this->pagination->getPagesCounter(); ?>
		</p>
	<?php endif; ?>
</form>
