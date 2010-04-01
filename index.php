<?php

$LOAD_SMARTY = true;
require_once('config/config.inc.php');

$Site = new fgSite();
$Site->id = 'portal';
$Site->title = 'FlightGear Portal';
$Site->section = 'index';

$smarty->assign('Site', $Site);
$smarty->display('web_container.html')

?>