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
	public static function loadIniFile($ini_file, $process_sections=true){
		return parse_ini_file(fgSite::configPath().$ini_file, $process_sections);
		//return $as_class ? new fgObject($ini_vars) : $ini_vars;
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