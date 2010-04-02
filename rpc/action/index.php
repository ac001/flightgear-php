<?php

//***************************************************
//** Handles inserts updates and tasks
//***************************************************

$LOAD_DB = true;
require_once('../../config/config.inc.php');

$Req = new fgObject($_POST);

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

		case 'server':
			$db->debug=1;
			$S = new fgServer($Req->server_id);
			$S->type = $Req->type;
			$S->nick = $Req->nick;
			$S->host = $Req->host;
			$S->ip = $Req->ip;
			$S->comment = $Req->comment;
			$S->location = $Req->location;
			$S->contact = $Req->contact;
			$S->irc = $Req->irc;
			$S->active = $Req->active;
			$S->save();
			break;

		default:
			throw new fgException('unhandled action',"The action '".$action."'is not handled");
	}
	


	
	$Response->sendPayload();

}catch(fgException $e){
	$Response->sendError($e);
}


?>