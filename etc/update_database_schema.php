#!/usr/bin/php 
<?php

$LOAD_DB = true;
require_once('../config/config.inc.php');

require_once('../config/DB_Schema.php');

//********************************************************************
//** Update Database
//********************************************************************

$dict = NewDataDictionary($db);
$db->debug=1;
echo "### Updating tables\n";
//$dict->debug=1;
foreach($tables as $table => $flds){
	echo "## $table <br>\n";
	// print_r($flds);
	$sqlarray = $dict->ChangeTableSQL($table, $flds, '');
	//print_r($sqlarray);
	
	$dict->ExecuteSQLArray($sqlarray);
	// echo "<hr>";
	// die;
}
$db->debug=0;


?>
