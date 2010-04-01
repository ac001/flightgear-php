<?php

$REQUIRE_SMARTY = true;
require_once('config/config.inc.php');

$Site = new fgSite();
$Site->id = 'online';
$Site->title = 'Multi Player';
$Site->section = 'index';

$Site->addPageNav('index', 'Online', 'Coming Soon');

$smarty->assign('Site', $Site);
$smarty->display('web_container.html')

?>