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
	
	public function __construct(){
		$arr  = parse_ini_file(fgSite::configPath().self::ini, true);
		foreach($arr as $host => $v){
			//print_r($v);
			$arr = array();
			$arr['host'] 	= $host ;
			$arr['nick'] 	= $v['nick'];
			$arr['ip'] 		= $v['ip'] ? $v['ip'] : null;
			$arr['contact']	= $v['contact'] ? $v['contact'] : null;
			$arr['irc']		= $v['irc'] ? $v['irc'] : null;
			$arr['tracked']	= $v['tracked'] ? true : false;
			$arr['updated']	= $v['updated'] ? $v['updated'] : null;
			$this->_servers[] =$arr;
		}
		print_r($this->_servers);
	}

	public function index(){
		return $this->_servers;
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