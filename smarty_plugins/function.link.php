<?php

//print_r($Site);
function smarty_function_link($params, &$smarty)
{
	//print_r($params);
	//** Class link
	if(isset($params['class'])){
		return "<b>".$params['class']."</b>";
	}
	if(isset($params['user'])){
		return "<b>".$params['user']."</b>";
	}
	global $Site;

	if(!isset($params['site'])){
		$params['site'] =  $Site->id;
	}
	if(!isset($params['section'])){
		$params['section'] =  $Site->section;
	}
	/*
	$site_id = isset($params['site']) ? $params['site'] : $Site->id;
	$script = $Site->siteUrl($site_id);
	$vars['site'] = $site_id;
	unset($params['site']);

	$section = isset($params['section']) ? $params['section'] : $Site->section;
	$vars['section'] = $section;
	unset($params['section']);
	
	$site_id = isset($params['site']) ? $params['site'] : $Site->id;
	$script = $Site->siteUrl($site_id);
	$vars['site'] = $site_id;
	unset($params['site']);
	*/
	//$section = isset($params['section']) ? $params['section'] : $Site->section;
	//$vars['section'] = $section;
	//unset($params['section']);

	//if(isset($params['page'])){
	//	$vars['page'] = $page;
	//	unset($params['page']);
	//}

	if( isset($params['text']) ){
		$text = $params['text'];
		unset($params['text']);
	}else{
		$text = "NONE";
	}
	//print_r($_SERVER);

	return '<a href="'.$_SERVER['SCRIPT_NAME'].'?'.http_build_query($params).'">'.$text.'</a>';
}


function OLDEsmarty_function_link($params, &$smarty)
{

	//** Class link
	if(isset($params['class'])){
		return "<b>".$params['class']."</b>";
	}
	if(isset($params['user'])){
		return "<b>".$params['user']."</b>";
	}
	global $Site;

	$site_id = isset($params['site']) ? $params['site'] : $Site->id;
	$script = $Site->siteUrl($site_id);

	$section = isset($params['section']) ? $params['section'] : $Site->section;
	$page = isset($params['page']) ? $params['page'] : null;
	$text = $params['text'];
	
	if(is_null($page)){
		return sprintf('<a href="%s?section=%s">%s</a>', $script, $section, $title);
	}
	return sprintf('<a href="%s?section=%s&page=%s">%s</a>', $script, $section, $page, $title);
}
?>