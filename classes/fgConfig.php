<?php
/** Config Object and .ini loader
 * @package FlightGear
 * @subpackage  Core
 * @author Peter Morgan ac001@daffodil.uk.com
 * @version 0.1
*/

//####################################################################################
//** Main Configuration **
//************************************************************************************
class fgConfig extends fgObject
{
	public function __construct($ini_file = null){

        $ini_array = fgHelper::loadIniFile('MAIN.ini', false);
		foreach($ini_array as $k => $v){
            $this->$k = new fgObject($v);
        }
	}


}
?>