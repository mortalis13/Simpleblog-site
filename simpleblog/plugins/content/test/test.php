<?php
	defined('_JEXEC') or die;

  class plgContentTest extends JPlugin
  { 
    public function onContentPrepare($context, &$row, &$params, $page = 0)
    {
      $app = JFactory::getApplication();
      if($app->isAdmin()) return true;

      $text=$row->text;
      $row->text.="<b>".$row->created."</b>";
    }
  }