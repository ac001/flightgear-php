<?php

$LOAD_SMARTY = true;
require_once('config/config.inc.php');

$Site = new fgSite();
$Site->id = 'portal';
$Site->title = 'FlightGear Portal';

$Site->section = isset($_REQUEST['section']) ? $_REQUEST['section'] : 'index';
$Site->page = isset($_REQUEST['page']) ? $_REQUEST['page'] : null;

$Site->addPageNav('index', 'Main');
$Site->addPageNav('servers', 'Servers');
$Site->addPageNav('signup', 'Sign Up');

$smarty->assign('Site', $Site);
$smarty->display('web_container.html')

?>