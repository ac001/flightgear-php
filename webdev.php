<?php

$LOAD_SMARTY = true;
$LOAD_DB = true;
require_once('config/config.inc.php');

//* Create site object and setup
$Site = new fgSite();
$Site->title = 'Web Development';

//** id also dictates the smarty_compile and the tempaltes/_sub_dir_
$Site->id = 'webdev';

//** Add to intersite navigation >> locaion.php, $site_title, $site_id
//$Site->addSiteNav('dev.php', 'Dev', $Site->id);

//** Create Page navigation
$Site->addPageNav('index', 'Web Dev Index', 'Welcome To the FlightGear Web Dev',
				array(
					array('install', 'Dev Install', 'Developers Installation'),
					array('overview', 'Overview', 'Site and Code Overview'),
					array('config', 'Config', 'Configuration'),
					array('site_obj', '$Site Object'),
					array('autoload', 'Autoload', 'function __autoload()'),
					array('classes', 'Classes', 'Classes'),
					array('error', 'Exceptions', 'Exceptions and Error Handling'),
			)
);
$Site->addPageNav('example', 'Example Site', 'Site creation example',
			array(
					array('plugin', 'Plugin Demo', 'Autoload Plugin Demo')
			)
);

$Site->addPageNav('feeds', 'Feeds', 'Creating and Using Feeds',
	array(
					array('conf', 'conf Files', 'Configuration Files')
));
$Site->addPageNav('production', 'Production Server', 'Production Server');

//** Setup the default $section and $page
$Site->section = isset($_REQUEST['section']) ? $_REQUEST['section'] : 'index';
$Site->page = isset($_REQUEST['page']) ? $_REQUEST['page'] : null;

//** Run it
$smarty->assign('Site', $Site);
$smarty->display('web_container.html')
?>