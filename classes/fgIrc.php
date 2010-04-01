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
	const server = 'irc.flightgear.org';
	const url = 'irc://irc.flightgear.org/';

	private $_channels = array();
	
	public function __construct($id = null){
		parent::__construct($id);
	}

	public function import(){

		$arr  = parse_ini_file(fgSite::configPath().self::ini, true);
		foreach($arr as $channel => $v){
			$this->_channels[] = array('channel' => $channel, 'url' => self::url.$channel, 'title' => $v['title'] );
			$s = new fgMpServer(0);
			$s->nick = $v['title'];
			$s->type = 'irc';
			$s->host	= 'irc.flightgear.org';
			$s->location	= $channel;
			$s->irc 		=  null;
			//$s->contact	= isset($v['contact']) ? $v['contact'] : null;
			//$s->irc		= isset($v['irc']) ? $v['irc'] : null;
			//$s->tracked	= $v['tracked'] == 1 ? true : null;
			$s->save();

		}

	}


	public function channels(){
		return $this->_channels;
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