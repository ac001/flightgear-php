<?php
/** Skeleton Class
 * @package FlightGear
 * @subpackage Missc
 * @copyright (C) 2010 FlightGear Team
 * @author Peter Morgan <ac001@daffodil.uk.com>
 * @version 0.1
 *
 *
*/

class fgSkel extends fgObject
{

	const feed_url = 'http://mpmap02.flightgear.org/fg_server_xml.cgi?mpserver02.flightgear.org:5001';
	//const ini = "skel.ini"
	

	private $_servers = array();
	
	public function __construct(){
		parent::__construct();
	}

	//** Index
	public function index(){
		$sql = 'select * from _table_ order by _col_ asc';
		
	}

	//** Feed
	public function feed(){
		
	}


}

?>