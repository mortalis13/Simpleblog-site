<?php 
/**
* @copyright	Copyright (C) 2011 Simplify Your Web, Inc. All rights reserved.
* @license		GNU General Public License version 3 or later; see LICENSE.txt
*/

$security = 0;
if (isset($_GET["$security"])) {
	$security = $_GET['security'];
}

define('_JEXEC', $security);

// No direct access to this file
defined('_JEXEC') or die;

// Explicitly declare the type of content
header("Content-type: text/css; charset=UTF-8");

// IE

$ie = -1;
if (isset($_GET['ie'])) {
	$ie = (int)$_GET['ie'];
}

// general parameters

$head_width = 0;
if (isset($_GET['head_w'])) {
	$head_width = (int)$_GET['head_w'];
}

$head_height = 0;
if (isset($_GET['head_h'])) {
	$head_height = (int)$_GET['head_h'];
}

// calendar

$calendar = '';
if (isset($_GET['calendar'])) {
	$calendar = $_GET['calendar'];
}

$shadow_width = 0;
if (isset($_GET['sh_w'])) {
	$shadow_width = (int)$_GET['sh_w'];
}

$border_width = 0;
if (isset($_GET['border_w'])) {
	$border_width = $_GET['border_w'];
}

$border_radius = 0;
if (isset($_GET['border_r'])) {
	$border_radius = $_GET['border_r'];
}

$color = '#3D3D3D';
if (isset($_GET['c1'])) {
	$color = '#'.$_GET['c1'];
}

$bgcolor1 = 'transparent';
if (isset($_GET['bgc11'])) {
	$bgcolor1 = '#'.$_GET['bgc11'];
}

$bgcolor2 = 'transparent';
if (isset($_GET['bgc12'])) {
	$bgcolor2 = '#'.$_GET['bgc12'];
}

$color_top = '#494949';
if (isset($_GET['c2'])) {
	$color_top = '#'.$_GET['c2'];
}

$bgcolor1_top = 'transparent';
if (isset($_GET['bgc21'])) {
	$bgcolor1_top = '#'.$_GET['bgc21'];
}

$bgcolor2_top = 'transparent';
if (isset($_GET['bgc22'])) {
	$bgcolor2_top = '#'.$_GET['bgc22'];
}

$color_bottom = '#494949';
if (isset($_GET['c3'])) {
	$color_bottom = '#'.$_GET['c3'];
}

$bgcolor1_bottom = 'transparent';
if (isset($_GET['bgc31'])) {
	$bgcolor1_bottom = '#'.$_GET['bgc31'];
}

$bgcolor2_bottom = 'transparent';
if (isset($_GET['bgc32'])) {
	$bgcolor2_bottom = '#'.$_GET['bgc32'];
}

$font_ref_cal = 14;
if (isset($_GET['f_cal'])) {
	$font_ref_cal = $_GET['f_cal'];
}

$iconfont_color = '#000000';
if (isset($_GET['ifc'])) {
	$iconfont_color = '#'.$_GET['ifc'];
}

//$font_ratio = 1; // floatval($head_height) / 80; // 1em base for a height of 80px

$font_details = 90;
if (isset($_GET['f_details'])) {
	$font_details = (int)$_GET['f_details'];
}

// calculated variables

// CSS
  
$links = array();

$links[] = 'styles/style.css.php';
if (!empty($calendar)) {
	$links[] = 'styles/calendar/'.$calendar.'/style.css.php';
}
  
function compress($buffer) {
	/* remove comments */
	$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
	/* remove tabs, spaces, newlines, etc. */
	$buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
	return $buffer;
}

ob_start("compress");
	
foreach ($links as $link) {
	include $link;
}

ob_end_flush();
?>