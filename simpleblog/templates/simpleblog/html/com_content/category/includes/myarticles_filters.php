<?php

defined('_JEXEC') or die;

require(dirname(dirname(__FILE__)).'/contentHelper.php');

?>

<fieldset id="filter-bar" class="filters">
<div class="total pull-right">
  <?php 
  	echo JText::_('TPL_SIMPLEBLOG_TOTAL').": ";
  	$catid=$this->category->id;
		$authorId=JFactory::getUser()->id;
		$publishState=$this->state->get('filter.state');
		if($publishState==="0" || $publishState==="1"){
			echo JModelLegacy::getInstance('contentHelper')->getArticlesCount($catid,$authorId,false,$publishState);
			echo "/";
		}
		echo JModelLegacy::getInstance('contentHelper')->getArticlesCount($catid,$authorId,true);
   ?>
</div>
</fieldset>

<fieldset class="filters btn-toolbar clearfix">
<div class="filter-select pull-left">
	<select name="filter_myarticles_layout" class="inputbox" onchange="this.form.submit()">
		<?php 
			$options=array(
				'list'=>JText::_('TPL_SIMPLEBLOG_MYARTICLES_LIST'),
				'blog'=>JText::_('TPL_SIMPLEBLOG_MYARTICLES_BLOG')
			);
			echo JHtml::_('select.options', $options, 'value', 'text', $this->state->get('filter.myarticles_layout'));
		?>
	</select>
</div>

<div class="filter-select pull-left">
	<select name="filter_state" class="inputbox" onchange="this.form.submit()">
		<option value=""> - <?php echo JText::_('TPL_SIMPLEBLOG_ALL_STATES') ?> - </option>
		<?php echo JHtml::_('select.options', JHtml::_('jgrid.publishedOptions', array('archived'=>false,'trash'=>false,'all'=>false)), 'value', 'text', $this->state->get('filter.state'), true);?>
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
