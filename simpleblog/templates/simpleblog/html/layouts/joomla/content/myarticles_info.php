<?php

defined('JPATH_BASE') or die;

?>
      <dd class="create">
          <time datetime="<?php echo JHtml::_('date', $displayData['item']->created, 'c'); ?>" itemprop="dateCreated">
            <?php echo JText::sprintf('COM_CONTENT_CREATED_DATE_ON', JHtml::_('date', $displayData['item']->created, JText::_('TPL_SIMPLEBLOG_DATE_FORMAT'))); ?>
          </time>
      </dd>
      <dd class="published">
        <time datetime="<?php echo JHtml::_('date', $displayData['item']->publish_up, 'c'); ?>" itemprop="datePublished">
          <?php echo JText::sprintf('COM_CONTENT_PUBLISHED_DATE_ON', JHtml::_('date', $displayData['item']->publish_up, JText::_('TPL_SIMPLEBLOG_DATE_FORMAT'))); ?>
        </time>
      </dd>
      <dd class="modified">
        <time datetime="<?php echo JHtml::_('date', $displayData['item']->modified, 'c'); ?>" itemprop="dateModified">
          <?php echo JText::sprintf('COM_CONTENT_LAST_UPDATED', JHtml::_('date', $displayData['item']->modified, JText::_('TPL_SIMPLEBLOG_DATE_FORMAT'))); ?>
        </time>
      </dd>
			<dd class="hits">
					<meta itemprop="interactionCount" content="UserPageVisits:<?php echo $displayData['item']->hits; ?>" />
					<?php echo JText::sprintf('COM_CONTENT_ARTICLE_HITS', $displayData['item']->hits); ?>
			</dd>