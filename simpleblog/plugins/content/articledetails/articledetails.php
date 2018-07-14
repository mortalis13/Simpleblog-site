<?php
/**
 * @copyright	Copyright (C) 2011 Simplify Your Web, Inc. All rights reserved.
 * @license		GNU General Public License version 3 or later; see LICENSE.txt
*/

// no direct access
defined( '_JEXEC' ) or die;

// import library dependencies
jimport('joomla.plugin.plugin');

jimport('syw.fonts');
jimport('syw.image');
jimport('syw.utilities');

require_once (dirname(__FILE__).'/helpers/helper.php');

class plgContentArticleDetails extends JPlugin
{
	static $_style_path = '';
	static $_style = '';
	
	public function __construct(&$subject, $config)
	{
		parent::__construct( $subject, $config );
		$this->loadLanguage();
	}
	
	public function onContentAfterDisplay($context, &$row, &$params, $page=0)
	{
		// for content after the article (like author)
		$html = '';
		
		$canProceed = ($context == 'com_content.article');
		if (!$canProceed) {
			return $html;
		}		
		
		$app = JFactory::getApplication();
		
		$view = $app->input->getCmd('view', '');
		if ($view == 'article') {
			//$html .= '<p>Test after article</p>';
		}
		
		return $html;
	}
	
