<?php

require_once('../config/config.inc.php');

//* Feed object
$Feed = new fgFeed();

$Response = new fgResponse();

try{

	//*  Process Request
	$feed_requested = isset($_REQUEST['feed']) ? $_REQUEST['feed'] : null;
	if($feed_requested){
		$Feed->validateRequest($feed_requested);
		$Response->add( $Feed->getFeed($feed_requested) );
	}else{
		$Response->add( $Feed->index() );
	}

	//header('Content-type: text/plain');
	//echo json_encode($data);
	$Response->sendPayload();

} catch (fgException $e) {
    //echo 'Caught exception: ',  $e->getMessage(), "\n";
	$Response->sendError($e);
	
}


?>