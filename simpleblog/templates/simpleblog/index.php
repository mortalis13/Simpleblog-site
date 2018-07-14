<?php

defined('_JEXEC') or die;

$app             = JFactory::getApplication();
$doc             = JFactory::getDocument();
$user            = JFactory::getUser();
$this->language  = $doc->language;

// Getting params from template
$params = $app->getTemplate(true)->params;

// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = $app->get('sitename');

// Add JavaScript Frameworks
JHtml::_('bootstrap.framework');
$doc->addScript('templates/' . $this->template . '/js/custom.js');

// Add Stylesheets
require_once('includes/styles.php');

// Logo file or site title param
if ($this->params->get('logoFile')) {
	$logo = '<img src="' . JUri::root() . $this->params->get('logoFile') . '" alt="' . $sitename . '" />';
}
elseif ($this->params->get('sitetitle')) {
	$logo = '<span class="site-title text-center" title="' . $sitename . '">' . htmlspecialchars($this->params->get('sitetitle')) . '</span>';
}
else {
	$logo = '<span class="site-title text-center" title="' . $sitename . '">' . $sitename . '</span>';
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<jdoc:include type="head" />

	<!-- <link href='http://fonts.googleapis.com/css?family=Noto+Sans:400,700' rel='stylesheet' type='text/css'> -->
	<!-- <link href='http://fonts.googleapis.com/css?family=Raleway:400,700' rel='stylesheet' type='text/css'> -->
	<link href='http://fonts.googleapis.com/css?family=Arimo:400,700' rel='stylesheet' type='text/css'>
	<!-- <link href='http://fonts.googleapis.com/css?family=Titillium+Web:400,700' rel='stylesheet' type='text/css'> -->
	
	<?php // Template color ?>
	<?php if ($this->params->get('templateColor')) : ?>
		<style type="text/css">
			a {
				color: <?php echo $this->params->get('templateColor'); ?>;
			}
			.navbar-inner, .nav-list > .active > a, .nav-list > .active > a:hover, .dropdown-menu li > a:hover, .dropdown-menu .active > a, .dropdown-menu .active > a:hover, .nav-pills > .active > a, .nav-pills > .active > a:hover,
			.btn-primary {
				background: <?php echo $this->params->get('templateColor'); ?>;
			}
		</style>
	<?php endif; ?>
	<!--[if lt IE 9]>
		<script src="<?php echo $this->baseurl; ?>/media/jui/js/html5.js"></script>
	<![endif]-->
</head>

<body class="site <?php echo $option
	. ' view-' . $view
	. ($layout ? ' layout-' . $layout : ' no-layout')
	. ($task ? ' task-' . $task : ' no-task')
	. ($itemid ? ' itemid-' . $itemid : '')
	. ($params->get('fluidContainer') ? ' fluid' : '');
?>">

	<!-- Body -->
	<div class="body">
		<div class="container">

			<!-- Navigation -->
			<nav class="navbar navbar-fixed-top" role="navigation">
				<div class="navbar-inner">
					<div class="container">
					 	<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">Menu</a>
					  <a href="<?php echo $this->baseurl; ?>" class="brand">Simple Blog</a>
					  <?php if($user->get('name')): ?>
							<div class="login-greeting visible-phone">
							  <?php echo "Welcome, ".htmlspecialchars($user->get('name')); ?>
							</div>
						<?php endif;?>
						<div class="nav-collapse collapse">
							<jdoc:include type="modules" name="top-menu" style="none" />
						</div>
					</div>
				</div>
			</nav>

			<!-- Header -->
			<header class="header" role="banner">
				<div class="header-inner clearfix text-center">
					<a href="<?php echo $this->baseurl; ?>">
						<?php echo $logo; ?>
						<?php if ($this->params->get('sitedescription')) : ?>
							<?php echo '<div class="site-description">' . htmlspecialchars($this->params->get('sitedescription')) . '</div>'; ?>
						<?php endif; ?>
					</a>
				</div>
			</header>

			<jdoc:include type="modules" name="banner" style="xhtml" />

			<div class="row-fluid">
				<main id="content" role="main" class="span9">
					<!-- Begin Content -->
					<jdoc:include type="modules" name="breadcrumbs" style="xhtml" />
					<jdoc:include type="message" />
					<jdoc:include type="component" />
					<!-- End Content -->
				</main>

				<?php if ($this->countModules('right')) : ?>
					<div id="aside" class="span3 hidden-phone">
						<!-- Begin Right Sidebar -->
						<jdoc:include type="modules" name="right" style="well" />
						<!-- End Right Sidebar -->
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<!-- Footer -->
	<footer class="footer" role="contentinfo">
		<div class="container">
			<hr />
			<div class="text-center">
				<div class="footer-left">&copy; <?php echo date('Y'); ?> <?php echo $sitename; ?></div>
				<jdoc:include type="modules" name="footer" style="none" />
				<div class="footer-right"><a href="#top" id="back-top"><?=JText::_('TPL_SIMPLEBLOG_BACK_TO_TOP') ?></a></div>
			</div>
		</div>
		<jdoc:include type="modules" name="debug" style="none" />
	</footer>

</body>
</html>
