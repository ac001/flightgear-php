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
    private  $_DATA;
    public function __construct($array = null){
        if($array && is_array($array)){
            foreach($array as $k => $v){
                if(is_array($v)){
                    $this->_new_ob($k, $v);
                }else{
                    $this->__set($k, $v);
                }
            }
        }
    }

    public function __set($key, $value){
        $this->_DATA[$key] = $value;
    }

    public function __get($key) {
        if (isset($this->_DATA[$key])) {
            return $this->_DATA[$key];
        }else{
            return null;
        }
    }

    private function _new_ob($key, $values){
        $this->$key = new dOb($values);        
    }

    public function json(){
        return json_encode( $this->_DATA );
    }
	public function as_array(){
		return $this->_DATA;
	}
}
?>