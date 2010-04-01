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
date_default_timezone_set('UTC');


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


//*********************************************************
//** Load Smarty
//*********************************************************
if(isset($REQUIRE_SMARTY) && $REQUIRE_SMARTY){
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
}

?>