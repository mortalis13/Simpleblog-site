<?php

defined('_JEXEC') or die;

// Create a shortcut for params.
$params = $this->item->params;
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
$canEdit = $this->item->params->get('access-edit');
$info    = $params->get('info_block_position', 0);

$app=JFactory::getApplication();
$layout=$app->input->get('layout');

$lang=JFactory::getLanguage();
$lang->load('tpl_simpleblog');

$displayData=array('item' => $this->item, 'params' => $params, 'position' => 'above');
?>
<?php if ($this->item->state == 0 || strtotime($this->item->publish_up) > strtotime(JFactory::getDate())
	|| ((strtotime($this->item->publish_down) < strtotime(JFactory::getDate())) && $this->item->publish_down != '0000-00-00 00:00:00' )) : ?>
	<div class="system-unpublished">
<?php endif; ?>

<?php echo JLayoutHelper::render('joomla.content.blog_style_default_item_title', $this->item); ?>

<?php if ($canEdit) : ?>
	<?php 
		$menu = JFactory::getApplication()->getMenu();
		$active = $menu->getActive();
		$itemId = $active->id;
	?>
	<ul class="icons pull-right nav nav-pills">
		<li> <?php echo JHtml::_('icon.edit', $this->item, $params); ?> </li>
		<li> <?php echo JHTML::_('link','index.php?option=com_content&view=category&layout='
						.$layout.'&id='.$this->item->catid.'&Itemid='.$itemId.'&task=delete&aid='.$this->item->id,JText::_('TPL_SIMPLEBLOG_DELETE_BUTTON')); ?> </li>
	</ul>
<?php endif; ?>

<?php if ($params->get('show_tags') && !empty($this->item->tags->itemTags)) : ?>
	<?php echo JLayoutHelper::render('joomla.content.tags', $this->item->tags->itemTags); ?>
<?php endif; ?>

<?php // Todo Not that elegant would be nice to group the params ?>
<?php $useDefList = ($params->get('show_modify_date') || $params->get('show_publish_date') || $params->get('show_create_date')
	|| $params->get('show_hits') || $params->get('show_category') || $params->get('show_parent_category') || $params->get('show_author') ); ?>

<?php if ($useDefList && ($info == 0 || $info == 2)) : ?>
	<dl class="article-info  muted">
		<?php echo JLayoutHelper::render('joomla.content.myarticles_info', $displayData); ?>
	</dl>
<?php endif; ?>

<?php echo JLayoutHelper::render('joomla.content.intro_image', $this->item); ?>


<?php if (!$params->get('show_intro')) : ?>
	<?php echo $this->item->event->afterDisplayTitle; ?>
<?php endif; ?>
<?php echo $this->item->event->beforeDisplayContent; ?> <?php echo $this->item->introtext; ?>

<?php if ($useDefList && ($info == 1 || $info == 2)) : ?>
	<?php echo JLayoutHelper::render('joomla.content.info_block.block', array('item' => $this->item, 'params' => $params, 'position' => 'below')); ?>
<?php  endif; ?>

<?php if ($params->get('show_readmore') && $this->item->readmore) :
	if ($params->get('access-view')) :
		$link = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid));
	else :
		$menu = JFactory::getApplication()->getMenu();
		$active = $menu->getActive();
		$itemId = $active->id;
		$link1 = JRoute::_('index.php?option=com_users&view=login&Itemid=' . $itemId);
		$returnURL = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid));
		$link = new JUri($link1);
		$link->setVar('return', base64_encode($returnURL));
	endif; ?>

	<?php echo JLayoutHelper::render('joomla.content.readmore', array('item' => $this->item, 'params' => $params, 'link' => $link)); ?>

<?php endif; ?>

<?php if ($this->item->state == 0 || strtotime($this->item->publish_up) > strtotime(JFactory::getDate())
	|| ((strtotime($this->item->publish_down) < strtotime(JFactory::getDate())) && $this->item->publish_down != '0000-00-00 00:00:00' )) : ?>
</div>
<?php endif; ?>

<?php echo $this->item->event->afterDisplayContent; ?>
