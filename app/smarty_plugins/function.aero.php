<?php

//print_r($Site);
function smarty_function_aero($params, &$smarty)
{
	$Aero = is_array($params['aero']) ? new fgObject($params['aero']) : $params['aero'];
	//print_r($params);
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
		$size = 500;
		$no_image = "<img width=$size src='images/no_image.gif'>";

		$file_name = 'CVS/data/'.$Aero->splash;
		//echo $file_name."#".$Aero->splash."#";
		if($Aero->splash == ""){
			return $no_image;
		}

		if(is_dir($file_name)){
			return $no_image;
		}
		if(!file_exists(SITE_ROOT.$file_name)){
			return $no_image;
		}
		if(substr($file_name, -4) == '.rgb'){
			return $no_image;
		}
		return "<img width=$size src='$file_name'>";
	}
}


?>