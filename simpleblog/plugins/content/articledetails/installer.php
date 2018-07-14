<?php
/**
 * @copyright	Copyright (C) 2011 Simplify Your Web, Inc. All rights reserved.
 * @license		GNU General Public License version 3 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die;

/**
 * Script file of the Article Details plugin
 */
class plgcontentarticledetailsInstallerScript
{	
	static $minimum_needed_library_version = '1.1.2';
	static $download_link = 'http://www.simplifyyourweb.com/index.php/downloads/category/23-libraries';
	
	/**
	 * Called before an install/update/uninstall method
	 *
	 * @return  boolean  True on success
	 */
	public function preflight($type, $parent) 
	{
		echo '<br />';
	}
	
	/**
	 * Called after an install/update/uninstall method
	 *
	 * @return  boolean  True on success
	 */
	public function postflight($type, $parent) 
	{			
		if ($type != 'uninstall') {
			
			$version = new JVersion();
			$jversion = explode('.', $version->getShortVersion());
			
// 			if (intval($jversion[0]) > 2) {
// 				echo '<div style="padding: 0 0 20px 0; text-align: center">';
// 			} else {
// 				echo '<div style="padding: 0 0 20px 0">';
// 			}
			
// 			echo '<img src="../plugins/content/articledetails/images/logo.png" style="float: none" />';
// 			echo '<br /><br />'.JText::_('PLG_CONTENT_ARTICLEDETAILS_VERSION');
// 			echo '<br /><br />Olivier Buisard @ <a href="http://www.simplifyyourweb.com" target="_blank">Simplify Your Web</a>';
// 			echo '</div>';
			
			// upgrade warning
			
			$class_warning = '';
			$style_warning = '';
			
			$class_success = '';
			$style_success = '';
			
			if (intval($jversion[0]) > 2) {
				$class_warning = 'alert alert-warning';
				$class_success = 'alert alert-success';
			} else {
				$style_warning = 'margin: 5px 0; padding: 8px 35px 8px 14px; border-radius: 4px; border: 1px solid #FBEED5; background-color: #FCF8E3; color: #C09853;';
				$style_success = 'margin: 5px 0; padding: 8px 35px 8px 14px; border-radius: 4px; border: 1px solid #D6E9C6; background-color: #DFF0D8; color: #468847;';
			}
			
			echo '<div class="'.$class_warning.'" style="'.$style_warning.'">';
			echo '    <span>'.JText::_('PLG_CONTENT_ARTICLEDETAILS_WARNING_RELEASENOTES').'</span>';
			echo '</div>';

			// check if syw library is present
			
			if (!JFolder::exists(JPATH_ROOT.'/libraries/syw')) {			
				echo '<div class="'.$class_warning.'" style="'.$style_warning.'">';
				echo '    <span>'.JText::_('SYW_MISSING_SYWLIBRARY').'</span><br />';
				echo '    <a href="'.self::$download_link.'" target="_blank">'.JText::_('SYW_DOWNLOAD_SYWLIBRARY').'</a>';
				echo '</div>';
			} else {
				jimport('syw.version');			
				if (SYWVersion::isCompatible(self::$minimum_needed_library_version)) {
					echo '<div class="'.$class_success.'" style="'.$style_success.'">';
					echo '    <span>'.JText::_('SYW_COMPATIBLE_SYWLIBRARY').'</span>';
					echo '</div>';
				} else {
					echo '<div class="'.$class_warning.'" style="'.$style_warning.'">';
					echo '    <span>'.JText::_('SYW_NONCOMPATIBLE_SYWLIBRARY').'</span><br />';
					echo '    <span>'.JText::_('SYW_UPDATE_SYWLIBRARY').JText::_('SYW_OR').'</span>';
					echo '    <a href="'.self::$download_link.'" target="_blank">'.strtolower(JText::_('SYW_DOWNLOAD_SYWLIBRARY')).'</a>';
					echo '</div>';
				}
			}
		}
		
		return true;
	}	
	
	/**
	 * Called on installation
	 *
	 * @return  boolean  True on success
	 */
	public function install($parent) {}
	
	/**
	 * Called on update
	 *
	 * @return  boolean  True on success
	 */
	public function update($parent) {}
	
	/**
	 * Called on uninstallation
	 */
	public function uninstall($parent) {}
	
}
?>