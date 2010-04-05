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
	protected $_ID;
    protected  $_PROPS;
	protected $db;

    public function __construct($mixed = null){

		if(is_null($mixed)){
			return;
		}

		//** Its an array, then its a setter getter
		if(is_array($mixed)){
			foreach($mixed as $key => $value){
				if(is_array($value)){
					$this->_PROPS[$key] = new fgObject($value);
				}else{
					$this->_PROPS[$key] = $value;
				}
			}
			return;
		}

		//** Assumed a key so getter/getter 0 or > 0
		global $db;
		$this->db = $db;
		$this->_ID = $mixed;
    }

    public function __set($key, $value){
        $this->_PROPS[$key] = $value;
    }
    public function setData($array) {
		foreach($array as $k => $v){
			$this->$k = $v;
		}
    }
    public function __get($key) {
		#TODO: check if a constant maybe;
        if (isset($this->_PROPS[$key])) {
            return $this->_PROPS[$key];
        }else{
            return null;
        }
    }
    public function get($key) {
        if (isset($this->_PROPS[$key])) {
            return $this->_PROPS[$key];
        }else{
            return null;
        }
    }

    public function data(){
        return $this->_PROPS;
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