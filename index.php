<?php

$REQUIRE_SMARTY = true;
require_once('config/config.inc.php');

$Site = new fgSite();
$Site->site_id = '_portal_';
$Site->site_title = 'FlightGear';

$smarty->assign('Site', $Site);
$smarty->display('portal_container.html')

?>