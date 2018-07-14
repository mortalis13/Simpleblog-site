<?php

defined('_JEXEC') or die;

$app = JFactory::getApplication();
$path = JURI::base(true).'/templates/'.$app->getTemplate().'/'; 

require(dirname(dirname(__FILE__)).'/contentHelper.php');
JFormHelper::addFieldPath(JPATH_COMPONENT . '/models/fields');
$authors = JFormHelper::loadFieldType('Users', false);
$authorOptions=$authors->getOptions();

if(!$filterLayout) $filterLayout='list';
$authorFilter='filter.author_'.$filterLayout;
$authorSelectName='filter_author_'.$filterLayout;

?>

<fieldset id="filter-bar" class="filters">
  <div class="total pull-right">
	  <?php 
	  	echo JText::_('TPL_SIMPLEBLOG_TOTAL').": "; //"Total Articles: ";
	  	$catid=$this->category->id;
			$authorId=$this->state->get($authorFilter);
			if($authorId){
				echo JModelLegacy::getInstance('contentHelper')->getArticlesCount($catid,$authorId);
		  	echo "/";
			}
			echo JModelLegacy::getInstance('contentHelper')->getArticlesCount($catid);
	   ?>
  </div>
</fieldset>

<fieldset class="filters btn-toolbar clearfix">
	<div class="filter-select pull-left">
		<select name="<?=$authorSelectName ?>" class="inputbox" onchange="this.form.submit()">
			<option value=""> - <?=JText::_('TPL_SIMPLEBLOG_ALL_AUTHORS') ?> - </option>
			<?php echo JHtml::_('select.options', $authorOptions, 'id', 'name', $this->state->get($authorFilter));?>
		</select>
	</div>

  <?php if ($this->params->get('show_pagination_limit')) : ?>
    <div class="btn-group pull-right">
      <label for="limit" class="element-invisible">
        <?php echo JText::_('JGLOBAL_DISPLAY_NUM'); ?>
      </label>
      <?php echo $this->pagination->getLimitBox(); ?>
    </div>
  <?php endif; ?>
</fieldset>
