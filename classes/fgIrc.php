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
class fgIrc
{
	const ini = 'irc.ini';
	const url = 'irc://irc.flightgear.org/';
	private $_channels = array();
	

	public function __construct(){
		$arr  = parse_ini_file(fgSite::configPath().self::ini, true);
		foreach($arr as $channel => $v){
			$this->_channels[] = array('channel' => $channel, 'url' => self::url.$channel, 'title' => $v['title'] );
		}
	}

	public function channels(){
		return $this->_channels;
	}	

}
?>