<?php
/** Session Handler
 * @package FlightGear
 * @subpackage Core
 * @copyright (C) 2010 FlightGear Team
 * @author Peter Morgan <ac001@daffodil.uk.com>
 * @version 0.1
 *
 *
*/
class fgSession extends fgObject
{

	public function __construct(){
		global $_SESSION;
		print_r($_SESSION);
		if(isset($_SESSION[SITE_KEY])){
			$this->set('skin', 'skin.ac001.css');
		}
		foreach($_SESSION[SITE_KEY] as $k => $v){
			$this->set($k, $v);
		}
	}
	
	public function set($key, $value=null){
		$_SESSION[SITE_KEY][$key] = $value;
		$this->$key = $value;
		print_r($_SESSION);
	}

	public function save(){
		# TODO
		return false;
		
	}


}
?>