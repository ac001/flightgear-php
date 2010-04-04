<?php
/** Irc Handler
 * @package FlightGear
 * @subpackage Content
 * @copyright (C) 2010 FlightGear Team
 * @author Peter Morgan <ac001@daffodil.uk.com>
 * @version 0.2
 *
 *
*/
class fgMpServer extends fgObject
{
	//const type = 'mpserver';
	const ini = 'mpservers.ini';
	public $server_type = 'mpserver';
	public $caption = 'MP Servers';
	const foo = 'bar';
	private $_servers = array();
	
	public function __construct($id = null){
		parent::__construct($id);
	}
	public function import(){
		$arr  = fgHelper::loadIniFile(self::ini, false);
		$server_type_id = fgServerType::idFromKey($this->server_type);
		foreach($arr as $host => $v){
			$parts = explode(".", $host);
			$s = new fgServer(0);
			$s->nick = $parts[0];
			$s->server_type_id = $server_type_id;
			$s->host	= $host;
			$s->ip 		= isset($v['ip']) ? $v['ip'] : null;
			$s->contact	= isset($v['contact']) ? $v['contact'] : null;
			$s->location	= isset($v['location']) ? $v['location'] : null;
			$s->irc		= isset($v['irc']) ? $v['irc'] : null;
			$s->tracked	= $v['tracked'] == 1 ? true : null;
			$s->save();
		}

	}


	public function index(){
		return fgServer::index($this->server_type);
	}

	public function feed(){
		$arr = array();
		$arr['mpservers'] = array_values($this->_servers);
		return $arr;
	}

	public function conf(){
		$str =  '# source: '.'url here'."\n";
		$str .= '# dated: '.date("Y-m-d H:I:s")."\n\n";
		foreach($this->_servers as $srv){
			$str .= sprintf("# %s\n%s\n\n", $srv['location'], $srv['host']);
		}
		return $str;
	}
}
?>