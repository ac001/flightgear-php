<?php

require_once('config/config.inc.php');

$Site = new fgSite('www','Simulator Project' );

//** Page Navigation 
// addPageNav ($section, $label_title, $optional_title, $sub_nav( array($sub_page, $label_title, $opt)_title) )
$Site->addPageNav(	'index', 'Welcome', null, 
					array(
						array('announce', 'Announcements', 'News and announcments'),
						array('calendar', 'Calendar')
					)
);
$Site->addPageNav(	'about', 'About', null, 
					array(
						array('features', 'Features'),
						array('license', 'License')
					)
);
$Site->addPageNav(	'media', 'Media', null, 
					array(
						array('videos', 'Videos'),
						array('gallery', 'Image Gallery')
					)
);
$Site->addPageNav(	'support', 'Support', null,
					array(	
						array('docs', 'Documentation'),
						array('faq', 'FAQ', 'Frequently Answered Questions')
					)
);
$Site->addPageNav(	'download', 'Download', 'Download Central',
					array(	
						array('requirements', 'Requirements', 'Hardware Requirements'), 	
						array('flightgear', 'FlightGear', 'Download FlightGear'), 	
						array('scenery', 'Scenery'),
						array('versions', 'Versions', 'Version Summary'),
					)
);
$Site->addPageNav(	'developers', 'Developers', null,
					array(	
							array('src', 'Source Code', 'Anonymous CVS instructions'),
							array('credits', 'Credits')
					)
);
$Site->addPageNav(	'links', 'Links', null,
					array(	
							array('sites', 'Related Sites'),
							array('projects', 'Projects', 'FlightGear Based Projects')
					)
);


$Site->display();

?>