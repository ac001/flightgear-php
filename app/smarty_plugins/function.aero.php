<?php

//print_r($Site);
function smarty_function_aero($params, &$smarty)
{
	$Aero = is_array($params['aero']) ? new fgObject($params['aero']) : $params['aero'];
	//print_r($Aero);
	if(isset($params['thumb'])){
		$size = $params['thumb'];
		//$dir = is_array($params['aero']) ? $params['aero']['directory'] : $params['aero']->directory;
		$src = 'CVS/data/Aircraft/'.$Aero->directory.'/thumbnail.jpg';
		
		if(!file_exists(SITE_ROOT.$src)){
			$src = 'images/no_image.gif';
		}
		#secho SITE_ROOT.$src."#".file_exists(SITE_ROOT.$src)."#";
		return "<img width=$size src='$src'>";
	}
	
	if(isset($params['splash'])){
		//$size = $params['splash'];
		$img = is_array($params['img']) ? $params['aero']['splash'] : $params['aero']->splash;
		$src = 'CVS/data/'.$img;
		
		if(!file_exists(SITE_ROOT.$src)){
			$src = 'images/no_image.gif';
		}
		#secho SITE_ROOT.$src."#".file_exists(SITE_ROOT.$src)."#";
		return "<img width=$size src='$src'>";
	}
}


?>