<?php

//***************************************************
//** Handles inserts updates and tasks
//***************************************************

$LOAD_DB = true;
require_once('../config/config.inc.php');

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
			//$sql = 'delete from aero';
			//$db->execute($sql);
			//print_r($_REQUEST);
			//$db->debug=1;

			$aero_id = fgAero::find('aero', $Req->aero);	
			//echo "aer_id=".$aero_id;
			$obj = new fgAero($aero_id > 0 ? $aero_id : 0);
			$obj->aero = $Req->aero;
			$obj->directory = $Req->directory;
			$obj->name = $Req->description;
			$obj->description = '';
			$obj->xml_set = $Req->xml_set;
			$obj->splash = $Req->splash;
			$obj->fdm = $Req->get('flight-model');
			$obj->status = $Req->status;
			$obj->active = $Req->active;
			$obj->save();
			//$db->debug=0;
			if($Req->author != ''){
				$user_id = fgUser::find('name', $Req->author);
				if(!$user_id){
					$User = new fgUser(0);
					$User->name = $Req->author;
					$user_id = $User->save();
				}

				$obj->addAuthor($user_id);
				$Response->add('aero_id', $aero_id);
			}
			break;

		default:
			throw new fgException('unhandled action',"The action '".$action."'is not handled");
	}
	


	
	$Response->sendPayload();

}catch(fgException $e){
	$Response->sendError($e);
}


?>