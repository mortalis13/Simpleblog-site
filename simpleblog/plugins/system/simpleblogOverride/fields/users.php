<?php

defined('JPATH_BASE') or die;

jimport('joomla.form.formfield');
JFormHelper::loadFieldClass('list');

class JFormFieldUsers extends JFormFieldList
{
		protected $type = 'Users';

		public function getOptions()
		{
			// Initialize variables.
			$options = array();
	 
			$db	= JFactory::getDbo();
			$query	= $db->getQuery(true);
	 
			$query->select('id,name');
			$query->from('#__users');

			// Get the options.
			$db->setQuery($query);
	 
			$options = $db->loadObjectList();
	 
			// Check for a database error.
			if ($db->getErrorNum()) {
				JError::raiseWarning(500, $db->getErrorMsg());
			}
	 
			return $options;
		}
}
