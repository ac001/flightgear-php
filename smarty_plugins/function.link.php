<?php
function smarty_function_link($params, &$smarty)
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
	$title = $params['title'];
	
	if(is_null($page)){
		return sprintf('<a href="%s?section=%s">%s</a>', $script, $section, $title);
	}
	return sprintf('<a href="%s?section=%s&page=%s">%s</a>', $script, $section, $page, $title);
}
?>