<?php
/**
 * @copyright	Copyright (C) 2011 Simplify Your Web, Inc. All rights reserved.
 * @license		GNU General Public License version 3 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

jimport('syw.utilities');

jimport('joomla.utilities.date');

class plgArticleDetailsHelper
{		
	static function date_to_counter($date, $date_in_future = false) {
	
		$date_origin = new JDate($date);
		$now = new JDate(); // now
		
		if ($date_in_future) {
			$difference = $date_origin->toUnix() - $now->toUnix();
		} else {
			$difference = $now->toUnix() - $date_origin->toUnix();
		}
		
		//$difference = $date_origin->diff($now); // object PHP 5.3 [y] => 0 [m] => 0 [d] => 26 [h] => 23 [i] => 11 [s] => 32 [invert] => 0 [days] => 26 
		
		$nbr_days = 0;
		$nbr_hours = 0;
		$nbr_mins = 0;
		$nbr_secs = 0;
	
		if ($difference < 60) { // less than 1 minute
			$nbr_secs = $difference;
		} else if ($difference < 3600) { // less than 1 hour
			$nbr_mins = $difference / 60;
			$nbr_secs = $difference % 60;
		} else if ($difference < 86400) { // less than 1 day
			$nbr_hours = $difference / 3600;
			$nbr_mins = ($difference % 3600) / 60;
			$nbr_secs = $difference % 60;
		} else { // 1 day or more
			$nbr_days = $difference / 86400;
			$nbr_hours = ($difference % 86400) / 3600;
			$nbr_mins = ($difference % 3600) / 60;
			$nbr_secs = $difference % 60;
		}
	
		return array('days' => $nbr_days, 'hours' => $nbr_hours, 'mins' => $nbr_mins, 'secs' => $nbr_secs);
	}
	
	static function getInfoBlock($params, $item, $item_params, $view) {
		
		$info_block = '';
		
		$infos = array();
		$empty = true;
		
		if ($params->get('info_1', 'none') != 'none') {			
			if ($params->get('info_1', 'none') != 'newline') {
				$infos[] = array($params->get('info_1', 'none'), $params->get('prepend_1'), ($params->get('show_icons_1', 0) == 1 ? true : false));
				$empty = false;
			} else {
				$infos[] = array('newline', '', false);
			}
		}
		if ($params->get('info_2', 'none') != 'none') {			
			if ($params->get('info_2', 'none') != 'newline') {
				$infos[] = array($params->get('info_2', 'none'), $params->get('prepend_2'), ($params->get('show_icons_2', 0) == 1 ? true : false));
				$empty = false;
			} else {
				$infos[] = array('newline', '', false);
			}
		}
		if ($params->get('info_3', 'none') != 'none') {
			if ($params->get('info_3', 'none') != 'newline') {
				$infos[] = array($params->get('info_3', 'none'), $params->get('prepend_3'), ($params->get('show_icons_3', 0) == 1 ? true : false));
				$empty = false;
			} else {
				$infos[] = array('newline', '', false);
			}
		}
		if ($params->get('info_4', 'none') != 'none') {
			if ($params->get('info_4', 'none') != 'newline') {
				$infos[] = array($params->get('info_4', 'none'), $params->get('prepend_4'), ($params->get('show_icons_4', 0) == 1 ? true : false));
				$empty = false;
			} else {
				$infos[] = array('newline', '', false);
			}
		}
		if ($params->get('info_5', 'none') != 'none') {
			if ($params->get('info_5', 'none') != 'newline') {
				$infos[] = array($params->get('info_5', 'none'), $params->get('prepend_5'), ($params->get('show_icons_5', 0) == 1 ? true : false));
				$empty = false;
			} else {
				$infos[] = array('newline', '', false);
			}
		}
		if ($params->get('info_6', 'none') != 'none') {
			if ($params->get('info_6', 'none') != 'newline') {
				$infos[] = array($params->get('info_6', 'none'), $params->get('prepend_6'), ($params->get('show_icons_6', 0) == 1 ? true : false));
				$empty = false;
			} else {
				$infos[] = array('newline', '', false);
			}
		}
		if ($params->get('info_7', 'none') != 'none') {
			if ($params->get('info_7', 'none') != 'newline') {
				$infos[] = array($params->get('info_7', 'none'), $params->get('prepend_7'), ($params->get('show_icons_7', 0) == 1 ? true : false));
				$empty = false;
			} else {
				$infos[] = array('newline', '', false);
			}
		}
		
		if ($empty) {
			return $info_block;
		}	
		
		$show_date = $params->get('show_d', 'date');			
		
		$date_format = JText::_('PLG_CONTENT_ARTICLEDETAILS_FORMAT_DATE');
		if (empty($date_format)) {
			$date_format = $params->get('d_format', 'd F Y');
		}
		
		$time_format = JText::_('PLG_CONTENT_ARTICLEDETAILS_FORMAT_TIME');
		if (empty($time_format)) {
			$time_format = $params->get('t_format', 'H:i');
		}
		
		$separator = htmlspecialchars($params->get('separator', ''));	
		
		$info_block .= '<p class="details">';	
		$has_info = false;	
		
		foreach ($infos as $key => $value) {
			
			switch ($value[0]) {
				case 'newline':
					$info_block .= '</p><p class="details">';
					$has_info = false;
					break;
					
				case 'hits':					
					if ($has_info && !empty($separator)) {
						$info_block .= '<span class="delimiter">'.$separator.'</span>';
					}
						
					if ($value[2]) {
							
						if ($has_info && empty($separator)) {
							$info_block .= '<span class="delimiter">&nbsp;</span>';
						}
							
						$info_block .= '<span class="SYWicon-eye"></span>';
					}
					
					$info_block .= '<span class="article_hits">';					
					
					$prepend = JText::_('PLG_CONTENT_ARTICLEDETAILS_PREPEND_HITS');
					if (empty($prepend)) {
						$prepend = $value[1];
					}
					
					if (!empty($prepend)) {
						$info_block .= $prepend;
					}
					
					$info_block .= $item->hits;					
					
					$append = JText::_('PLG_CONTENT_ARTICLEDETAILS_APPEND_HITS');
					if (!empty($append)) {
						$info_block .= $append;
					}
					
					$info_block .= '</span>';
					
					$has_info = true;
					break;
					
				case 'rating':					
					if ($has_info && !empty($separator)) {
						$info_block .= '<span class="delimiter">'.$separator.'</span>';
					}
						
					if ($value[2]) {
							
						if ($has_info && empty($separator)) {
							$info_block .= '<span class="delimiter">&nbsp;</span>';
						}
							
						$info_block .= '<span class="SYWicon-star"></span>';
					}					
					
					$info_block .= '<span class="article_rating">';					
					
					$prepend = JText::_('PLG_CONTENT_ARTICLEDETAILS_PREPEND_RATING');
					if (empty($prepend)) {
						$prepend = $value[1];
					}
						
					if (!empty($prepend)) {
						$info_block .= $prepend;
					}					
					
					if (!empty($item->rating)) {
						$info_block .= JText::sprintf('PLG_CONTENT_ARTICLEDETAILS_RATING', $item->rating);
						$info_block .= JText::sprintf('PLG_CONTENT_ARTICLEDETAILS_FROMUSERS', $item->rating_count);
					} else {
						$info_block .= JText::_('PLG_CONTENT_ARTICLEDETAILS_NORATING');
					}
					$info_block .= '</span>';
					
					$has_info = true;
					break;
					
				case 'author':					
					if ($has_info && !empty($separator)) {
						$info_block .= '<span class="delimiter">'.$separator.'</span>';
					}
						
					if ($value[2]) {
							
						if ($has_info && empty($separator)) {
							$info_block .= '<span class="delimiter">&nbsp;</span>';
						}
							
						$info_block .= '<span class="SYWicon-user"></span>';
					}					
					
					$info_block .= '<span class="article_author">';	
					
					$prepend = JText::_('PLG_CONTENT_ARTICLEDETAILS_PREPEND_AUTHOR');
					if (empty($prepend)) {
						$prepend = $value[1];
					}
					
					if (!empty($prepend)) {
						$info_block .= $prepend;
					}					
					
					$author = $item->created_by_alias ? $item->created_by_alias : $item->author;					
					
					if (!empty($item->contactid) && $item_params->get('link_author')) {
						$needle = 'index.php?option=com_contact&view=contact&id='.$item->contactid;
						$menu = JFactory::getApplication()->getMenu();
						$contact_item = $menu->getItems('link', $needle, true);
						$cntlink = !empty($contact_item) ? $needle . '&Itemid=' . $contact_item->id : $needle;
						$info_block .= JHtml::_('link', JRoute::_($cntlink), $author);
					} else {
						$info_block .= $author;					
					}
					
					$info_block .= '</span>';
					
					$has_info = true;
					break;
					
				case 'keywords':
					
					$keywords = preg_split ('/[\s]*[,][\s]*/', $item->metakey, -1, PREG_SPLIT_NO_EMPTY); // deals with "key1  ,key2,   key3  "
					
					if (!empty($keywords)) {
						if ($has_info && !empty($separator)) {
							$info_block .= '<span class="delimiter">'.$separator.'</span>';
						}
						
						if ($value[2]) {
								
							if ($has_info && empty($separator)) {
								$info_block .= '<span class="delimiter">&nbsp;</span>';
							}
								
							$info_block .= '<span class="SYWicon-tag"></span>';
						}					
						
						$info_block .= '<span class="article_keywords">';					
						
						$prepend = JText::_('PLG_CONTENT_ARTICLEDETAILS_PREPEND_KEYWORDS');
						if (empty($prepend)) {
							$prepend = $value[1];
						}
						
						if (!empty($prepend)) {
							$info_block .= $prepend;
						}
							
						// clean the keyword's list
						$i = 0;
						foreach ($keywords as $keyword) {
							if (!empty($keyword)) {
								$keyword = '<a href="'.JRoute::_('index.php?option=com_search').'?searchword='.$keyword.'&searchphrase=all">'.$keyword.'</a>';
								$info_block .= $keyword;
							}
							$i++;
							if ($i < count($keywords)) {
								if (!empty($keyword)) {
									$info_block .= ', ';
								}
							}
						}
						
						$info_block .= '</span>';
						
						$has_info = true;
					}
					break;
					
				case 'parentcategory':
					if ($item->parent_id != 1) { // do not show any parent info if the parent is root
										
						if ($has_info && !empty($separator)) {
							$info_block .= '<span class="delimiter">'.$separator.'</span>';
						}
							
						if ($value[2]) {
								
							if ($has_info && empty($separator)) {
								$info_block .= '<span class="delimiter">&nbsp;</span>';
							}
								
							$info_block .= '<span class="SYWicon-folder"></span>';
						}
					
						$info_block .= '<span class="article_parentcategory">';
						
						$prepend = JText::_('PLG_CONTENT_ARTICLEDETAILS_PREPEND_PARENTCATEGORY');
						if (empty($prepend)) {
							$prepend = $value[1];
						}
							
						if (!empty($prepend)) {
							$info_block .= $prepend;
						}
							
						if ($item_params->get('link_parent_category')) {
							if ( $view == 'article' ) {
								if (!empty($item->parent_slug)) {
									$info_block .= '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($item->parent_slug)).'">';
									$info_block .= $item->parent_title;
									$info_block .= '</a>';
								} else {
									$info_block .= $item->parent_title;
								}
							} else {
							
								// No linking if the parent category is the one the view is in
								
								$cat_link = JRoute::_(ContentHelperRoute::getCategoryRoute($item->parent_id));
								$current_link = JURI::current();
								if (substr( $current_link, strlen( $current_link ) - strlen( $cat_link ) ) != $cat_link) { // the current links does not end with the parent category link							
									$info_block .= '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($item->parent_id)).'">';
									$info_block .= $item->parent_title;
									$info_block .= '</a>';
								} else {
									$info_block .= $item->parent_title;
								}
							}
						} else {
							$info_block .= $item->parent_title;
						}
							
						$info_block .= '</span>';
							
						$has_info = true;
					}
					break;
					
				case 'category':					
					if ($has_info && !empty($separator)) {
						$info_block .= '<span class="delimiter">'.$separator.'</span>';
					}
						
					if ($value[2]) {
							
						if ($has_info && empty($separator)) {
							$info_block .= '<span class="delimiter">&nbsp;</span>';
						}
							
						$info_block .= '<span class="SYWicon-folder-open"></span>';
					}					
						
					$info_block .= '<span class="article_category">';
					
					$prepend = JText::_('PLG_CONTENT_ARTICLEDETAILS_PREPEND_CATEGORY');
					if (empty($prepend)) {
						$prepend = $value[1];
					}
						
					if (!empty($prepend)) {
						$info_block .= $prepend;
					}
					
					if ($item_params->get('link_category')) {
						if ( $view == 'article' ) {
							if (!empty($item->catslug)) {
								$info_block .= '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($item->catslug)).'">';
								$info_block .= $item->category_title;
								$info_block .= '</a>';
							} else {
								$info_block .= $item->category_title;
							}
						} else {
							
							// No linking if the category is the one the view is in
							
							$cat_link = JRoute::_(ContentHelperRoute::getCategoryRoute($item->catid));
							$current_link = JURI::current();
							if (substr( $current_link, strlen( $current_link ) - strlen( $cat_link ) ) != $cat_link) { // the current links does not end with the category link								
								$info_block .= '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($item->catid)).'">'; // keep linking in category view because of sub-categories
								$info_block .= $item->category_title;
								$info_block .= '</a>';
							} else {
								$info_block .= $item->category_title;
							}
						}
					} else {
						$info_block .= $item->category_title;
					}
					
					$info_block .= '</span>';
											
					$has_info = true;
					break;
					
				case 'combocategories':					
					if ($has_info && !empty($separator)) {
						$info_block .= '<span class="delimiter">'.$separator.'</span>';
					}
						
					if ($value[2]) {
							
						if ($has_info && empty($separator)) {
							$info_block .= '<span class="delimiter">&nbsp;</span>';
						}
							
						$info_block .= '<span class="SYWicon-folder-open"></span>';
					}						
					
					$info_block .= '<span class="article_categories">';
					
					$prepend = JText::_('PLG_CONTENT_ARTICLEDETAILS_PREPEND_COMBOCATEGORIES');
					if (empty($prepend)) {
						$prepend = $value[1];
					}
						
					if (!empty($prepend)) {
						$info_block .= $prepend;
					}				
					
					if ($item->parent_id != 1) { // do not show any parent info if the parent is root
						if ($item_params->get('link_parent_category')) {
							if ( $view == 'article' ) {
								if (!empty($item->parent_slug)) {
									$info_block .= '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($item->parent_slug)).'">';
									$info_block .= $item->parent_title;
									$info_block .= '</a>';
									$info_block .= '</a>';
									$info_block .= JText::_('PLG_CONTENT_ARTICLEDETAILS_COMBOCATEGORIESSEPARATOR');
								} else {
									$info_block .= $item->parent_title;
									$info_block .= JText::_('PLG_CONTENT_ARTICLEDETAILS_COMBOCATEGORIESSEPARATOR');
								}
							} else {
									
								// No linking if the parent category is the one the view is in
						
								$cat_link = JRoute::_(ContentHelperRoute::getCategoryRoute($item->parent_id));
								$current_link = JURI::current();
								if (substr( $current_link, strlen( $current_link ) - strlen( $cat_link ) ) != $cat_link) { // the current links does not end with the parent category link
									$info_block .= '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($item->parent_id)).'">';
									$info_block .= $item->parent_title;
									$info_block .= '</a>';
									$info_block .= JText::_('PLG_CONTENT_ARTICLEDETAILS_COMBOCATEGORIESSEPARATOR');
								} else {
									$info_block .= $item->parent_title;
									$info_block .= JText::_('PLG_CONTENT_ARTICLEDETAILS_COMBOCATEGORIESSEPARATOR');
								}
							}
						} else {
							$info_block .= $item->parent_title;
							$info_block .= JText::_('PLG_CONTENT_ARTICLEDETAILS_COMBOCATEGORIESSEPARATOR');
						}
					}
					
					if ($item_params->get('link_category')) {
						if ( $view == 'article' ) {
							if (!empty($item->catslug)) {
								$info_block .= '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($item->catslug)).'">';
								$info_block .= $item->category_title;
								$info_block .= '</a>';
							} else {
								$info_block .= $item->category_title;
							}
						} else {
								
							// No linking if the category is the one the view is in
								
							$cat_link = JRoute::_(ContentHelperRoute::getCategoryRoute($item->catid));
							$current_link = JURI::current();
							if (substr( $current_link, strlen( $current_link ) - strlen( $cat_link ) ) != $cat_link) { // the current links does not end with the category link
								$info_block .= '<a href="'.JRoute::_(ContentHelperRoute::getCategoryRoute($item->catid)).'">'; // keep linking in category view because of sub-categories
								$info_block .= $item->category_title;
								$info_block .= '</a>';
							} else {
								$info_block .= $item->category_title;
							}
						}
					} else {
						$info_block .= $item->category_title;
					}
					
					$info_block .= '</span>';
											
					$has_info = true;
					break;
					
				case 'tags':	
				case 'linkedtags':	
							
					$isjoomla3plus = SYWUtilities::isJoomla3();
					if ($isjoomla3plus && isset($item->tags) && !empty($item->tags->itemTags)) {
			
						if ($value[0] != 'tags') {
							JLoader::register('TagsHelperRoute', JPATH_BASE . '/components/com_tags/helpers/route.php');
						}
			
						if ($has_info && !empty($separator)) {
							$info_block .= '<span class="delimiter">'.$separator.'</span>';
						}
			
						if ($value[2]) {
								
							if ($has_info && empty($separator)) {
								$info_block .= '<span class="delimiter">&nbsp;</span>';
							}
								
							$info_block .= '<span class="SYWicon-tags"></span>';
						}
			
						$info_block .= '<span class="article_tags">';
			
						$prepend = $value[1];
			
						if (!empty($prepend)) {
							$info_block .= $prepend;
						}
			
						$info_block_tags = '';
						foreach ($item->tags->itemTags as $tag) {
							if ($value[0] == 'tags') {
								$info_block_tags .= $tag->title.', ';
							} else {
								$info_block_tags .= '<a href="'.JRoute::_(TagsHelperRoute::getTagRoute($tag->id . ':' . $tag->alias)).'">';
								$info_block_tags .= $tag->title;
								$info_block_tags .= '</a>, ';
							}
						}
							
						$info_block .= rtrim($info_block_tags, ' ,');
							
						$info_block .= '</span>';
			
						$has_info = true;
					}
					break;
					
				case 'created':
				case 'modified':
				case 'published':
					
					$date = $item->publish_up;
					if ($value[0] == 'created') {
						$date = $item->created;
					} else if ($value[0] == 'modified') {
						$date = $item->modified;
					}
					
					$db = JFactory::getDbo();
					
					if ($date == $db->getNullDate() || empty($date)) {
						$info_block .= '<span class="article_nodate"></span>';
					} else {
						if ($has_info && !empty($separator)) {
							$info_block .= '<span class="delimiter">'.$separator.'</span>';
						}
						
						if ($value[2]) {
							
							if ($has_info && empty($separator)) {
								$info_block .= '<span class="delimiter">&nbsp;</span>';
							}
							
							$info_block .= '<span class="SYWicon-calendar"></span>';
						}						
						
						$info_block .= '<span class="article_date">';
						
						$prepend = JText::_('PLG_CONTENT_ARTICLEDETAILS_PREPEND_PUBLISHED');
						if ($value[0] == 'created') {
							$prepend = JText::_('PLG_CONTENT_ARTICLEDETAILS_PREPEND_CREATED');
						} else if ($value[0] == 'modified') {
							$prepend = JText::_('PLG_CONTENT_ARTICLEDETAILS_PREPEND_MODIFIED');
						}					
						
						if (empty($prepend)) {
							$prepend = $value[1];
						}
							
						if (!empty($prepend)) {
							$info_block .= $prepend;
						}
						
						$nbr_seconds = -1;
						$nbr_minutes = -1;
						$nbr_hours = -1;
						$nbr_days = -1;
						
						if ($show_date == 'ago' || $show_date == 'agomhd' || $show_date == 'agohm') {
							if (!empty($date)) {
								$details = self::date_to_counter($date, false);
						
								$nbr_seconds  = intval($details['secs']);
								$nbr_minutes  = intval($details['mins']);
								$nbr_hours = intval($details['hours']);
								$nbr_days = intval($details['days']);
							}
						}		
						
						if ($show_date == 'date') {
							$info_block .= JHTML::_('date', $date, $date_format);
						} else if ($show_date == 'ago') {
							if ($nbr_days == 0) {
								$info_block .= JText::_('PLG_CONTENT_ARTICLEDETAILS_TODAY');
							} else if ($nbr_days == 1) {
								$info_block .= JText::_('PLG_CONTENT_ARTICLEDETAILS_YESTERDAY');
							} else {
								$info_block .= JText::sprintf('PLG_CONTENT_ARTICLEDETAILS_DAYSAGO', $nbr_days);
							}
						} else if ($show_date == 'agomhd') {
							if ($nbr_days > 0) {
								if ($nbr_days == 1) {
									$info_block .= JText::_('PLG_CONTENT_ARTICLEDETAILS_DAYAGO');
								} else {
									$info_block .= JText::sprintf('PLG_CONTENT_ARTICLEDETAILS_DAYSAGO', $nbr_days);
								}
							} else if ($nbr_hours > 0) {
								if ($nbr_hours == 1) {
									$info_block .= JText::_('PLG_CONTENT_ARTICLEDETAILS_HOURAGO');
								} else {
									$info_block .= JText::sprintf('PLG_CONTENT_ARTICLEDETAILS_HOURSAGO', $nbr_hours);
								}
							} else {
								if ($nbr_minutes == 1) {
									$info_block .= JText::_('PLG_CONTENT_ARTICLEDETAILS_MINUTEAGO');
								} else {
									$info_block .= JText::sprintf('PLG_CONTENT_ARTICLEDETAILS_MINUTESAGO', $nbr_minutes);
								}
							}
						} else {
							if ($nbr_days > 0) {
								$info_block .= JText::sprintf('PLG_CONTENT_ARTICLEDETAILS_DAYSHOURSMINUTESAGO', $nbr_days, $nbr_hours, $nbr_minutes);
							} else if ($nbr_hours > 0) {
								$info_block .= JText::sprintf('PLG_CONTENT_ARTICLEDETAILS_HOURSMINUTESAGO', $nbr_hours, $nbr_minutes);
							} else {
								if ($nbr_minutes == 1) {
									$info_block .= JText::_('PLG_CONTENT_ARTICLEDETAILS_MINUTEAGO');
								} else {
									$info_block .= JText::sprintf('PLG_CONTENT_ARTICLEDETAILS_MINUTESAGO', $nbr_minutes);
								}
							}
						}
						$info_block .= '</span>';
						$has_info = true;
					}
					break;	
									
				case 'finished':
					$db = JFactory::getDbo();
					
					if ($item->publish_down == $db->getNullDate() || empty($item->publish_down)) {
						$info_block .= '<span class="article_nodate"></span>';
					} else {					
						if ($has_info && !empty($separator)) {
							$info_block .= '<span class="delimiter">'.$separator.'</span>';
						}
							
						if ($value[2]) {
								
							if ($has_info && empty($separator)) {
								$info_block .= '<span class="delimiter">&nbsp;</span>';
							}
								
							$info_block .= '<span class="SYWicon-calendar"></span>';
						}	
				
						$info_block .= '<span class="article_date">';
						
						$prepend = JText::_('PLG_CONTENT_ARTICLEDETAILS_PREPEND_FINISHED');						
						if (empty($prepend)) {
							$prepend = $value[1];
						}
							
						if (!empty($prepend)) {
							$info_block .= $prepend;
						}
						
						$nbr_seconds = -1;
						$nbr_minutes = -1;
						$nbr_hours = -1;
						$nbr_days = -1;
						
						if ($show_date == 'ago' || $show_date == 'agomhd' || $show_date == 'agohm') {
							if (!empty($item->publish_down)) {
								$details = self::date_to_counter($item->publish_down, true);
						
								$nbr_seconds = intval($details['secs']);
								$nbr_minutes = intval($details['mins']);
								$nbr_hours = intval($details['hours']);
								$nbr_days = intval($details['days']);
							}
						}						
						
						if ($show_date == 'date') {
							$info_block .= JHTML::_('date', $item->publish_down, $date_format);
						} else if ($show_date == 'ago') {
							if ($nbr_days == 0) {
								$info_block .= JText::_('PLG_CONTENT_ARTICLEDETAILS_TODAY');
							} else if ($nbr_days == 1) {
								$info_block .= JText::_('PLG_CONTENT_ARTICLEDETAILS_TOMORROW');
							} else {
								$info_block .= JText::sprintf('PLG_CONTENT_ARTICLEDETAILS_INDAYSONLY', $nbr_days);
							}
						} else if ($show_date == 'agomhd') {
							if ($nbr_days > 0) {
								if ($nbr_days == 1) {
									$info_block .= JText::_('PLG_CONTENT_ARTICLEDETAILS_INADAY');
								} else {
									$info_block .= JText::sprintf('PLG_CONTENT_ARTICLEDETAILS_INDAYSONLY', $nbr_days);
								}
							} else if ($nbr_hours > 0) {
								if ($nbr_hours == 1) {
									$info_block .= JText::_('PLG_CONTENT_ARTICLEDETAILS_INANHOUR');
								} else {
									$info_block .= JText::sprintf('PLG_CONTENT_ARTICLEDETAILS_INHOURS', $nbr_hours);
								}
							} else {
								if ($nbr_minutes == 1) {
									$info_block .= JText::_('PLG_CONTENT_ARTICLEDETAILS_INAMINUTE');
								} else {
									$info_block .= JText::sprintf('PLG_CONTENT_ARTICLEDETAILS_INMINUTES', $nbr_minutes);
								}
							}
						} else {
							if ($nbr_days > 0) {
								$info_block .= JText::sprintf('PLG_CONTENT_ARTICLEDETAILS_INDAYSHOURSMINUTES', $nbr_days, $nbr_hours, $nbr_minutes);
							} else if ($nbr_hours > 0) {
								$info_block .= JText::sprintf('PLG_CONTENT_ARTICLEDETAILS_INHOURSMINUTES', $nbr_hours, $nbr_minutes);
							} else {
								if ($nbr_minutes == 1) {
									$info_block .= JText::_('PLG_CONTENT_ARTICLEDETAILS_INAMINUTE');
								} else {
									$info_block .= JText::sprintf('PLG_CONTENT_ARTICLEDETAILS_INMINUTES', $nbr_minutes);
								}
							}
						}
						$info_block .= '</span>';
						$has_info = true;
					}
					break;
					
				case 'createdtime':
				case 'modifiedtime':
				case 'publishedtime':
				case 'finishedtime':
						
					$date = $item->publish_up;
					if ($value[0] == 'createdtime') {
						$date = $item->created;
					} else if ($value[0] == 'modifiedtime') {
						$date = $item->modified;
					} else if ($value[0] == 'finishedtime') {
						$date = $item->publish_down;
					}
						
					$db = JFactory::getDbo();
						
					if ($date == $db->getNullDate() || empty($date)) {
						$info_block .= '<span class="article_notime"></span>';
					} else {
						if ($has_info && !empty($separator)) {
							$info_block .= '<span class="delimiter">'.$separator.'</span>';
						}
				
						if ($value[2]) {
								
							if ($has_info && empty($separator)) {
								$info_block .= '<span class="delimiter">&nbsp;</span>';
							}
								
							$info_block .= '<span class="SYWicon-clock"></span>';
						}
				
						$info_block .= '<span class="article_time">';						
						
						$prepend = JText::_('PLG_CONTENT_ARTICLEDETAILS_PREPEND_PUBLISHEDTIME');
						if ($value[0] == 'createdtime') {
							$prepend = JText::_('PLG_CONTENT_ARTICLEDETAILS_PREPEND_CREATEDTIME');
						} else if ($value[0] == 'modifiedtime') {
							$prepend = JText::_('PLG_CONTENT_ARTICLEDETAILS_PREPEND_MODIFIEDTIME');
						} else if ($value[0] == 'finishedtime') {
							$prepend = JText::_('PLG_CONTENT_ARTICLEDETAILS_PREPEND_FINISHEDTIME');
						}
						
						if (empty($prepend)) {
							$prepend = $value[1];
						}
							
						if (!empty($prepend)) {
							$info_block .= $prepend;
						}
							
						$info_block .= JHTML::_('date', $date, $time_format);
						
						$info_block .= '</span>';
						$has_info = true;
					}
					break;
					
				default:
					break;
			}
		}
		
		$info_block .= '</p>';
		
		return $info_block;
	}
	
}
?>