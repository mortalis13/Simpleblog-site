<?php

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
JHtml::_('behavior.caption');
?>

<form action="<?php echo htmlspecialchars(JUri::getInstance()->toString()); ?>" method="post" name="adminForm" id="adminForm" class="form-inline">
	<?php require 'includes/myarticles_filters.php'; ?>

	<?php if (empty($this->items)) : ?>
		<?php if ($this->params->get('show_no_articles', 1)) : ?>
			<p><?php echo JText::_('COM_CONTENT_NO_ARTICLES'); ?></p>
		<?php endif; ?>
	<?php else: ?>
		<div class="blog<?php echo $this->pageclass_sfx; ?>" itemscope itemtype="http://schema.org/Blog">
			<?php $count = 0; ?>
			<?php if (!empty($this->items)) : ?>
				<div class="items-leading clearfix">
						<?php foreach ($this->items as &$item) : ?>
							<?php if ($item->created_by == JFactory::getUser()->id): ?>
								<div class="leading-<?php echo $count; ?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?>"
									itemprop="blogPost" itemscope itemtype="http://schema.org/BlogPosting">
									<?php 
										$this->item = &$item; 
									 	echo $this->loadTemplate('item'); 
								 	?>								
								</div>
								<?php $count++; ?>
							<?php endif; ?>
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
	<?php endif; ?> <!-- if (empty($this->items)) -->

	<input type="hidden" name="filter_order" value="" />
	<input type="hidden" name="filter_order_Dir" value="" />
	<input type="hidden" name="limitstart" value="" />
	<input type="hidden" name="task" value="" />
</form>
