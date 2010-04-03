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

	//* execute an action
	switch($action){
		case 'signup':
			$Auth = new fgAuth();
			$Auth->signUp($_REQUEST);
			break;

		case 'server':
			$sql = 'delete from aero';
			$db->execute($sql);
			$S = new fgServer($Req->server_id);
			$obj->type = $Req->type;
			$obj->nick = $Req->nick;
			$obj->host = $Req->host;
			$obj->ip = $Req->ip;
			$obj->comment = $Req->comment;
			$obj->location = $Req->location;
			$obj->contact = $Req->contact;
			$obj->irc = $Req->irc;
			$obj->active = $Req->active;
			$obj->save();
			break;


		case 'aero_cvs':
			//print_r($_POST);
			//$db->debug=1;
			$obj = new fgAero($Req->server_id);
			$obj->aero = $Req->aero;
			$obj->directory = $Req->directory;
			$obj->name = $Req->name;
			$obj->description = $Req->description;
			$obj->splash = $Req->splash;
			$obj->fdm = $Req->get('flight-model');
			$obj->status = $Req->status;
			$obj->active = $Req->active;
			$obj->save();
			break;

		default:
			throw new fgException('unhandled action',"The action '".$action."'is not handled");
	}
	


	
	$Response->sendPayload();

}catch(fgException $e){
	$Response->sendError($e);
}


?>