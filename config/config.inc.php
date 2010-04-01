<?php

//*************************************************************************
//** Error Handling
//*************************************************************************
error_reporting(E_ALL | E_STRICT); 
ini_set('display_errors', 1);


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


$Site = new fgSite();
$Site->site_id = 'fg-www';
$Site->site_title = 'FlightGear';
//** set up page and section
$Site->section = isset($_REQUEST['section']) ? $_REQUEST['section'] : 'index';
$Site->page = isset($_REQUEST['page']) ? $_REQUEST['page'] : null;

//** Intersite Navigation
// addSiteNav ($url, $label, $optional_ki (ued upon cloud later with remote "nav"
$Site->addSiteNav('index.php',  'Portal', '_portal_');
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
		#nav.append( 'features', 'Features' )
		#$Site->addPageNav('aircraft', 'Aircraft' )
		#$Site->addPageNav('multiplayer', 'Online Multi Player' );
		#$Site->addPageNav('mpservers', 'Aircraft' )
		#nav.append( 'mapservers', 'Map Servers' )
		#nav.append( 'developers', 'Developers' )


$Site->addPageNav(	'developers', 'Developers', null,
					array(	
							array('src', 'Source Code'),
							array('credits', 'Credits')
					)
);
$Site->addPageNav(	'links', 'Links', null,
					array(	
							array('sites', 'Related Sites'),
							array('projects', 'Projects')
					)
);

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
$smarty->compile_dir 	= fgSite::SMARTY_COMPILE_DIR;
//$smarty->plugins_dir[]  = SITE_ROOT.'/libs/smarty_custom_plugins/';
$smarty->template_dir  = SITE_ROOT.'/templates/';

//** Assign general variables
$smarty->assign('nice_date_format', '%d-%m-%Y');
$smarty->assign('nice_date_time_format', '%d-%m-%Y : %I %p');

$smarty->assign('Site', $Site);

?>