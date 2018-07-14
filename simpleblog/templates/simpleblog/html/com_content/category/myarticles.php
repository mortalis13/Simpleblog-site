<?php

defined('_JEXEC') or die;

$layout='list';

$app=JFactory::getApplication();
$inputLayout=$app->input->get('layout');

$filter=$this->state->get('filter.myarticles_layout');
if($filter) $layout=$filter;

$layout=$this->_layout.$layout.'.php';
require $layout;
