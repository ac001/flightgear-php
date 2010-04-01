<?php

require_once('../config/config.inc.php');

//* Feed object
$Feed = new fgFeed();

$Response = new fgResponse();

try{

	//*  Process Request
	$feed_requested = isset($_REQUEST['feed']) ? $_REQUEST['feed'] : null;
	if($feed_requested){
		
		//* Check feed exists
		if(!$Feed->hasFeed($feed_requested)){
			throw new fgException($feed_requested.': feed not found', 'The requested feed is not recognised');
		}

		//* Check Handler is available and feed() method exists
		if(!$Feed->checkHandler($feed_requested)){
			
		}

	}

	//* Return $data
	$data = array();
	$data['success'] = true; // always true unless network error

	switch($feed_requested){
		case 'foo';
			$data['mpservers'] = fgMPServers::feed();
			break;

		default:

			$data['feeds'] = $Feed->index();
			break;
	}

	//header('Content-type: text/plain');
	//echo json_encode($data);
	$Response->sendPayload();

} catch (fgException $e) {
    //echo 'Caught exception: ',  $e->getMessage(), "\n";
	$Response->sendError($e);
	
}


?>