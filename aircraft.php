<?php

require_once('config/config.inc.php');

$Site = new fgSite();
$Site->id = 'aircraft';
$Site->title = 'Aircraft Database';
$Site->section = 'index';

$Site->section = isset($_REQUEST['section']) ? $_REQUEST['section'] : 'index';
$Site->page = isset($_REQUEST['page']) ? $_REQUEST['page'] : null;

$Site->addPageNav('index', 'Updates', 'Latest Updates');
$Site->addPageNav('browse', 'Browse', 'Browse Aircraft');

$smarty->assign('Site', $Site);
$smarty->display('web_container.html')

?>