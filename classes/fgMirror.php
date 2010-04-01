<?php
/** List of Mirrors
 * @package FlightGear
 * @subpackage WWW
 * @author Peter Morgan <ac001@daffodil.uk.com>
 * @version 0.1
 *
 *
*/
class fgMirror
{
	const path = 'gallery/images/';
	
	private $_mirrors = array();

	public function __construct(){
		$this->addMirror('Germany', 'ftp://ftp.de.flightgear.org/pub/fgfs/');
		$this->addMirror('Germany', 'http://flightgear.mxchange.org/pub/fgfs/');
		$this->addMirror('South Africa', '	 ftp://ftp.is.co.za/pub/games/flightgear/');
		$this->addMirror('Ukraine', 'ftp://ftp.linux.kiev.ua/pub/mirrors/ftp.flightgear.org/flightgear/');
		$this->addMirror('USA, North Carolina', 'ftp://mirrors.ibiblio.org/pub/mirrors/flightgear/ftp/');
		$this->addMirror('USA, Minnesota', 'http://mirrors.ibiblio.org/pub/mirrors/flightgear/ftp/');
		$this->addMirror('USA, California', 'ftp://ftp.kingmont.com/flightsims/flightgear/');
	}

	public function addMirror($location, $host){
		$this->_mirrors = array('location' => $locaion, 'host' => $host);
	}

	public function index(){
		return $_mirrors;
	}


	
}
?>