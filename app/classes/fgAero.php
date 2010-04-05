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
	public $xmlSet = null;
	public $xmlModel = null;
	
	
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
		$file_path = 'CVS/data/'.'Aircraft/'.$this->directory.'/thumbnail.jpg';
		return $file_path;
	}

	public function save(){
		$vars = array(	$this->aero, $this->directory, $this->xml_set,
						$this->name, $this->description, 
						$this->splash, $this->fdm, $this->status
					);
		if($this->id() == 0){
			$sql = 'insert into aero(
					aero, directory, xml_set, name, description, splash, fdm, status,  date_created
				)values(
					?,    ?,         ?,        ?,    ?,           ?,      ?,   ?,      now()
				)';
				$this->db->execute($sql, $vars);
				$this->insert_id();
		}else{
			$sql = 'update aero set
					aero=?, directory=?, xml_set=?,  name=?, description=?, splash=?, fdm=?, status=?,  date_updated=now()
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
		global $db;
		$sql_where = '';
		$ob = new fgObject($_REQUEST);
		if($ob->search != ''){
			$sql_where = ' where name like "%'.$ob->search.'%" ';
		}else{
			$sql_where = ' where aircraft_id = 0';
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



	public static function a2z(){
		global $db;
		$sql = 'select distinct(upper(left(aero, 1))) as a2z from aero order by a2z asc';
		return $db->getCol($sql);
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

	public function authors(){
		$sql = 'select users.user_id, name from users
				inner join user_links on users.user_id = user_links.user_id
				where user_links.aero_id=?';
		return  $this->db->getAll($sql, $this->id());
	}


    public function DEADgetXmlSet(){
        $file_name = FG_ROOT.'Aircraft/'.$this->directory.'/'.$this->aero.'-set.xml';
		
		$contents = fgHelper::loadFile($file_name);
		$xml = simplexml_load_string($contents);
		##
		fgHelper::plain();
		echo $file_name."'\n\n";
		echo "#".$xml->sim->description;
		echo "\n-------------------\n\n";
		print_r($xml);
		foreach($xml as $k){
			//echo "$k#\n";
			
		}
		
		//echo $contents;
    }

	public function xmlPath(){
		return FG_ROOT.'Aircraft/'.$this->directory.'/';
	}

	public function loadXmlSet(){
		$this->xmlSet = new fgXmlAeroSet( $this->xml_set, $this->xmlPath());
	}

	public function loadXmlModel(){
		$this->xmlModel = new fgXmlAeroSet($this->xmlPath());
	}

	public function info(){
		if(!isset($this->xmlSet)){
			$this->loadXmlSet();
		}
		$array = array();
		//$array['thumbnail'] = $this->thumbnail();
		$array['help'] = $this->xmlSet->help();
		$array['tanks'] = $this->xmlSet->tanks();
		$array['keyboard'] = $this->xmlSet->keyboard();
		
		//print_r($array);
		return $array;
	}

}
?>