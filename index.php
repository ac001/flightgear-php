<?php

$LOAD_SMARTY = true;
require_once('config/config.inc.php');

$Site = new fgSite('portal', 'FlightGear Portal');

$Site->addPageNav('index', 'Welcome');
$Site->addPageNav('servers', 'Servers');
//$Site->addPageNav('signup', 'Sign Up');

$smarty->assign('nav_include', 'portal/nav_inc.html');

$Site->display();

?>