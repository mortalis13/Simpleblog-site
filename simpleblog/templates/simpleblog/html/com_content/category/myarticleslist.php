<?php

defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

$app=JFactory::getApplication();
$layout=$app->input->get('layout');

// Create some shortcuts.
$params		= &$this->item->params;
$n			= count($this->items);
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));


// Check for at least one editable article
$isEditable = false;

if (!empty($this->items))
{
	foreach ($this->items as $article)
	{
		if ($article->params->get('access-edit'))
		{
			$isEditable = true;
			break;
		}
	}
}
?>

<form action="<?php echo htmlspecialchars(JUri::getInstance()->toString()); ?>" method="post" name="adminForm" id="adminForm" class="form-inline frontend-form">
	<?php require 'includes/myarticles_filters.php'; ?>

	<?php if (empty($this->items)) : ?>
		<?php if ($this->params->get('show_no_articles', 1)) : ?>
			<p><?php echo JText::_('COM_CONTENT_NO_ARTICLES'); ?></p>
		<?php endif; ?>
	<?php else : ?>
		<div class="table-responsive">
			<table class="category table table-striped table-bordered table-hover">
				<?php if ($this->params->get('show_headings')) : ?>
					<thead>
						<tr>
							<th onclick="selectCheckbox(event,this)"> <?php echo JHtml::_('grid.checkall'); ?> </th>
							<?php if ($date = $this->params->get('list_show_date')) : ?>
								<th id="categorylist_header_date" class="text-center" onclick="sortHeader(this)">
									<?php if ($date == "created") : ?>
										<?php echo JHtml::_('grid.sort', 'COM_CONTENT_'.$date.'_DATE', 'a.created', $listDirn, $listOrder); ?>
									<?php elseif ($date == "modified") : ?>
										<?php echo JHtml::_('grid.sort', 'COM_CONTENT_'.$date.'_DATE', 'a.modified', $listDirn, $listOrder); ?>
									<?php elseif ($date == "published") : ?>
										<?php echo JHtml::_('grid.sort', 'COM_CONTENT_'.$date.'_DATE', 'a.publish_up', $listDirn, $listOrder); ?>
									<?php endif; ?>
								</th>
							<?php endif; ?>

							<th class="text-center" onclick="sortHeader(this)">
								<?php echo JHtml::_('grid.sort', 'JSTATUS', 'a.state', $listDirn, $listOrder); ?>
							</th>

							<th id="categorylist_header_title" class="text-left" onclick="sortHeader(this)">
								<?php echo JHtml::_('grid.sort', 'JGLOBAL_TITLE', 'a.title', $listDirn, $listOrder); ?>
							</th>
							<?php if ($this->params->get('list_show_author')) : ?>
								<th id="categorylist_header_author" class="text-center" onclick="sortHeader(this)">
									<?php echo JHtml::_('grid.sort', 'JAUTHOR', 'author', $listDirn, $listOrder); ?>
								</th>
							<?php endif; ?>
							<?php if ($this->params->get('list_show_hits')) : ?>
								<th id="categorylist_header_hits" class="text-center" onclick="sortHeader(this)">
									<?php echo JHtml::_('grid.sort', 'JGLOBAL_HITS', 'a.hits', $listDirn, $listOrder); ?>
								</th>
							<?php endif; ?>
							<?php if ($isEditable) : ?>
								<th id="categorylist_header_edit" class="text-center">
									<?php echo JText::_('COM_CONTENT_EDIT_ITEM'); ?>
								</th>
							<?php endif; ?>
						</tr>
					</thead>
				<?php endif; ?>

				<tbody>
					<?php foreach ($this->items as $i => $article) : ?>
						<?php $action="openArticle('".JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catid))."')"; ?>

						<?php if ($this->items[$i]->state == 0) : ?>
						 <tr class="system-unpublished cat-list-row<?php echo $i % 2; ?>">
						<?php else: ?>
							<tr class="cat-list-row<?php echo $i % 2; ?>">
						<?php endif; ?>
							<td onclick="selectCheckbox(event,this)" class="checkbox-cell">
							 	<?php echo JHtml::_('grid.id',$i,$article->id); ?>
							</td>
							<?php if ($this->params->get('list_show_date')) : ?>
								<td headers="categorylist_header_date" class="list-date text-center" onclick=<?php echo $action; ?>>
									<?php
									echo JHtml::_(
										'date', $article->displayDate,
										$this->escape($this->params->get('date_format', JText::_('DATE_FORMAT_LC3')))
									); ?>
								</td>
							<?php endif; ?>

							<td class="text-center">
								<?php if ($article->state == 0) : ?>
									<span class="icon-unpublish" data-toggle="tooltip" title="<?php echo JText::_('TPL_SIMPLEBLOG_UNPUBLISHED_STATE') ?>"></span>
								<?php else: ?>
									<span class="icon-publish" data-toggle="tooltip" title="<?php echo JText::_('TPL_SIMPLEBLOG_PUBLISHED_STATE') ?>"></span>
								<?php endif; ?>
							</td>

							<td headers="categorylist_header_title" class="list-title text-left" onclick=<?php echo $action; ?>>
								<?php if (in_array($article->access, $this->user->getAuthorisedViewLevels())) : ?>
									<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catid)); ?>">
										<?php echo $this->escape($article->title); ?>
									</a>
								<?php else: ?>
									<?php
									echo $this->escape($article->title).' : ';
									$menu		= JFactory::getApplication()->getMenu();
									$active		= $menu->getActive();
									$itemId		= $active->id;
									$link = JRoute::_('index.php?option=com_users&view=login&Itemid='.$itemId);
									$returnURL = JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catid));
									$fullURL = new JUri($link);
									$fullURL->setVar('return', base64_encode($returnURL));
									?>
									<a href="<?php echo $fullURL; ?>" class="register">
										<?php echo JText::_('COM_CONTENT_REGISTER_TO_READ_MORE'); ?>
									</a>
								<?php endif; ?>

								<?php if (strtotime($article->publish_up) > strtotime(JFactory::getDate())) : ?>
									<span class="list-published label label-warning">
										<?php echo JText::_('JNOTPUBLISHEDYET'); ?>
									</span>
								<?php endif; ?>
								<?php if ((strtotime($article->publish_down) < strtotime(JFactory::getDate())) && $article->publish_down != '0000-00-00 00:00:00') : ?>
									<span class="list-published label label-warning">
										<?php echo JText::_('JEXPIRED'); ?>
									</span>
								<?php endif; ?>
							</td>

							<?php if ($this->params->get('list_show_author', 1)) : ?>
								<td headers="categorylist_header_author" class="list-author" onclick=<?php echo $action; ?>>
									<?php if (!empty($article->author) || !empty($article->created_by_alias)) : ?>
										<?php $author = $article->author ?>
										<?php $author = ($article->created_by_alias ? $article->created_by_alias : $author);?>
										<?php if (!empty($article->contact_link) && $this->params->get('link_author') == true) : ?>
											<?php echo JText::sprintf('COM_CONTENT_WRITTEN_BY', JHtml::_('link', $article->contact_link, $author)); ?>
										<?php else: ?>
											<?php echo JText::sprintf('COM_CONTENT_WRITTEN_BY', $author); ?>
										<?php endif; ?>
									<?php endif; ?>
								</td>
							<?php endif; ?>

							<?php if ($this->params->get('list_show_hits', 1)) : ?>
								<td headers="categorylist_header_hits" class="list-hits" onclick=<?php echo $action; ?>>
									<span>
										<b><?php echo JText::sprintf('JGLOBAL_HITS_COUNT', $article->hits); ?></b>
									</span>
								</td>
							<?php endif; ?>

							<?php if ($isEditable) : ?>
								<td headers="categorylist_header_edit" class="list-edit" onclick=<?php echo $action; ?>>
									<?php if ($article->params->get('access-edit')) : ?>
										<?php echo JHtml::_('icon.edit', $article, $params); ?>
										<?php 
											$uri  = JUri::getInstance();
											$menu = JFactory::getApplication()->getMenu();
											$active = $menu->getActive();
											$itemId = $active->id;

											echo "| ";
											echo JHTML::_('link','index.php?option=com_content&view=category&layout='
																		.$layout.'&id='.$article->catid.'&Itemid='.$itemId.'&task=delete&aid='.$article->id,JText::_('TPL_SIMPLEBLOG_DELETE_BUTTON'));
										?>
									<?php endif; ?>
								</td>
							<?php endif; ?>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>	

		<?php // Actions ?>
		<?php if ($this->category->getParams()->get('access-create')) : ?>
			<div id="toolbar" class="btn-toolbar">
			    <div id="toolbar-new" class="btn-wrapper">
						<?php echo JHTML::_('icon.create', $this->category, $this->category->params); ?>
			    </div>
			    <div id="toolbar-publish" class="btn-wrapper">;
			        <button class="btn btn-small" onclick="performToolbarAction(event,'publish');">
			            <span class="icon-publish"></span> <?php echo JText::_('TPL_SIMPLEBLOG_PUBLISH_BUTTON') ?>
			        </button>
			    </div>
			    <div id="toolbar-unpublish" class="btn-wrapper">
			        <button class="btn btn-small" onclick="performToolbarAction(event,'unpublish')">
			            <span class="icon-unpublish"></span> <?php echo JText::_('TPL_SIMPLEBLOG_UNPUBLISH_BUTTON') ?>
			        </button>
			    </div>
			    <div id="toolbar-delete" class="btn-wrapper">
			        <button class="btn btn-small" onclick="performToolbarAction(event,'deleteBySelection')">
			            <span class="icon-delete"></span> <?php echo JText::_('TPL_SIMPLEBLOG_DELETE_BUTTON') ?>
			        </button>
			    </div>
			</div>
		<?php  endif; ?>

		<?php // Add pagination links ?>
		<?php if (($this->params->def('show_pagination', 2) == 1  || ($this->params->get('show_pagination') == 2)) && ($this->pagination->pagesTotal > 1)) : ?>
			<div class="pagination">
				<?php if ($this->params->def('show_pagination_results', 1)) : ?>
					<p class="counter pull-right">
						<?php echo $this->pagination->getPagesCounter(); ?>
					</p>
				<?php endif; ?>
				<?php echo $this->pagination->getPagesLinks(); ?>
			</div>
		<?php endif; ?>
	<?php endif; ?> <!-- if (empty($this->items)) -->

	<input type="hidden" name="filter_order" value="" />
	<input type="hidden" name="filter_order_Dir" value="" />
	<input type="hidden" name="limitstart" value="" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="option" value="com_content" />
</form>
