<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$msgList = $displayData['msgList'];

$errorList=array("JGLOBAL_YOU_MUST_LOGIN_FIRST");

?>
<div id="system-message-container">
	<?php if (is_array($msgList) && !empty($msgList)) : ?>
		<div id="system-message">
			<?php foreach ($msgList as $type => $msgs) : ?>
				<?php 
					if($type=="message"){
						$type="success";
						$finished=false;

						foreach ($msgs as $msg){
							if($finished) break;
							foreach ($errorList as $item) {
								if($msg==JText::_($item)){
									$type="error";
									$finished=true;
									break;
								}
							}
						}
					} 
				?>
				
				<div class="alert alert-<?php echo $type; ?>">
					<?php // This requires JS so we should add it trough JS. Progressive enhancement and stuff. ?>
					<a class="close" data-dismiss="alert">×</a>
					<?php if (!empty($msgs)) : ?>
						<div>
							<?php foreach ($msgs as $msg) : ?>
								<p><?php echo $msg; ?></p>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</div>
