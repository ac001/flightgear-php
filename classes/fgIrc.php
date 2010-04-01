<?php
/** Irc Handler
 * @package FlightGear
 * @subpackage WWW
 * @copyright (C) 2010 Peter Morgan
 * @author Peter Morgan <ac001@daffodil.uk.com>
 * @version 0.1
 *
 *
*/
class fgIrc
{
	public $url = 'irc://irc.flightgear.org/';

	private $_channels = array(
			array('chan' => 'flightgear', 'title' =>  'Main Channel'),
			array('chan' => 'fg_cantene', 'title' =>  'Pilots Mess' ),
			array('chan' => 'fg_school', 'title' =>  'Flight Training' ),
			array('chan' => 'airliners', 'title' =>  'flightgear'),
			array('chan' => 'wiki', 'title' =>  'Wiki Chat' ),
		);

	public function channels(){
		return $this->_channels;
	}	

}
?>