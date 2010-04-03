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
	$fetch = isset($_REQUEST['fetch']) ? $_REQUEST['fetch'] : null;
	if(!$fetch){
		throw new fgException('no fetch','fetch variable set');
	}

	//* perform on action
	switch($fetch){
		case 'servers':
			$Response->add('servers', fgServer::index());
			break;

		case 'users':
			$Response->add('users', fgUser::index());
			break;

		default:
			throw new fgException('unhandled fetch',"The fetch '".$fetch."'is not handled");
	}
	


	
	$Response->sendPayload();

}catch(fgException $e){
	$Response->sendError($e);
}


?>