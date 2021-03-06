<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
JHtml::_('behavior.caption');

$app=JFactory::getApplication();
$filterLayout=$app->input->get('layout');

?>
	<form action="<?php echo htmlspecialchars(JUri::getInstance()->toString()); ?>" method="post" name="adminForm" id="adminForm" class="form-inline">
		<?php require 'includes/filters.php'; ?>

		<?php if (empty($this->items)) : ?>
			<?php if ($this->params->get('show_no_articles', 1)) : ?>
				<p><?php echo JText::_('COM_CONTENT_NO_ARTICLES'); ?></p>
			<?php endif; ?>
		<?php else: ?>
			<div class="blog<?php echo $this->pageclass_sfx; ?>" itemscope itemtype="http://schema.org/Blog">
				<?php $leadingcount = 0; ?>
				<?php if (!empty($this->items)) : ?>
					<div class="items-leading clearfix">
						<?php foreach ($this->items as &$item) : ?>
							<div class="leading-<?php echo $leadingcount; ?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?>"
								itemprop="blogPost" itemscope itemtype="http://schema.org/BlogPosting">
								<?php 
									$this->item = &$item; 
								 	echo $this->loadTemplate('item'); 
							 	?>
							</div>
							<?php $leadingcount++; ?>
						<?php endforeach; ?>
					</div><!-- end items-leading -->
				<?php endif; ?>

				<?php if (($this->params->def('show_pagination', 1) == 1 || ($this->params->get('show_pagination') == 2)) && ($this->pagination->get('pages.total') > 1)) : ?>
					<div class="pagination">
						<?php if ($this->params->def('show_pagination_results', 1)) : ?>
							<p class="counter pull-right"> <?php echo $this->pagination->getPagesCounter(); ?> </p>
						<?php endif; ?>
						<?php echo $this->pagination->getPagesLinks(); ?> </div>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<input type="hidden" name="filter_order" value="" />
		<input type="hidden" name="filter_order_Dir" value="" />
		<input type="hidden" name="limitstart" value="" />
		<input type="hidden" name="task" value="" />	
	</form>
