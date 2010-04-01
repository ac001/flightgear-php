<?php
/** Irc Handler
 * @package FlightGear
 * @subpackage www
 * @copyright (C) 2010 FlightGear Team
 * @author Peter Morgan <ac001@daffodil.uk.com>
 * @version 0.2
 *
 *
*/
class fgMpServer
{
	const ini = 'mpservers.ini';

	private $_servers = array();
	
	/*
	[mpserver01.flightgear.org]
	tracked = 1
	location = "Germany"
	contact ="Oliver Schroeder"
	irc="os"	
	*/
	public function __construct(){
		$arr  = parse_ini_file(fgSite::configPath().self::ini, true);
		foreach($arr as $host => $v){
			$this->_servers[$host] = array('host' => $host, 
											'location' => $v['location'],
											'contact' => $v['contact'],
											'irc' => $v['irc'],
											'tracked' => $v['tracked']
									);
		}
	}

	public function channels(){
		return $this->_channels;
	}

	public function feed(){
		$arr = array();
		$arr['mpservers'] = array_values($this->_servers);
		//$arr['url'] = self::url;
		//$arr['channels'] = $this->_channels;
		return $arr;
	}
}
?>