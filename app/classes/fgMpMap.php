<?php
/** Map Mirrors
 * @package FlightGear
 * @subpackage Content
 * @copyright (C) 2010 FlightGear Team
 * @author Peter Morgan <ac001@daffodil.uk.com>
 * @version 0.1
 *
 *
*/
class fgMpMap extends fgObject
{
	//const ini = 'mirrors.ini';
	public $server_type = 'mpmap';
	public $caption = 'MultiPlayer Maps';
	

	public function __construct($id = null){
		parent::__construct($id);
	}

	public function import(){
		$arr  = fgHelper::loadIniFile(self::ini, false);
		$server_type_id = fgServerType::idFromKey($this->server_type);
		foreach($arr as $location => $v){
			$s = new fgServer(0);
			$s->nick = null;
			$s->server_type_id = $server_type_id;
			$s->host	= $v['server'];
			$s->location	= $location;
			$s->ip 		= isset($v['ip']) ? $v['ip'] : null;
			$s->save();
		}

	}


	public function index(){
		return fgServer::index($this->server_type);
	}

	public function feed(){
		$arr = array();
		return $arr;
	}
	
}
?>