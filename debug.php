<?php

$LOAD_SMARTY = true;
$LOAD_DB = true;
require_once('config/config.inc.php');

$db->debug=1;
$m = new fgMpServer();
$m->import();

?>