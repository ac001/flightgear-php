<?php
/** Basic Setter/Getter Object with inheritance
 * @package FlightGear
 * @subpackage General
 * @copyright (C) 2010 FlightGear Team
 * @author Peter Morgan <ac001@daffodil.uk.com>
 * @version 0.1
 *
 *
*/
class fgObject 
{
	private $_ID;
    private  $_PROPS;
	protected $db;

    public function __construct($id = null){
		global $db;
		$this->db = $db;
		$this->_ID = $id;
    }

    public function __set($key, $value){
        $this->_PROPS[$key] = $value;
    }

    public function __get($key) {
        if (isset($this->_PROPS[$key])) {
            return $this->_PROPS[$key];
        }else{
            return null;
        }
    }

	public function id(){
		return $this->_ID;
	}

	public function insert_id(){
		$this->_ID = $this->db->insert_id();
		return $this->_ID;
	}
}
?>