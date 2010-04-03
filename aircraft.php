<?php

require_once('config/config.inc.php');

$Site = new fgSite('aircraft', 'Aircraft Database');
$Site->addPageNav('index', 'Aircraft Index', 'Search the Aircraft Database');

$pages = null;

if($Site->Request->aero_id > 0){
	$Aero = new fgAero($Site->Request->aero_id);

	$Site->addPageNav('aero', $Aero->aero);
	$smarty->assign('Aero', $Aero);
	
}



$Site->display();

?>