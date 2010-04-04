<?php

require_once('../config/config.inc.php');

//isset($slide_show)
$slide_show = isset($_GET['slide_show']) && $_GET['slide_show'] != '' ? $_GET['slide_show'] : 'index'; 

$slide_show_file = SITE_ROOT.'slide_shows/'.$slide_show.'/index.html';
$smarty->assign('slide_show_file',$slide_show_file);

$smarty->display('slide_show_container.html');
?>