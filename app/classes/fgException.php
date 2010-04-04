<?php
/** Exception Handler
 * @package FlightGear
 * @subpackage Core
 * @copyright (C) 2010 FlightGear Team
 * @author Peter Morgan <ac001@daffodil.uk.com>
 * @version 0.1
 *
 *
*/
class fgException extends Exception
{
    private $_error;
    private $_description;

    /** All arguments after the Code are serialized into a string, and packed up in dev_error */
    public function __construct($message=null, $description = null) {
		$this->_error = $message;
		$this->_description = $description;
    }

    public function message(){
        return $this->getMessage()."\n".$this->dev_error;
    }

    public function error(){
		$arr = array();
		$arr['error'] = is_null($this->_error) ? 'Error occured' : $this->_error;
		if($this->_description){
			$arr['description'] = $this->_description;
		}
		$arr['file'] = basename($this->getFile());
		$arr['line'] = $this->getLine();
        return $arr;
    }
}
?>