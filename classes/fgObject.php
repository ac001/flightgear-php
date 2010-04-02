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

    public function __construct($mixed = null){

		//** its its an array, then its a setter getter
		if(is_array($mixed)){
			foreach($mixed as $key => $value){
				if(is_array($value)){
					$this->_PROPS[$key] = new fgObject($value);
				}else{
					$this->_PROPS[$key] = $value;
				}
			}

		//* Otherwise its a db object--
		}else{
			global $db;
			$this->db = $db;
			$this->_ID = $mixed;
		}




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