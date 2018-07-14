<?php
defined( '_JEXEC' ) or die;

class plgContentTest1 extends JPlugin
{
		public function __construct(&$subject, $config = array()) {
	     parent::__construct($subject, $config);
	 }
	
	 public function onAfterRoute() {
	     $app = JFactory::getApplication();
	     if('com_content' == JRequest::getCMD('option') && !$app->isAdmin()) {
	         require_once(dirname(__FILE__) . DS . 'comcontentoverride' . DS . 'my_content_controller.php');
	     }
	 }
}
