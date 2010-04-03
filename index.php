<?php

$LOAD_SMARTY = true;
require_once('config/config.inc.php');

$Site = new fgSite('portal', 'FlightGear Portal');

$Site->addPageNav('index', 'Welcome');
$Site->addPageNav('servers', 'Servers');
$Site->addPageNav('signup', 'Sign Up');

$Site->display();

?>