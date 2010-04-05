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

	public static function index($server_type_key = null){
		global $db;
        static $cached = array();
        $server_type_key = is_null($server_type_key) ? '__ALL__' : $server_type_key;
        if(array_key_exists($server_type_key, $cached)){
              return $cached[$server_type_key];
        }
		$vars = array();
		$sql = 'select * from servers ';
		$sql .= ' inner join server_types on server_types.server_type_id = servers.server_type_id ';
		if($server_type_key){
			$sql .= 'where server_types.server_type_key=?';
			$vars[] = $server_type_key;
		}
		$sql .= ' order by host asc';
		$cached[$server_type_key] = $db->getAll($sql, $vars );
        return $cached[$server_type_key];
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