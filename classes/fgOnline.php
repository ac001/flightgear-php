<?php
/** Online Handler
 * @package FlightGear
 * @subpackage Content
 * @copyright (C) 2010 FlightGear Team
 * @author Peter Morgan <ac001@daffodil.uk.com>
 * @version 0.2
 *
 *
*/
class fgOnline
{
	const feed_url = 'http://mpmap02.flightgear.org/fg_server_xml.cgi?mpserver02.flightgear.org:5001';

	private $_servers = array();
	
	public function __construct(){
	}

	public function feed(){
		
		$Curl = curl_init(self::feed_url);
		curl_setopt($Curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($Curl, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($Curl, CURLOPT_TIMEOUT, 10);

    $xml_string = curl_exec($Curl);
    $info = curl_getinfo($Curl);
    //** we cont get more info from curl, 404'd appear as http_code == 0 .. wtf
    if($info['http_code'] != 200) {
		throw new fgException('curl error', 'Did not fetch feed url');
    }
	header('Content-type: text/xml');
    echo $xml_string;
	die;	
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