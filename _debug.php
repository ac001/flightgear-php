<?php

$REQUIRE_SMARTY = true;
require_once('config/config.inc.php');

echo "yes";
echo SITE_ROOT;
$g = new fgGallery();
print_r($g->index());

?>