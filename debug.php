<?php

require_once('config/config.inc.php');

$Site = new fgSite('webdev', 'DEV');

$foo = new fgMpServer(); //::index();
//fgMpServer::index();
//print_r($foo->index());
$foo->url;


$aero = new fgAero();


//print_r($Site);
function SSsmarty_function_link($params, &$smarty)
{
	print_r($params);
	//** Class link
	if(isset($params['class'])){
		return "<b>".$params['class']."</b>";
	}
	if(isset($params['user'])){
		return "<b>".$params['user']."</b>";
	}
	global $Site;

	$vars = array();

	$site_id = isset($params['site']) ? $params['site'] : $Site->id;
	$script = $Site->siteUrl($site_id);
	$vars['site'] = $site_id;
	unset($params['site']);

	$section = isset($params['section']) ? $params['section'] : $Site->section;
	$vars['section'] = $section;
	unset($params['section']);

	if(isset($params['page'])){
		$vars['page'] = $page;
		unset($params['page']);
	}

	if( isset($params['text']) ){
		$text = $params['text'];
		unset($params['text']);
	}else{
		$text = "NONE";
	}
	//print_r($_SERVER);
	$url = $_SERVER['SCRIPT_NAME'];
	return '<a href="'.$url.'?'.http_build_query($vars).'">'.$text.'</a>';
}
require_once('smarty_plugins/function.link.php');

echo smarty_function_link(array('set_style' => 'skin.handler.css', 'stext'=>'foo.css'), $smarty);
die();


try{

$style_sheets = fgStyle::skins();
print_r($style_sheets);

} catch (fgException $e) {
    //echo 'Caught exception: ',  $e->getMessage(), "\n";
	$e->error();
	
}




?>