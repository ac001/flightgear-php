<?php

require_once('../config/config.inc.php');

$slide_shows = array();
$slide_shows['index'] = array('title' => 'FlightGear Slide Shows', 'author' => 'Pete Morgan');
$slide_shows['curcuit'] =  array('title' => 'Tutorial: Flying A Circuit', 'author' => 'David Messingon');


$slide_shows['tutorial'] = array('title' => 'Tutorial: Cross Country', 'author' => 'SSSS');
$slide_shows['ksfo_klax'] = array('title' => 'Tutorial: KSFO to KLAX', 'author' => 'SSSS');
$slide_shows['howto_slideshow'] = array('title' => 'How to create a Slide Show', 'author' => 'Pete Morgan');





$var = isset($_GET['slide_show']) && $_GET['slide_show'] != '' ? $_GET['slide_show'] : null;
$slide_show = $var && array_key_exists($var, $slide_shows) ? $var : 'index';

//* absolute path as not in templates/
$template_file = SITE_ROOT.'slide_shows/'.$slide_show.'/index.html'; 
$show = $slide_shows[$slide_show];

$smarty->assign('site_title', 'FlightGear Slide Shows');
$smarty->assign('template_file', $template_file);
$smarty->assign('show', $show);
$smarty->assign('slide_shows', $slide_shows);
$smarty->display('slide_show_container.html');
?>