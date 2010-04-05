<?php

require_once('config/config.inc.php');

$Site = new fgSite('webdev', 'DEV');

$foo = new fgMpServer(); //::index();
//fgMpServer::index();
//print_r($foo->index());
$foo->url;

$db->debug=1;

// Cahce test
/*
(fgServer::index('mpserver'));
(fgServer::index('mirror'));
(fgServer::index('mpmap'));
(fgServer::index('mpserver'));
(fgServer::index('mirror'));
*/

die();
$aero = new fgAero(20);
print_r($aero->authors());



die();


try{

$style_sheets = fgStyle::skins();
print_r($style_sheets);

} catch (fgException $e) {
    //echo 'Caught exception: ',  $e->getMessage(), "\n";
	$e->error();
	
}




?>