#!/usr/bin/php 
<?php

$LOAD_DB = true;
require_once('../config/config.inc.php');

//$db->debug=1;
$db->execute("delete from servers");

$S = new fgServer(0);
$S->type = 'mpmap';
$S->nick = 'mpmap01';
$S->host = 'http://mpmap01.flightgear.org';
$S->save();

$S = new fgServer(0);
$S->type = 'mpmap';
$S->nick = 'mpmap02';
$S->host = 'http://mpmap02.flightgear.org';
$S->irc = 'pigeon';
$S->contact = 'Pigeond';
$S->location ='Honk Kong';
$S->save();

$S = new fgServer(0);
$S->type = 'mapserver';
$S->nick = 'mapserver';
$S->host = 'http://mapserver.flightgear.org';
$S->save();

$m = new fgIrc();
$m->import();

$m = new fgMirror();
$m->import();
//die();
$m = new fgMpServer();
$m->import();


?>
