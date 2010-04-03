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
	const ini = 'mirrors.ini';
	public $server_type = 'mirror';
	public $caption = 'FTP Mirrors';
	

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
			$s->server_type = $this->server_type;
			$s->host	= $v['server'];
			$s->location	= $location;
			$s->ip 		= isset($v['ip']) ? $v['ip'] : null;
			$s->save();
		}

	}


	public function index(){
		$fgServer::index($this->server_type);
	}

	public function feed(){
		$arr = array();
		$arr['mirrors'] = array_values($this->_mirrors);
		return $arr;
	}
	
}
?>