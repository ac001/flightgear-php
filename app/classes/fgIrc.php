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
class fgIrc extends fgObject
{
	const ini = 'irc.ini';
	public $server_type = 'irc';
	public $caption = 'FTP Mirrors';

	public $server = 'irc.flightgear.org';
	public $url = 'irc://irc.flightgear.org/';
	
	public function __construct(){
		parent::__construct();
	}

	public function import(){
		global $Site;
		$ini  = fgHelper::loadIniFile(self::ini, false);
		$server_type_id = fgServerType::idFromKey($this->server_type);
		foreach($ini as $channel => $v){
			$s = new fgServer(0);
			$s->nick = $v['title'];
			$s->server_type_id = $server_type_id;
			$s->host	= $this->server;
			$s->location	= $channel;
			$s->irc =  null;
			$s->save();
		}

	}


	public function index(){
		return fgServer::index(self::type);
	}

	public function feed(){
		$arr = array();
		$arr['help'] = 'IRC chat, servers and channels';
		$arr['server'] = self::server;
		$arr['url'] = self::url;
		$arr['channels'] = array_values($this->_channels);
		return $arr;
	}
}
?>