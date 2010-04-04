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
class fgServer extends fgObject
{

	private $_servers = array();
	
	public function __construct($id = null){
		parent::__construct($id);
	}

	public function save(){
		$vars = array(	$this->server_type_id, $this->nick, 
						$this->host, $this->ip, 
						$this->contact, $this->irc, $this->location, $this->tracked, $this->active
					);
		if($this->id() == 0){
			$sql = 'insert into servers(
					server_type_id, nick, host, ip, contact, irc, location, tracked, active,  date_created
				)values(
					?,              ?,    ?,    ?,  ?,       ?,   ?,       ?,        ?,        now()
				)';
				$this->db->execute($sql, $vars);
				$this->insert_id();
		}else{
			$sql = 'update servers set
					server_type_id=?, nick=?, host=?, ip=?, contact=?, irc=?, location=?, tracked=?, active=?, date_updated=now()
					where server_id = ?
				';
				$vars[] = $this->id();
				$this->db->execute($sql, $vars);
		}
		
		return $this->id();
	}

	public static function index($server_type_id = null){
		global $db;
		$sql = 'select * from servers ';
		$sql .= $server_type_id ? 'where server_type_id=?' : '';
		$sql .= ' order by host asc';
		return $db->getAll($sql, $server_type ? array($server_type_id) : array());
	}

	public function feed(){
		$arr = array();
		$DEEEEarr['mpservers'] = array_values($this->_servers);
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