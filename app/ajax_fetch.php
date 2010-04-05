<?php

//***************************************************
//** Handles inserts updates and tasks
//***************************************************

require_once('../config/config.inc.php');

$Response = new fgResponse();
//print_R($smarty);

//$Site = new fgSite('rpc','RPC');
fgHelper::plain();

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

		case 'aircraft':
			$Response->add('aircraft', fgAero::index());
			break;

		case 'aero_info':
			//print_r($smarty);
			$Aero = new fgAero($_REQUEST['aero_id']);
			$smarty->assign('Aero', $Aero);
			$html =  $smarty->fetch("aircraft/aero.html");
			//echo $html;
			//$Response->add('html', $html);
			$Response->add('aero', $Aero->info());
			break;

		default:
			throw new fgException('unhandled fetch',"The fetch '".$fetch."'is not handled");
	}
	


	
	$Response->sendPayload();

}catch(fgException $e){
	$Response->sendError($e);
}


?>