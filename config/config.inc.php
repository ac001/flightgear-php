<?php

//*************************************************************************
//** General Definition and settings
//*************************************************************************
define('SITE_KEY', 'flight-simpits-v0.1');
define('VERSION', '0.1');

define('SITE_ROOT', dirname(__FILE__).'/../'); //* site root is parent to this file location
define('CLI', php_sapi_name() == 'cli');
if(CLI){
	session_start();
}
date_default_timezone_set('Europe/London');

//*************************************************************************
//** Error Handling
//*************************************************************************
error_reporting(E_ALL | E_STRICT); 

function my_error_handler($errno, $errstr, $errfile, $errline){
   // echo "@Error:".$errstr."<br>";   
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}
function my_exception_handler($exception)
{
    echo "@Exception:".$exception->getMessage();
    dResponse::send_exception($exception);
}


//*************************************************************************
//** Auto Load Classes
//*************************************************************************
function __autoload($class_name){
    global $classes_loaded;
    switch($class_name){

		case 'Smarty':
			require_once(SITE_ROOT.'/libs/Smarty-2.6.26/libs/Smarty.class.php');
			return;

		case 'ADONewConnection+not_yet':
			//define('ADODB_DIR', DAFFO_ROOT_PATH.'/adodb5/'); //* << 5 is here
			//require_once( ADODB_DIR.'adodb-exceptions.inc.php' );
			//require_once( ADODB_DIR.'adodb.inc.php' );
			//require_once( ADODB_DIR.'adodb-errorhandler.inc.php' );
			return;

        case 'phpmailer+not_yet':
            #require_once(DAFFO_ROOT_PATH.'/phpmailer/class.phpmailer.php');
            require_once(DAFFO_ROOT_PATH.'/PHPMailer_v5.1/class.phpmailer.php');
            break;

        default:
			//** Load from the classes/ subdirectory #TODO try{} catch
            require_once(SITE_ROOT.'classes/'.$class_name.'.php');
			return;

    }
}


//*************************************************************************
//** Site 
//*************************************************************************
$section = isset($_REQUEST['section']) ? $_REQUEST['section'] : 'index';
$page = isset($_REQUEST['page']) ? $_REQUEST['page'] : null;

$Site = new fgSite('fg-www', 'FlightGear', $section, $page);

//** Intersite Navigation
// addSiteNav ($url, $label, $optional_ki (ued upon cloud later with remote "nav"
$Site->addSiteNav('index.html',  'Portal', 'fg-master');
$Site->addSiteNav('web.php',  'Website', 'fg-www');
$Site->addSiteNav('http://fg-aircraft.appspot.com',  'Aircraft', 'fg-aircraft');
$Site->addSiteNav('http://fg-online.appspot.com',  'Online', 'fg-online');
$Site->addSiteNav('http://wiki.flightgear.org',  'Wiki', 'wiki');
$Site->addSiteNav('http://www.flightgear.org/forums/',  'Forums', 'forums');

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
/*

		self.nav_append( {'path':'/about/', 'label': 'About', 'title': 'About FlightGear',
						'subnav': [	
							{'path':'/about/features/', 'label': 'Features' },
							{'path':'/about/license/', 'label': 'License'}
						]
		})
		self.nav_append( {'path':'/media/', 'label': 'Media', 
						'subnav': [	
							{'path':'/media/videos/', 'label': 'Videos', 'title': 'Videos'},
							{'path':'/media/gallery/', 'label': 'Image Gallery'}
						]
		})
		self.nav_append( {'path':'/support/', 'label': 'Support', 
						'subnav': [	
							{'path':'/support/docs/', 'label': 'Documentation'},
							{'path':'/support/faq/', 'label': 'FAQ', 'title': 'Frequently Answered Questions'}
						]
		})
		self.nav_append( {'path':'/download/', 'label': 'Download', 'title': 'Download Central',
					'subnav': [	
						{'path':'/download/requirements/', 'label': 'Requirements', 'title': 'Hardware Requirements'}, 	
						{'path':'/download/flightgear/', 'label': 'FlightGear', 'title': 'Download FlightGear'}, 	
						#{'path':'/download/aircraft/', 'label': 'Aircraft'},
						{'path':'/download/scenery/', 'label': 'Scenery'},
						{'path':'/download/versions/', 'label': 'Versions', 'title': 'Version Summary'},
					]
		})
		#nav.append( {'path':'/features/', 'label': 'Features'} )
		#self.nav_append( {'path':'/aircraft/', 'label': 'Aircraft'} )
		#self.nav_append( {'path':'/multiplayer/', 'label': 'Online Multi Player' })
		"""
		, 			'subnav': [	
							{'path':'/multiplayer/servers/', 'label': 'Servers'},
							{'path':'/multiplayer/pilots/', 'label': 'Pilots'},
							{'path':'/multiplayer/atc/', 'label': 'ATC'},
							{'path':'/multiplayer/map/', 'label': 'Online Map'}
					]
		})
		"""
		#self.nav_append( {'path':'/mpservers/', 'label': 'Aircraft'} )
		#nav.append( {'path':'/mapservers/', 'label': 'Map Servers'} )
		#nav.append( {'path':'/developers/', 'label': 'Developers'} )


		self.nav_append( {'path':'/developers/', 'label': 'Developers',
					'subnav': [	
							{'path':'/developers/src/', 'label': 'Source Code'},
							{'path':'/developers/credits/', 'label': 'Credits'}
					]
		})
		self.nav_append( {'path':'/links/', 'label': 'Links',
					'subnav': [	
							{'path':'/links/sites/', 'label': 'Related Sites'},
							{'path':'/links/projects/', 'label': 'Projects'}
					]
		})
*/

//*********************************************************
//** Memcached
//*********************************************************
$Mem = null;


//*********************************************************
//** Load Smarty
//*********************************************************
$smarty = new Smarty();
$smarty->force_compile  = isset($_GET['FORCE']) ? true : false;
$smarty->compile_check  = true;
$smarty->compile_id     = SITE_KEY;
$smarty->use_sub_dirs   = true;
//$smarty->compile_dir = SMARTY_COMPILE_DIR;
//$smarty->plugins_dir[]  = SITE_ROOT.'/libs/smarty_custom_plugins/';
$smarty->template_dir  = SITE_ROOT.'/templates/';

//** Assign general variables
$smarty->assign('nice_date_format', '%d-%m-%Y');
$smarty->assign('nice_date_time_format', '%d-%m-%Y : %I %p');

$smarty->assign('Site', $Site);

?>