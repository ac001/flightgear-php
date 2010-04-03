<?php

require_once('config/config.inc.php');

//* Create site object and setup
$Site = new fgSite('webdev',  'Web Development');

//** Add to intersite navigation >> locaion.php, $site_title, $site_id
//$Site->addSiteNav('dev.php', 'Dev', $Site->id);

//** Create Page navigation
$Site->addPageNav('index', 'Web Dev', 'Welcome Web Dewelopers',
				array(
					array('install', 'Install', 'Server Installation'),
					array('overview', 'Overview', 'Site and Code Overview'),
					array('config', 'Config', 'Configuration'),
					array('site_obj', '$Site Object'),
					array('autoload', 'Autoload', 'function __autoload()'),
					array('classes', 'Classes', 'Classes'),
					array('error', 'Exceptions', 'Exceptions and Error Handling'),
					array('style', 'Style Sheet', 'Style Sheet')
			)
);
$Site->addPageNav('style', 'Style', 'Style Sheet and Design',
			array(
					array('blocks', 'Layout', 'Layout Blocks color coded'),
					array('night', 'Night Flying', 'EGLL at night')
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

$Site->addPageNav('admin', 'Site Administration', 'Site Administration',
				array(
					array('users', 'Users ', 'Admin Users'),
					array('servers', 'Servers')
			));

$Site->display();

//** Run it
//$smarty->assign('Site', $Site);
//$smarty->display('web_container.html')
?>