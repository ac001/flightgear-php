<?php

$REQUIRE_SMARTY = true;
// $REQUIRE_DB = false; .. not needed
require_once('config/config.inc.php');

//* Create site object and setup
$Site = new fgSite();
$Site->title = 'FlightGear - Skel';

//** id also dictates the smarty_compile and the tempaltes/_sub_dir_
$Site->id = '_foo_';

//** Add to intersite navigation >> locaion.php, $site_title, $site_id
$Site->addSiteNav('foo.php', 'Foo', $Site->id);

//** Create Page navigation
$Site->addPageNav('index', 'Nav Label', 'Section title',
				array(
					array('plugin', 'Plugin', 'Plugin Demo'),
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