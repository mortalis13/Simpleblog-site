<?php
/**
 * @copyright	Copyright (C) 2011 Simplify Your Web, Inc. All rights reserved.
 * @license		GNU General Public License version 3 or later; see LICENSE.txt
*/

// no direct access
defined( '_JEXEC' ) or die;

jimport('joomla.form.formfield');

class JFormFieldStyleSelect extends JFormField
{
	protected $type = 'StyleSelect';

	protected function getInput() {
		
		jimport('joomla.filesystem.folder');		
		
		$lang = JFactory::getLanguage();
		
		$object = trim($this->element['object']);
		
		$path = '/plugins/content/articledetails/styles/'.$object;		
		
		$optionsArray = JFolder::folders(JPATH_SITE.$path);
		
		foreach($optionsArray as $option) {
			$upper_option = strtoupper($option);
			$upper_object = strtoupper($object);
			
			if ($upper_option != 'ORIGINAL') {
				$lang->load('plg_content_articledetails_style_'.$object.'_'.$option);
			}
			
			$translated_option = JText::_('PLG_CONTENT_ARTICLEDETAILS_STYLE_'.$upper_object.'_'.$upper_option.'_LABEL');
				
			if (empty($translated_option) || substr_count($translated_option, 'ARTICLEDETAILS') > 0) {				
				$translated_option = ucfirst($option);
			}
			
			$options[] = JHTML::_('select.option', $option, $translated_option, 'value', 'text', $disable=false );
		}
		
		$attributes = 'class="inputbox"';

		return JHTML::_('select.genericlist', $options, $this->name, $attributes, 'value', 'text', $this->value, $this->id);
	}
}
?>