#!/usr/bin/php 
<?php

$LOAD_DB = true;
require_once('../config/config.inc.php');

//$db->debug=1;
$db->execute("delete from servers");
$db->execute("delete from server_types");

$types = array();
$types['mpmap'] = 'MP Map';
//$types['scenery'] = 'Map Server';
$types['mapserver'] = 'Map Server';
$types['mpserver'] = 'Map Server';
//$types['scenery'] = 'Scenery';
$types['mirror'] = 'FTP Mirrors';
$types['irc'] = 'Irc';

$ids = array();
foreach($types as $t => $v){
	$st = new fgServerType(0);
	$st->server_type_key = $t;
	$st->server_type = $v;
	$new_id = $st->save();
	$ids[$t] = $new_id;
}
//$db->debug=1;
$m = new fgIrc();
$m->import();

$m = new fgMirror();
$m->import();

$m = new fgMpServer();
$m->import();


$S = new fgServer(0);
$S->server_type = $ids['mpmap'];
$S->nick = 'mpmap01';
$S->host = 'http://mpmap01.flightgear.org';
$S->save();

$S = new fgServer(0);
$S->server_type_id = $ids['mpmap'];
$S->nick = 'mpmap02';
$S->host = 'http://mpmap02.flightgear.org';
$S->irc = 'pigeon';
$S->contact = 'Pigeond';
$S->location ='Honk Kong';
$S->save();

$S = new fgServer(0);
$S->server_type = $ids['mapserver'];
$S->nick = 'mapserver';
$S->host = 'http://mapserver.flightgear.org';
$S->save();
/*
$S = new fgServer(0);
$S->server_type = $ids['hangar'];
$S->nick = 'mapserver';
$S->host = 'http://mapserver.flightgear.org';
$S->save();
*/

?>
