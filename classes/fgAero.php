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
					aero=?, directory=?, name=?, description=?, splash=?, fdm=?, status=?  date_updated=now()
					where aero_id = ?
				';
				$vars[] = $this->id();
				$this->db->execute($sql, $vars);
		}
		
		return $this->id();
	}

	public static function index($type = null){
		global $db;
		$sql = 'select * from aero ';
		//$sql .= $type ? 'where type=?' : '';
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
}
?>