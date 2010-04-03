<?php
/** Style Helper
 * @package FlightGear
 * @subpackage General
 * @copyright (C) 2010 FlightGear Team
 * @author Peter Morgan <ac001@daffodil.uk.com>
 * @version 0.1
 *
 *
*/
class fgStyle
{
    const mime_type  = 'text/plain';

	public static function skins(){
		$style_files = self::index();
		$results = array();
		foreach($style_files as $file){
			if(substr($file, 0, 5) == 'skin.'){	
				$results[] = $file;
			}
		}
		return $results;
	}

	public static function index(){
		return fgHelper::listFiles(SITE_ROOT.'/style_sheets/', '.css');
	}
}
?>