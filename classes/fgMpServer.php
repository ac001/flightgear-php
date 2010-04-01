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
	const ini = 'mpservers.ini';

	private $_servers = array();
	
	public function __construct($id = null){
		parent::__construct($id);
	}
	public function import(){
		$arr  = parse_ini_file(fgSite::configPath().self::ini, true);
		foreach($arr as $host => $v){
			//print_r($v);
			$parts = explode(".", $host);
			$s = new fgMpServer(0);
			$s->nick = $parts[0];

			$s->ip 		= isset($v['ip']) ? $v['ip'] : null;
			$s->contact	= isset($v['contact']) ? $v['contact'] : null;
			$s->irc		= isset($v['irc']) ? $v['irc'] : null;
			$s->tracked	= $v['tracked'] ? true : false;
			$s->save();
			/*
			$arr = array();
			$arr['host'] 	= $host ;
			$arr['nick'] 	= $v['nick'];
			$arr['ip'] 		= $v['ip'] ? $v['ip'] : null;
			$arr['contact']	= $v['contact'] ? $v['contact'] : null;
			$arr['irc']		= $v['irc'] ? $v['irc'] : null;
			$arr['tracked']	= $v['tracked'] ? true : false;
			$arr['updated']	= $v['updated'] ? $v['updated'] : null;
			$this->_servers[] =$arr;
			*/
		}
		print_r($this->_servers);
	}

	public function save(){
		$vars = array(	$this->type, $this->nick, 
						$this->host, $this->ip, 
						$this->contact, $this->tracked
					);
		if($this->id() == 0){
			$sql = 'insert into server(
					type, nick, host, ip, contact, tracked
				)values(
					?,    ?,    ?,    ?,  ?,       ?
				)';
		}else{
			$sql = 'update server set
					type=?, type=?, type=?, type=?, type=?, type=?
				';
		}
	}

	public function index(){
		$sql = 'select * from servers where type=? order by host asc';
		return $this->db->getAll($sql, array('mpserver'));
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