	public function onContentBeforeDisplay($context, &$row, &$params, $page=0)
	{
		$html = '';
		
		$canProceed = ($context == 'com_content.article' || $context == 'com_content.category' || $context == 'com_content.featured');
		if (!$canProceed) {
			return $html;
		}
		
		$app = JFactory::getApplication();
		
		$view = $app->input->getCmd('view', '');
		if ($view == 'article' || $view == 'category' || $view == 'featured') {			
			
			$found_category = false;
			
			$categories_array = $this->params->get('catid', array());
			
			$array_of_category_values = array_count_values($categories_array);
			if (isset($array_of_category_values['all']) && $array_of_category_values['all'] > 0) { // 'all' was selected
				$found_category = true;
			} else {
				// sub-category inclusion
				$get_sub_categories = $this->params->get('includesubcategories', 'no');
				if ($get_sub_categories != 'no') {
					$categories_object = JCategories::getInstance('Content');
					foreach ($categories_array as $category) {
						$category_object = $categories_object->get($category); // if category unpublished, unset
						if (isset($category_object) && $category_object->hasChildren()) {
							if ($get_sub_categories == 'all') {
								$sub_categories_array = $category_object->getChildren(true); // true is for recursive
							} else {
								$sub_categories_array = $category_object->getChildren();
							}
							foreach ($sub_categories_array as $subcategory_object) {
								$categories_array[] = $subcategory_object->id;
							}
						}
					}
					$categories_array = array_unique($categories_array);
				}
					
				foreach ($categories_array as $category) {
					if ($row->catid == intval($category)) {
						$found_category = true;
					}
				}
			}			
			
			if (!$found_category) {
				return $html;				
			}
			
			$path = "plugins/content/articledetails/";
			$urlPath = JURI::base().$path;

			jimport('joomla.environment.browser');
			$browser = JBrowser::getInstance();
			$browser_name = $browser->getBrowser();
			$browser_version = $browser->getVersion();
			
			$ie = -1;
			if ($browser_name == 'msie') {
				switch ($browser_version) {
					case '7.0': $ie = 7; break;
					case '8.0': $ie = 8; break;
					case '9.0': $ie = 9; break;
					default: $ie = -1; break;
				}
			}
			
			// parameters
			
			$head_type = $this->params->get('head_type', 'none');
			$head_width = $this->params->get('head_w', 64);
			$head_height = $this->params->get('head_h', 80);
			
			$title_html_tag = $this->params->get('t_tag', '2');
				
			$font_details = $this->params->get('d_f', 80);
			
			$iconfont_color = str_replace('#', '', trim($this->params->get('iconscolor', '#000000')));
			
			$postdate = $this->params->get('post_d', 'published');
			
			$calendar_date = $row->publish_up;
			if ($postdate == 'created') {
				$calendar_date = $row->created;
			} else if ($postdate == 'modified') {
				$calendar_date = $row->modified;
			} else if ($postdate == 'finished') {
				$calendar_date = $row->publish_down;
			}
			
			$db = JFactory::getDbo();
				
			if ($calendar_date == $db->getNullDate()) {
				$calendar_date = null;
			}
			
			$show_calendar = false;
			if ($head_type == "calendar") {
				$show_calendar = true;
			}
			
			if ($show_calendar && !empty($calendar_date)) {
				
				$calendar_style = $this->params->get('cal_style', 'original');
				$weekday_format = $this->params->get('fmt_w', 'D');
				$month_format = $this->params->get('fmt_m', 'M');
				$day_format = $this->params->get('fmt_d', 'd');
				
				$time_format = JText::_('PLG_CONTENT_ARTICLEDETAILS_FORMAT_TIME');
				if (empty($time_format)) {
					$time_format = $this->params->get('t_format', 'H:i');
				}
			
				$color1 = str_replace('#', '', trim($this->params->get('c1', '#3D3D3D')));
				$color2 = str_replace('#', '', trim($this->params->get('c2', '#494949')));
				$color3 = str_replace('#', '', trim($this->params->get('c3', '#494949')));
				$bgcolor11 = str_replace('#', '', trim($this->params->get('bgc11', '')));
				$bgcolor12 = str_replace('#', '', trim($this->params->get('bgc12', '')));
				$bgcolor21 = str_replace('#', '', trim($this->params->get('bgc21', '')));
				$bgcolor22 = str_replace('#', '', trim($this->params->get('bgc22', '')));
				$bgcolor31 = str_replace('#', '', trim($this->params->get('bgc31', '')));
				$bgcolor32 = str_replace('#', '', trim($this->params->get('bgc32', '')));
			
				$shadow_w = $this->params->get('sh_w', 0);
				$border_w = $this->params->get('border_w', 0);
				$border_r = $this->params->get('border_r', 0);
				$font_ref_cal = $this->params->get('f_r', 14);
			
				$position_1 = $this->params->get('pos_1', 'w');
				$position_2 = $this->params->get('pos_2', 'd');
				$position_3 = $this->params->get('pos_3', 'm');
				$position_4 = $this->params->get('pos_4', 'y');
				$position_5 = $this->params->get('pos_5', 't');
								
				jimport('joomla.utilities.date');
				
				$keys = array($position_1, $position_2, $position_3, $position_4, $position_5);
				$date_params_keys = array();
				$date_params_values = array();
			
				foreach ($keys as $key) {
					switch ($key) {
						case 'w' :
							$date_params_keys[] = 'weekday';
							break;
						case 'd' :
							$date_params_keys[] = 'day';
							break;
						case 'm' :
							$date_params_keys[] = 'month';
							break;
						case 'y' :
							$date_params_keys[] = 'year';
							break;
						case 't' :
							$date_params_keys[] = 'time';
							break;
						case 'e' :
							$date_params_keys[] = 'empty';
							break;
						default : $date_params_keys[] = '';
						break;
					}
				}
				
				$article_date = new JDate($calendar_date);
					
				$date_params_values["weekday"] = $article_date->format($weekday_format); // 3 letters or full - translate from language .ini file
				$date_params_values["day"] = $article_date->format($day_format); // 01-31 or 1-31
				$date_params_values["month"] = $article_date->format($month_format);
				$date_params_values["year"] = $article_date->format('Y');
				$date_params_values["time"] = JHTML::_('date', $calendar_date, $time_format); //date_format(new DateTime($calendar_date), $time_format);
				$date_params_values["empty"] = '&nbsp;';
			}
			
			$info_block_placement = $this->params->get('detailsplace', 'after');
			
			// create block
			
			$html .= '<div class="articledetails">';
			
			if ($head_type != 'none') {
			
				$html .= '<div class="head">';
				
				if ($show_calendar && !empty($calendar_date)) {
					
					$html .= '<div class="calendar noimage">';
					
					if (!empty($date_params_keys[0])) {
						$html .= '<span class="position1 '.$date_params_keys[0].'">'.$date_params_values[$date_params_keys[0]].'</span>';
					}
					if (!empty($date_params_keys[1])) {
						$html .= '<span class="position2 '.$date_params_keys[1].'">'.$date_params_values[$date_params_keys[1]].'</span>';
					}
					if (!empty($date_params_keys[2])) {
						$html .= '<span class="position3 '.$date_params_keys[2].'">'.$date_params_values[$date_params_keys[2]].'</span>';
					}
					if (!empty($date_params_keys[3])) {
						$html .= '<span class="position4 '.$date_params_keys[3].'">'.$date_params_values[$date_params_keys[3]].'</span>';
					}
					if (!empty($date_params_keys[4])) {
						$html .= '<span class="position5 '.$date_params_keys[4].'">'.$date_params_values[$date_params_keys[4]].'</span>';
					}
						
					$html .= '</div>'; // calendar
				}
				
				$html .= '</div>'; // head
			}
			
			$html .= '<div class="info">';
			
			if ($info_block_placement == 'before') {
				$html .= plgArticleDetailsHelper::getInfoBlock($this->params, $row, $params, $view); // details
			}
				
			if ($params->get('show_title') && !empty($row->title)) {
				if ($view == 'article') {
					if ($params->get('link_titles') && !empty($row->readmore_link)) {
						$html .= '  <h'.$title_html_tag.' class="article_title"><a href="'.$row->readmore_link.'">'.$row->title.'</a></h'.$title_html_tag.'>';
					} else {
						$html .= '  <h'.$title_html_tag.' class="article_title">'.$row->title.'</h'.$title_html_tag.'>';
					}
				} else if ( $view == 'category' || $view == 'featured' ) {
					if ($params->get('link_titles') && $params->get('access-view')) {
						$html .= '  <h'.$title_html_tag.' class="article_title"><a href="'.JRoute::_(ContentHelperRoute::getArticleRoute($row->slug, $row->catid)).'">'.$row->title.'</a></h'.$title_html_tag.'>';
					} else {
						$html .= '  <h'.$title_html_tag.' class="article_title">'.$row->title.'</h'.$title_html_tag.'>';
					}
				}
			}	
			
			if ($info_block_placement == 'after') {
				$html .= plgArticleDetailsHelper::getInfoBlock($this->params, $row, $params, $view); // details
			}
			
			$html .= '</div>'; // info
			
			$html .= '</div>'; // articledetails
			
			// add styles
			
			$doc = JFactory::getDocument();
			
			if (empty(self::$_style_path)) {
			
				self::$_style_path = $urlPath.'stylemaster.css.php?security='.defined('_JEXEC');
				
				self::$_style_path .= '&amp;f_details='.$font_details;
				
				if ($show_calendar && !empty($calendar_date)) {
					self::$_style_path .= '&amp;head_w='.$head_width.'&amp;head_h='.$head_height;
					self::$_style_path .= '&amp;calendar='.$calendar_style;
					self::$_style_path .= '&amp;c1='.$color1.'&amp;c2='.$color2.'&amp;c3='.$color3.'&amp;f_cal='.$font_ref_cal;
					if (!empty($bgcolor11)) {
						self::$_style_path .= '&amp;bgc11='.$bgcolor11;
					}
					if (!empty($bgcolor12)) {
						self::$_style_path .= '&amp;bgc12='.$bgcolor12;
					}
					if (!empty($bgcolor21)) {
						self::$_style_path .= '&amp;bgc21='.$bgcolor21;
					}
					if (!empty($bgcolor22)) {
						self::$_style_path .= '&amp;bgc22='.$bgcolor22;
					}
					if (!empty($bgcolor31)) {
						self::$_style_path .= '&amp;bgc31='.$bgcolor31;
					}
					if (!empty($bgcolor32)) {
						self::$_style_path .= '&amp;bgc32='.$bgcolor32;
					}
					if ($border_w > 0) {
						self::$_style_path .= '&amp;border_w='.$border_w;
					}
					if ($border_r > 0) {
						self::$_style_path .= '&amp;border_r='.$border_r;
					}
					if ($shadow_w > 0) {
						self::$_style_path .= '&amp;sh_w='.$shadow_w;
					}
				}
				
				if ($ie > -1) {
					self::$_style_path .= '&amp;ie='.$ie;
				}
				
				if ($ie != 7) {
					self::$_style_path .= '&amp;ifc='.$iconfont_color;
				}
				
				$doc->addStyleSheet(self::$_style_path);	
			}
			
			// only load styles once
			if (empty(self::$_style)) {
			
				self::$_style = trim($this->params->get('style_overrides', ''));
				if (!empty(self::$_style)) {
					self::$_style .= ' ';
				}
				
				// get elements to override
				
				$title_element = trim($this->params->get('title_element', '.item-page h2,.items-leading h2,.items-row h2'));
				$elements = explode(',', $title_element);
				foreach ($elements as $element) {
					if ($ie > 0 && $ie < 9) {
						self::$_style .= $element.',';
					} else {
						self::$_style .= $element.':first-of-type,';
					}
				} 			
				self::$_style = rtrim(self::$_style, ',');
				self::$_style .= ' { display:none; } ';
				
				$info_element = trim($this->params->get('info_element', '.article-info'));
				$elements = explode(',', $info_element);
				foreach ($elements as $element) {
					self::$_style .= $element.',';
				}
				self::$_style = rtrim(self::$_style, ',');
				self::$_style .= ' { display:none; } ';
				
				$tags_element = trim($this->params->get('tags_element', ''));
				if (!empty($tags_element)) {
					$elements = explode(',', $tags_element);
					foreach ($elements as $element) {
						self::$_style .= $element.',';
					}
					self::$_style = rtrim(self::$_style, ',');
					self::$_style .= ' { display:none; } ';
				}		
				
				// font icons with icons fallback for IE7
				
				if ($ie == 7) {
					if ($iconfont_color != '000000') { // if black, use original
						$rgb_array = SYWUtilities::hex2RGB($iconfont_color);
						if ($rgb_array != false) {
							$extensions = get_loaded_extensions();
							if (in_array('gd', $extensions)) {
								$apply_style = false;							
								$tmp_path = $app->getCfg('tmp_path'); // whole path but need only tmp
								$tmp_path = str_replace(JPATH_ROOT.'/', '', $tmp_path);	// getting tmp						
								
								$filename = $tmp_path.'/glyphicons-halflings-'.$iconfont_color.'.png';
								if (is_file(JPATH_ROOT.'/'.$filename)) { // icons file already exists
									$apply_style = true;
								} else {
									$image = new SYWImage($urlPath.'/images/glyphicons-halflings.png');
									if (!is_null($image->getImage())) {
										$apply_style = $image->createThumbnail(469, 159, false, 0, array('type' => IMG_FILTER_COLORIZE, 'arg1' => $rgb_array['red'], 'arg2' => $rgb_array['green'], 'arg3' => $rgb_array['blue']), $filename);
									}
								}
				
								if ($apply_style) {
									$current_path_without_base = substr_replace(JURI::current(), '', 0, strlen(JURI::base()));
									$escape = '';
									for ($i = 0; $i < substr_count($current_path_without_base, '/'); $i++) {
										$escape .= '../';
									}
										
									self::$_style .= '.articledetails .info .details [class^="SYWicon-"],';
									self::$_style .= '.articledetails .info .details [class*=" SYWicon-"] {';
									self::$_style .= 'background-image: url("'.$escape.$filename.'") !important;';
									self::$_style .= '} ';
								}
							}
						}
					}
				} else {
					SYWFonts::loadIconFont();
				}
				
				if ($show_calendar && !empty($calendar_date)) {
					$font_calendar = $this->params->get('fontcalendar', '');
					if (!empty($font_calendar)) {
						$font_calendar = str_replace('\'', '"', $font_calendar); // " lost, replaced by '
					
						$google_font = SYWUtilities::getGoogleFont($font_calendar); // get Google font, if any
						if ($google_font) {
							$doc->addStyleSheet('http://fonts.googleapis.com/css?family='.SYWUtilities::getSafeGoogleFont($google_font));
						}
					
						self::$_style .= '.articledetails .head .calendar {';
						self::$_style .= 'font-family: '.$font_calendar;
						self::$_style .= '} ';
					}
				}
				
				if (!empty(self::$_style)) {
					self::$_style = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', self::$_style); // minify the CSS code
					$doc->addStyleDeclaration(self::$_style);
				}
			}
		}
		
		return $html;
	}
}
?>
