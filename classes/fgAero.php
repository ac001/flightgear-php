<?php
/** Aero - in the air
 * @package FlightGear
 * @subpackage Content
 * @copyright (C) 2010 FlightGear Team
 * @author Peter Morgan <ac001@daffodil.uk.com>
 * @version 0.2
 *
 *
*/
class fgAero extends fgObject
{

	private $_servers = array();
	
	
	public function __construct($id = null){
		parent::__construct($id);

		if($this->id() > 0){
			$this->load();
		}
	}

	public function load(){
		$sql = 'select * from aero where aero_id=? limit 1';
		$this->setData( $this->db->getRow($sql, $this->id()) );
	}
	public function thumbnail(){
		return 'Aircraft/'.$this->directory.'/thumbnail.jpg';
	}

	public function save(){
		$vars = array(	$this->aero, $this->directory, 
						$this->name, $this->description, 
						$this->splash, $this->fdm, $this->status
					);
		if($this->id() == 0){
			$sql = 'insert into aero(
					aero, directory, name, description, splash, fdm, status,  date_created
				)values(
					?,    ?,         ?,    ?,           ?,      ?,   ?,      now()
				)';
				$this->db->execute($sql, $vars);
				$this->insert_id();
		}else{
			$sql = 'update aero set
					aero=?, directory=?, name=?, description=?, splash=?, fdm=?, status=?,  date_updated=now()
					where aero_id = ?
				';
				$vars[] = $this->id();
				$this->db->execute($sql, $vars);
		}
		
		return $this->id();
	}

	public static function find($column, $value){
		global $db;
		$sql = 'select aero_id from aero where '.$column.' = ?';
		$aero_id = $db->getOne($sql, $value);
		return count($aero_id) > 0 ? $aero_id : none;
	}

	public static function index(){
		global $db, $Site;
		$sql_where = '';
		//$ob = new fgObject($_REQUEST);
		if($Site->Request->alpha != ''){
			$sql_where = ' where aero like "'.$Site->Request->alpha.'%" ';
		}
		if($Site->Request->search != ''){
			$sql_where = ' where name like "%'.$Site->Request->search.'%" ';
		}
		$sql = 'select * from aero ';
		$sql .= $sql_where;
		$sql .= ' order by aero asc';
		return $db->getAll($sql);
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

	public function addAuthor($user_id){
		$vars =array($user_id, $this->id());
		$sql = 'select count(*) from user_links where user_id=? and aero_id=?';
		$count = $this->db->getOne($sql, $vars);
		if($count == 0){
			$sql = 'insert into user_links (user_id, aero_id) values(?,?)';
			$this->db->execute($sql, $vars);
		}
	}

	public static function a2z(){
		global $db;
		$sql = 'select distinct(upper(left(aero, 1))) as a2z from aero order by a2z asc';
		return $db->getCol($sql);
	}
}
?>