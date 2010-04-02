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
	const type = 'mpserver';
	const ini = 'mpservers.ini';
	private $_servers = array();
	
	public function __construct($id = null){
		parent::__construct($id);
	}
	public function import(){
		$arr  = parse_ini_file(fgSite::configPath().self::ini, true);
		foreach($arr as $host => $v){
			$parts = explode(".", $host);
			$s = new fgServer(0);
			$s->nick = $parts[0];
			$s->type = self::type;
			$s->host	= $host;
			$s->ip 		= isset($v['ip']) ? $v['ip'] : null;
			$s->contact	= isset($v['contact']) ? $v['contact'] : null;
			$s->location	= isset($v['location']) ? $v['location'] : null;
			$s->irc		= isset($v['irc']) ? $v['irc'] : null;
			$s->tracked	= $v['tracked'] == 1 ? true : null;
			$s->save();
		}

	}

	/* public function save(){
		$vars = array(	$this->type, $this->nick, 
						$this->host, $this->ip, 
						$this->contact, $this->irc, $this->location, $this->tracked
					);
		if($this->id() == 0){
			$sql = 'insert into servers(
					type, nick, host, ip, contact, irc, location, tracked, date_created
				)values(
					?,    ?,    ?,    ?,  ?,       ?,   ?,       ?,        now()
				)';
				$this->db->execute($sql, $vars);
				$this->insert_id();
		}else{
			$sql = 'update servers set
					type=?, type=?, type=?, type=?, type=?, date_updated=now()
				';
				$this->db->execute($sql, $vars);
		}
		
		return $this->id();
	}
	*/

	public function index(){
		//$sql = 'select * from servers where type=? order by host asc';
		//return $this->db->getAll($sql, array('mpserver'));
		return fgServer::index(self::type);
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