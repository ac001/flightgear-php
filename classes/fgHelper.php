<?php
/** General Helpers and Utilities
 * @package FlightGear
 * @subpackage General
 * @copyright (C) 2010 FlightGear Team
 * @author Peter Morgan <ac001@daffodil.uk.com>
 * @version 0.1
 *
 *
*/
class fgHelper
{
	public static function loadFile($file_path){
		# TODO error file_exists and parse error handlers
		if(!file_exists($file_path)){
			die("No path to file ".$file_path);
		}
		return file_get_contents($file_path);
	}
	public static function loadIniFile($ini_file, $return_object=true){
		# TODO error file_exists and parse error handlers
		$ini_file = SITE_ROOT.'config/'.$ini_file;
		if(!file_exists($ini_file)){
			die("no file in path ".$ini_file);
		}
		$array =  parse_ini_file($ini_file, true);
		return $return_object == true ?  new fgObject($array) : $array;
	}
	public static function listFiles($directory = null, $extensions = null){

		if(!is_null($extensions) && !is_array($extensions)){
			$extensions = array($extensions);
		}

		$handler = opendir($directory);
		$results = array();
		while ($file = readdir($handler)) {
			if ($file != '.' && $file != '..' && $file != '.svn'){
				if($extensions){
					if(in_array(substr($file, -4), $extensions)){
						$results[] = $file;
					}
				}else{
					$results[] = $file;
				}
			}
		}

		closedir($handler);
		return $results;
	
	}

}
?>