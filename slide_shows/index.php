<?php

require_once('../config/config.inc.php');

//isset($slide_show)
if(isset($_GET['slide_show']) && $_GET['slide_show'] != ''){
	$template = $_GET['slide_show'];
	$SlideShow = array('title' => 'FlightGear Slide Shows', 'author' => 'David Messingon');
}else{
	$template = 'circuit';
	$SlideShow = array('title' => 'A Circuit in FlightGear', 'author' => 'David Messingon');
}
$slide_show_file = SITE_ROOT.'slide_shows/'.$template.'/index.html';

$smarty->assign('site_title', 'FlightGear Slide Shows');
$smarty->assign('slide_show_file', $slide_show_file);
$smarty->assign('SlideShow', $SlideShow);
$smarty->display('slide_show_container.html');
?>