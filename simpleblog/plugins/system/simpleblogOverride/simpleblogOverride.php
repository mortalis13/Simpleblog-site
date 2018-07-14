<?php
	defined('_JEXEC') or die;

  $app=JFactory::getApplication();
  if($app->getName()!='site') return;

  // include_once JPATH_ROOT.'/plugins/system/simpleblogOverride/view.feed.php';
  // include_once JPATH_ROOT.'/plugins/system/simpleblogOverride/view.html.php';
  
  include_once JPATH_ROOT.'/plugins/system/simpleblogOverride/controller.php';
  include_once JPATH_ROOT.'/plugins/system/simpleblogOverride/category.php';
  include_once JPATH_ROOT.'/plugins/system/simpleblogOverride/icon.php';
	include_once JPATH_ROOT.'/plugins/system/simpleblogOverride/fields/users.php';
