<?php

$REQUIRE_SMARTY = true;
require_once('config/config.inc.php');

$g = new fgGallery();
print_r($g->index());

$Site = new fgSite();
$Site->id = 'portal';
$Site->title = 'FlightGear Portal';
$Site->section = 'index';

$smarty->assign('Site', $Site);
$smarty->display('web_container.html')

?>