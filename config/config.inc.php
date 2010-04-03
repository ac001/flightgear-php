<?php


define('SITE_KEY', 'FG-0.1');
define('VERSION', '0.1');

$smaarty = null;
$db = null;

//*************************************************************************
//** Error Handling
//*************************************************************************
error_reporting(-1); 
//ini_set('display_errors', 1);

function main_error_handler($errno, $errstr, $errfile, $errline){
   // echo "@Error:".$errstr."<br>";   
    //throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
}
function my_ssexception_handler($exception)
{
    echo "@Exception:".$exception->getMessage();
    fgResponse::send_exception($exception);
}
//set_error_handler('main_error_handler');

//*************************************************************************
//** General Definition and settings
//*************************************************************************

date_default_timezone_set('UTC');

define('CLI', php_sapi_name() == 'cli');

if(!CLI){
	session_start();
}

 //* site root is parent to this file location
define('SITE_ROOT', dirname(__FILE__).'/../');


//*************************************************************************
//** Auto Load Classes
//*************************************************************************
function __autoload($class_name){
    global $classes_loaded;
    switch($class_name){

		case 'Smarty':
			require_once(SITE_ROOT.'/libs/Smarty-2.6.26/libs/Smarty.class.php');
			return;

		case 'Geshi':
			//define('ADODB_DIR', DAFFO_ROOT_PATH.'/adodb5/'); //* << 5 is here
			require_once( SITE_ROOT.'libs/geshi/geshi.php' );
			//require_once( ADODB_DIR.'adodb.inc.php' );
			//require_once( ADODB_DIR.'adodb-errorhandler.inc.php' );
			return;

        case 'phpmailer':
            #require_once(DAFFO_ROOT_PATH.'/phpmailer/class.phpmailer.php');
            require_once(SITE_ROOT.'libs/PHPMailer_v5.1/class.phpmailer.php');
            break;

        default:
			//** Load from the classes/ subdirectory #TODO try{} catch
            require_once(SITE_ROOT.'classes/'.$class_name.'.php');
			return;

    }
}

//*************************************************************************
//** Load Configuration
//*************************************************************************
$Config = new fgConfig();

//*********************************************************
//** Load Database
//*********************************************************
require_once(SITE_ROOT.'libs/adodb5/adodb.inc.php');

$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
$db = ADONewConnection($Config->database->driver); # eg 'mysql' or 'postgres'
$db->debug = false;
$db->Connect($Config->database->server, $Config->database->username, $Config->database->password, $Config->database->database);
unset($Config->database);


//*********************************************************
//** Load Smarty
//*********************************************************

$smarty = new Smarty();

//* compile setup
$smarty->force_compile  = isset($_GET['FORCE_COMPILE']) ? true : false;
$smarty->compile_check  = true;
$smarty->compile_id     = SITE_KEY;
$smarty->use_sub_dirs   = true;
$smarty->compile_dir 	= fgSite::SMARTY_COMPILE_DIR;

//* Templates path
$smarty->template_dir  = SITE_ROOT.'templates/';

//* Plugins path
$smarty->plugins_dir[]  = SITE_ROOT.'smarty_plugins/';

//** Assign general variables
$smarty->assign('nice_date_format', '%d-%m-%Y');
$smarty->assign('nice_date_time_format', '%d-%m-%Y : %I %p');

$smarty->assign('JS', 'http://fg-cache.appspot.com/');


?>