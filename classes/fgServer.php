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

	public static function index($type = null){
		global $db;
		$sql = 'select * from servers ';
		$sql .= $type ? 'where type=?' : '';
		$sql .= ' order by host asc';
		return $db->getAll($sql, $type ? array($type) : array());
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