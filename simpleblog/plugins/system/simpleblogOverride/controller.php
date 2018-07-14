<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * Content Component Controller
 *
 * @package     Joomla.Site
 * @subpackage  com_content
 * @since       1.5
 */
class ContentController extends JControllerLegacy
{
	public function __construct($config = array())
	{
		$this->input = JFactory::getApplication()->input;

		// Article frontpage Editor pagebreak proxying:
		if ($this->input->get('view') === 'article' && $this->input->get('layout') === 'pagebreak')
		{
			$config['base_path'] = JPATH_COMPONENT_ADMINISTRATOR;
		}
		// Article frontpage Editor article proxying:
		elseif ($this->input->get('view') === 'articles' && $this->input->get('layout') === 'modal')
		{
			JHtml::_('stylesheet', 'system/adminlist.css', array(), true);
			$config['base_path'] = JPATH_COMPONENT_ADMINISTRATOR;
		}

		parent::__construct($config);
	}

	/**
	 * Method to display a view.
	 *
	 * @param   boolean			If true, the view output will be cached
	 * @param   array  An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return  JController		This object to support chaining.
	 * @since   1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
		$cachable = true;

		// Set the default view name and format from the Request.
		// Note we are using a_id to avoid collisions with the router and the return page.
		// Frontend is a bit messier than the backend.
		$id    = $this->input->getInt('a_id');
		$vName = $this->input->getCmd('view', 'categories');
		$this->input->set('view', $vName);

		$user = JFactory::getUser();

		if ($user->get('id') ||
			($this->input->getMethod() == 'POST' &&
				(($vName == 'category' && $this->input->get('layout') != 'blog') || $vName == 'archive' )))
		{
			$cachable = false;
		}

		$safeurlparams = array('catid' => 'INT', 'id' => 'INT', 'cid' => 'ARRAY', 'year' => 'INT', 'month' => 'INT', 'limit' => 'UINT', 'limitstart' => 'UINT',
			'showall' => 'INT', 'return' => 'BASE64', 'filter' => 'STRING', 'filter_order' => 'CMD', 'filter_order_Dir' => 'CMD', 'filter-search' => 'STRING', 'print' => 'BOOLEAN', 'lang' => 'CMD', 'Itemid' => 'INT');

		// Check for edit form.
		if ($vName == 'form' && !$this->checkEditId('com_content.edit.article', $id))
		{
			// Somehow the person just went to the form - we don't allow that.
			return JError::raiseError(403, JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
		}

		parent::display($cachable, $safeurlparams);

		return $this;
	}

	protected function setPublishState($state){
		$app = JFactory::getApplication();
		JFactory::getLanguage()->load('plg_system_simpleblogOverride');

    $data= $app->input->post->getArray(array());
    $ids=JRequest::getVar('cid');
		$db = JFactory::getDbo();

		$where='id='.$ids[0];
		for ($i=1; $i < count($ids); $i++) { 
			$where.=' OR id='.$ids[$i];
		}

		$query=$db->getQuery(true);
		$query->update('#__content')->set('state='.$state)->where($where);
		$db->setQuery($query);
		$db->execute();

		switch ($state) {
			case 0:
				$state="unpublished";
				$msg=JText::_('PLG_SYSTEM_SIMPLEBLOGOVERRIDE_TASK_UNPUBLISH_SUCCESS');
				break;
			case 1:
				$state="published";
				$msg=JText::_('PLG_SYSTEM_SIMPLEBLOGOVERRIDE_TASK_PUBLISH_SUCCESS');
				break;
		}
		$app->enqueueMessage($msg, 'success');

		$url=$this->getReturnURL($app);
		$app->redirect($url);
	}

	protected function getReturnURL($app){
		$router = $app::getRouter();
    $uri = clone JUri::getInstance();
    $vars = $router->parse($uri);

    unset($vars['task']);
    unset($vars['aid']);

    $url = 'index.php?' . JUri::buildQuery($vars);
		$url = JRoute::_($url, false);
		return $url;
	}

	public function delete(){
		$app = JFactory::getApplication();
		JFactory::getLanguage()->load('plg_system_simpleblogOverride');

		$id=$app->input->get('aid');
		$db = JFactory::getDbo();

		$query=$db->getQuery(true);
		$query->delete('#__content')->where('id='.$id);
		$db->setQuery($query);
		$db->execute();

		$msg=JText::_('PLG_SYSTEM_SIMPLEBLOGOVERRIDE_TASK_DELETE_SUCCESS');
		$app->enqueueMessage($msg, 'success');

		$url=$this->getReturnURL($app);
		$app->redirect($url);
	}

	public function deleteBySelection(){
		$app = JFactory::getApplication();
		JFactory::getLanguage()->load('plg_system_simpleblogOverride');

    $data= $app->input->post->getArray(array());
    $ids=JRequest::getVar('cid');
		$db = JFactory::getDbo();

		$where='id='.$ids[0];
		for ($i=1; $i < count($ids); $i++) { 
			$where.=' OR id='.$ids[$i];
		}

		$query=$db->getQuery(true);
		$query->delete('#__content')->where($where);
		$db->setQuery($query);
		$db->execute();

		$msg=JText::_('PLG_SYSTEM_SIMPLEBLOGOVERRIDE_TASK_DELETE_SELECTION_SUCCESS');
		$app->enqueueMessage($msg, 'success');

		$url=$this->getReturnURL($app);
		$app->redirect($url);
	}

	public function unpublish(){
		$this->setPublishState(0);
	}

	public function publish(){
		$this->setPublishState(1);
	}

	public function test1(){
		$db = JFactory::getDbo();

		$query=$db->getQuery(true);
		$query->insert('test')->columns('id')->values(13);
		$db->setQuery($query);
		$db->execute();

		$url = JRoute::_('index.php?option=com_content&view=category&id=8&Itemid=116', false);
		$app->redirect($url);
	}		
}
