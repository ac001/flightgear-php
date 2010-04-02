#!/usr/bin/php 
<?php

$LOAD_DB = true;
require_once('../config/config.inc.php');

//$db->debug=1;
$db->execute("delete from servers");


$m = new fgIrc();
$m->import();

$m = new fgMirror();
$m->import();
//die();
$m = new fgMpServer();
$m->import();


?>
