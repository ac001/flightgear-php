<?php

require_once('../config/config.inc.php');

//$url = "sshttp://mpmap02.flightgear.org/fg_server_xml.cgi?mpserver02.flightgear.org:5001s";

//$xml_string = file_get_contents($url);
//echo "<pre>";
//print_r($xml_string);
//die;


//* Feed object
$Feed = new fgFeed();

$Response = new fgResponse();

try{

	//*  Process Request
	$feed_requested = isset($_REQUEST['feed']) ? $_REQUEST['feed'] : null;
	if($feed_requested){
		$Feed->validateFeed($feed_requested);
		$Response->add( $Feed->getFeed($feed_requested) );
	}else{
		$Response->add( $Feed->welcomeIndex() );
	}

	//header('Content-type: text/plain');
	//echo json_encode($data);
	$Response->sendPayload();

} catch (fgException $e) {
    //echo 'Caught exception: ',  $e->getMessage(), "\n";
	$Response->sendError($e);
	
}


?>