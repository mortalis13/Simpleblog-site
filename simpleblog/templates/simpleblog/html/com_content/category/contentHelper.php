<?php

defined('_JEXEC') or die;

class ContentHelper{
	static function getToolbar() {
	   jimport('cms.html.toolbar');
	   $bar= new JToolBar( 'toolbar' );
	   $bar->appendButton( 'Standard', 'publish', 'Publish', 'publish', false );
	   $bar->appendButton( 'Standard', 'unpublish', 'Unpublish', 'unpublish', false );
	   // echo JHTML::_('icon.create', $this->category, $this->category->params);
	   return $bar->render();
	}

	function getArticlesCount($catid,$authorId=0,$all=false,$state=1)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select('count(*)')
			->from('#__content')
			->where('catid='.$catid);

		if(!$all)
			$query->where('state='.$state);
		else
			$query->where('(state=1 OR state=0)');

		if($authorId)
			$query->where('created_by='.$authorId);

		$db->setQuery($query);
		$result = $db->loadResult();
		return $result;
	}
}

