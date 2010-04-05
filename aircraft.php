<?php

require_once('config/config.inc.php');

$Site = new fgSite('aircraft', 'Aircraft Database');
//$Site->addPageNav('index', 'Aircraft Index', 'Search the Aircraft Database');
//$Site->addPageNav('bk', 'Html', 'HTML Search');
$pages = null;

if($Site->Request->aero_id > 0){
	$Aero = new fgAero($Site->Request->aero_id);
	//print_r($Aero);
	$Site->addPageNav('aero', $Aero->aero);
	$smarty->assign('Aero', $Aero);
	
}

$smarty->assign("nav_content", "aircraft/snip.widget.html");


$Site->display();

?>