<?php

$REQUIRE_SMARTY = true;
require_once('config/config.inc.php');

$Site = new fgSite();
$Site->id = 'online';
$Site->title = 'Multi Player';
$Site->section = 'index';

$Site->section = isset($_REQUEST['section']) ? $_REQUEST['section'] : 'index';
$Site->page = isset($_REQUEST['page']) ? $_REQUEST['page'] : null;

$Site->addPageNav('index', 'Online', 'Online Flying');
$Site->addPageNav('mpservers', 'MP Servers');

$smarty->assign('Site', $Site);
$smarty->display('web_container.html')

?>