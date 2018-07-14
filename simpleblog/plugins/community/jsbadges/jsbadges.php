<?php
/**
 * @version $Id: jsbadges.php
 * @copyright CoreJoomla
 * @license GNU/GPLv2,
 * @author CoreJoomla - http://www.corejoomla.com
 */
 
defined('_JEXEC') or die('Restricted access');
defined('CJBLOG') or define('CJBLOG', 'com_cjblog');

require_once( JPATH_ROOT.'/components/com_community/libraries/core.php');
require_once JPATH_ROOT.'/components/'.CJBLOG.'/api.php';
require_once JPATH_ROOT.'/components/'.CJBLOG.'/router.php';

class plgCommunityJsBadges extends CApplications
{
	var $name = "JsBadges";
	var $_name = 'jsbadges';
	
	function plgCommunityJsBadges($subject, $config)
	{
		parent::__construct($subject, $config);
	}
	
	function onProfileDisplay()
	{
		$config	= CFactory::getConfig();
 		$db = JFactory::getDBO();
 		
		$uri	= JURI::base();
		$my		= JFactory::getUser();
		$user	= CFactory::getActiveProfile();
		
		$badges = CjBlogApi::get_user_badges($user->id, 0, 20);
		$itemid = CJFunctions::get_active_menu_id(true, 'index.php?option='.CJBLOG.'&view=users');

		ob_start();
		echo '
		<style type="text/css">
		<!--
		ul.badges, ul.badges li {list-style: none; list-style-image: none; list-style-type: none;}
		ul.badges li {margin-right: 10px; }
		-->
		</style>
		
		<div id="cj-wrapper" class="cj-wrapper-main">';
		
		if(!empty($badges))
		{
			echo '<ul class="badges unstyled clearfix">';
			
			foreach ($badges as $badge)
			{
				$url = JRoute::_('index.php?option='.CJBLOG.'&view=users&task=badge&id='.$badge['badge_id'].':'.$badge['alias'].$itemid);
				echo 
				'<li>
					<a href="'.$url.'" class="tooltip-hover" title="'.htmlspecialchars($badge['description'], ENT_COMPAT, 'UTF-8').'">';
						if(!empty($badge['icon']))
						{
							echo '<img src="'.CJBLOG_BADGES_BASE_URI.$badge['icon'].'"/>';
						} else {
							echo '<span class="badge '.$badge['css_class'].'">&bull; '.htmlspecialchars($badge['title'], ENT_COMPAT, 'UTF-8').'</span>';
						}
					echo 
					'</a>';
					
					if($badge['num_times'] > 1)
					{
						echo '<small> x '.$badge['num_times'].'</small>';
					}
				echo 
				'</li>';
			}
			echo '</ul>';
		}
		else
		{
			echo '<p>'.JText::_('LBL_NO_RESULTS_FOUND').'</p>';
		}
		echo '</div>';
		
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}
}
?>