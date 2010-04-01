<?php
/** List of Mirrors
 * @package FlightGear
 * @subpackage www
 * @copyright (C) 2010 FlightGear Team
 * @author Peter Morgan <ac001@daffodil.uk.com>
 * @version 0.1
 *
 *
*/
class fgMirror
{
	const ini = 'mirrors.ini';
	
	private $_mirrors = array();

	public function __construct(){
		$arr  = parse_ini_file(fgSite::configPath().self::ini, true);
		ksort($arr);
		foreach($arr as $location => $v){
			$this->_mirrors[$location] = array('location' => $location, 'url' => $v['server']);
		}
		ksort($this->_mirrors);
	}

	public function index(){
		return $this->_mirrors;
	}

	public function feed(){
		$arr = array();
		$arr['mirrors'] = array_values($this->_mirrors);
		return $arr;
	}
	
}
?>