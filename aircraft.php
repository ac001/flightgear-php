<?php

require_once('config/config.inc.php');

$Site = new fgSite('aircraft', 'Aircraft Database');

$Site->addPageNav('index', 'Updates', 'Latest Updates');
$Site->addPageNav('browse', 'Browse', 'Browse Aircraft');


$Site->display();

?>