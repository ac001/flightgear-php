<?php

$REQUIRE_SMARTY = true;
// $REQUIRE_DB = false; .. not needed
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
					array('plugin', 'Plugin Demo', 'Autoload Plugin Demo'),
					array('bar', 'Bar', 'Bar title')
			)
);
$Site->addPageNav('another_section', 'Another Label', 'Lost in space',
				array(
					array('x_page', 'My X', 'My X lady'),
					array('zzz', 'Zzzzz', 'Sleep time cpu')
			)
);

//** Setup the default $section and $page
$Site->section = isset($_REQUEST['section']) ? $_REQUEST['section'] : 'index';
$Site->page = isset($_REQUEST['page']) ? $_REQUEST['page'] : null;

//** Run it
$smarty->assign('Site', $Site);
$smarty->display('web_container.html')
?>