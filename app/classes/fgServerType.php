<?php
/** Server Type
 * @package FlightGear
 * @subpackage Core
 * @copyright (C) 2010 FlightGear Team
 * @author Peter Morgan <ac001@daffodil.uk.com>
 * @version 0.2
 *
 *
*/
class fgServerType extends fgObject
{

	
	public function __construct($id = null){
		parent::__construct($id);
	}


	public function save(){
		$vars = array(	$this->server_type, $this->server_type_key
					);
		if($this->id() == 0){
			$sql = 'insert into server_types(
					server_type, server_type_key
				)values(
					?,    ?
				)';
				$this->db->execute($sql, $vars);
				$this->insert_id();
		}else{
			$sql = 'update server_types set
					server_type=?, server_type_key=? where server_type_id=?
				';
				$vars[] = $this->id();
				$this->db->execute($sql, $vars);
		}
		
		return $this->id();
	}





	public static function index(){
		global $db;
		$sql = 'select *
				from server_types
				order by server_type asc
		';
		return $db->getAll($sql);
	}

	public static function DEADfind($column, $value){
		global $db;
		$sql = 'select * from server_types where ?=?';
		$row = $db->getRow($sql, array($column, $value));
		if(count($row) > 0){
			return $row['server_type_id'];
		}
		return null;
	}
	public static function idFromKey($key){
		global $db;
		$sql = 'select server_type_id, server_type_key from server_types where server_type_key=?';
		$row = $db->getRow($sql, array($key));
		if(count($row) > 0){
			return $row['server_type_id'];
		}
		return null;
	}

}
?>