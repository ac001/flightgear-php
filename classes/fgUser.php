<?php
/** User Object
 * @package FlightGear
 * @subpackage User
 * @copyright (C) 2010 FlightGear Team
 * @author Peter Morgan <ac001@daffodil.uk.com>
 * @version 0.2
 *
 *
*/
class fgUser extends fgObject
{

	
	public function __construct($id = null){
		parent::__construct($id);
	}


	public function save(){
		$vars = array(	$this->email, $this->name, 
						$this->callsign, $this->irc, 
						$this->cvs, $this->location, $this->passwd
					);
		if($this->id() == 0){
			$sql = 'insert into users(
					email, name, callsign, irc, cvs, location, passwd, date_created  
				)values(
					?,    ?,     ?,        ?,   ?,   ?,        ?,       now()
				)';
				$this->db->execute($sql, $vars);
				$this->insert_id();
		}else{
			$sql = 'update users set
					type=?, type=?, type=?, type=?, type=?, date_updated=now()
				';
				$this->db->execute($sql, $vars);
		}
		
		return $this->id();
	}


	public function setPassword($pass){
		$sql = 'update users set passwd=? where user_id=?';
		$this->db->execute($sql, array(md5($pass), $this->id()));
	}

	public function genToken(){
		$this->token = uniqid();
		$sql = 'update users set token=? where user_id=?';
		$this->db->execute($sql, array($this->token, $this->id()));
	}

	public function sendEmail($type){
		$Mail = new fgMail();

		switch($type){
			case 'ack':
				$Mail->setSubject('Acknowlege email');
				$Mail->setTitle('Acknowlege email');
				break;
		}

		$Mail->sendMail($this, $type);
	}


	public static function index(){
		global $db;
		$sql = 'select user_id, name, email, callsign, cvs, irc, location, active 
				from users
				order by name asc
		';
		return $db->getAll($sql);
	}

	public static function find($column, $value){
		global $db;
		$sql = 'select user_id from users where ?=?';
		$row = $db->getRow($sql, array($column, $value));
		if(count($row) > 0){
			return $row['user_id'];
		}
		return null;
	}

}
?>