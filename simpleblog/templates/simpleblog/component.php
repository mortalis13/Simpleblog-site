<?php

defined('_JEXEC') or die;

$app             = JFactory::getApplication();
$doc             = JFactory::getDocument();
$this->language  = $doc->language;

// Add JavaScript Frameworks
JHtml::_('bootstrap.framework');

// Add Stylesheets
require_once('includes/styles.php');

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
<jdoc:include type="head" />
<!--[if lt IE 9]>
	<script src="<?php echo $this->baseurl; ?>/media/jui/js/html5.js"></script>
<![endif]-->
</head>
<body class="contentpane modal">
	<jdoc:include type="message" />
	<jdoc:include type="component" />
</body>
</html>
