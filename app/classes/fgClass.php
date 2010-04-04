<?php
/** Class Helper and Introspection
 * @package FlightGear
 * @subpackage General
 * @copyright (C) 2010 FlightGear Team
 * @author Peter Morgan <ac001@daffodil.uk.com>
 * @version 0.1
 *
 *
*/
class fgClass
{

	private $_feeds = array();
	private $_handlers = array();

	public static function path($class_name){
		return SITE_ROOT.'classes/';
	}

	public static function filePath($class_name){
		return SITE_ROOT.'classes/'.$class_name.'.php';
	}

	public static function fileExists($class_name){
		return file_exists(self::filePath($class_name));
	}

	public static function methodExists($class_name, $method_name){
		return method_exists($class_name, $method_name);
	}
}
?>