<?php

require_once('../config/config.inc.php');

//** Keeping self contained ie own images etc

$template_path = SITE_ROOT.'slide_shows/';

$url = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']);
$smarty->assign('SITE_URL', $url);

if(isset($_GET['download_template'])){

    header('Content-type: test/plain');
    header('Content-Disposition: attachment; filename="slideshow_template.html"');
    $smarty->assign('template_file', $template_path.'_template_.html');
    echo  $smarty->fetch($template_path.'slide_show_container.html');

    die;
}





$slide_shows = array();
$slide_shows['index'] = array('title' => 'FlightGear Slide Shows', 'author' => '');
$slide_shows['circuit'] =  array('title' => 'Tutorial: Flying A Circuit', 'author' => 'David Messingon');


//$slide_shows['tutorial'] = array('title' => 'Tutorial: Cross Country', 'author' => 'SSSS');
//$slide_shows['ksfo_klax'] = array('title' => 'Tutorial: KSFO to KLAX', 'author' => 'SSSS');
$slide_shows['howto_slideshow'] = array('title' => 'How to create a Slide Show', 'author' => 'Pete Morgan');





$var = isset($_GET['slide_show']) && $_GET['slide_show'] != '' ? $_GET['slide_show'] : null;
$slide_show = $var && array_key_exists($var, $slide_shows) ? $var : 'index';

//* absolute path as not in templates/
$template_file = $template_path.$slide_show.'/index.html'; 
$show = $slide_shows[$slide_show];

$smarty->assign('site_title', 'FlightGear Slide Shows');
$smarty->assign('template_file', $template_file);
$smarty->assign('show', $show);
$smarty->assign('slide_shows', $slide_shows);
$smarty->display($template_path.'slide_show_container.html');
?>