<?php

//***************************************************
//** Handles inserts updates and tasks
//***************************************************

$LOAD_DB = true;
require_once('../../config/config.inc.php');

//** Reply
$Response = new fgResponse();

try{
	//* check action is set
	$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : null;
	if(!$action){
		throw new fgException('no action','action variable set');
	}

	//* perform on action
	switch($action){
		case 'signup':
			$Auth = new fgAuth();
			$Auth->signUp($_REQUEST);
			break;


		default:
			throw new fgException('unhandled action',"The action '".$action."'is not handled");
	}
	


	
	$Response->sendPayload();

}catch(fgException $e){
	$Response->sendError($e);
}


?>