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

}
?>