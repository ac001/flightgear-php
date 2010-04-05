<?php

require_once('config/config.inc.php');

$Site = new fgSite('webdev', 'DEV');

//$foo = new fgMpServer(); //::index();
//fgMpServer::index();
//print_r($foo->index());
//$foo->url;

//$db->debug=1;
fgHelper::plain();
$Aero = new fgAero(10);
//print_r($a);
echo $Aero->xmlPath()."\n";
//$aeroXml = new fgXmlAeroSet($a->xmlFile());

$info = $Aero->info();
//print_r($info);
die;
//echo $aeroXml->help();

$keys = $aeroXml->keyboard();
//print_r($keys);

$tanks = $aeroXml->tanks();
//print_r($tanks);


$model_file =  $aeroXml->modelPath();
echo $model_file."\n";

$modelXml = new fgXmlAeroModel($model_file);
//print_r($modelXml->Doc);



##print_r($aeroXml->Doc);
echo "\n----------------------\n";
//echo $aeroXml->Raw;
//print_r($aeroXml->Doc);
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