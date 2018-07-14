<?php

defined('_JEXEC') or die;

function modChrome_no($module, &$params, &$attribs) {
	if ($module->content) {
		echo $module->content;
	}
}

function modChrome_well($module, &$params, &$attribs) {
	if ($module->content) {
		echo "<div class=\"well " . htmlspecialchars($params->get('moduleclass_sfx')) . "\">";
		if ($module->showtitle) {
			echo "<h3 class=\"page-header\">" . $module->title . "</h3>";
		}
		echo $module->content;
		echo "</div>";
	}
}
?>
