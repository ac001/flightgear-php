<?php

$REQUIRE_SMARTY = true;
require_once('config/config.inc.php');

$g = new fgGallery();
print_r($g->index());

?>