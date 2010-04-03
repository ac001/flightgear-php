<?php

$LOAD_SMARTY = true;
$LOAD_DB = true;
require_once('config/config.inc.php');

$Site = new fgSite('online','Multi Player' );

$Site->addPageNav('index', 'Online', 'Online Flying');
$Site->addPageNav('mpservers', 'MP Servers');

$Site->display();

?>