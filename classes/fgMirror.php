<?php
/** Ftp Mirrors
 * @package FlightGear
 * @subpackage Content
 * @copyright (C) 2010 FlightGear Team
 * @author Peter Morgan <ac001@daffodil.uk.com>
 * @version 0.1
 *
 *
*/
class fgMirror extends fgObject
{
	const type = 'mpserver';
	const ini = 'mirrors.ini';
	
	private $_mirrors = array();

	public function __construct($id = null){
		parent::__construct($id);
	}

	public function import(){
		$arr  = parse_ini_file(fgSite::configPath().self::ini, true);
		ksort($arr);
		foreach($arr as $location => $v){
			$this->_mirrors[$location] = array('location' => $location, 'url' => $v['server']);

			$s = new fgServer(0);
			$s->nick = null;
			$s->type = self::type;
			$s->host	= $v['server'];
			$s->location	= $location;
			$s->ip 		= isset($v['ip']) ? $v['ip'] : null;
			//$s->contact	= isset($v['contact']) ? $v['contact'] : null;
			//$s->irc		= isset($v['irc']) ? $v['irc'] : null;
			//$s->tracked	= $v['tracked'] == 1 ? true : null;
			$s->save();

		}

	}


	public function index(){
		return fgServer::index(self::type);
	}

	public function feed(){
		$arr = array();
		$arr['mirrors'] = array_values($this->_mirrors);
		return $arr;
	}
	
}
?>