<?php
/** String Object - loosely OOp as js/python/java
 * @package FlightGear
 * @subpackage General
 * @copyright (C) 2010 FlightGear Team
 * @author Peter Morgan <ac001@daffodil.uk.com>
 * @version 0.1
 *
 *
*/
class fgStr
{
	public $str;
	public $length;

    public function __construct($string, $strip=false){
		if($strip){
			$string = trim($string);
		}
		$this->str = $string;
		$this->length = strlen($string);
	}

	
    public function startswith($start_string){
		$search_len = strlen($start_string);
		if($search_len > $this->length){
			return false; // TO long
		}
		echo substr($this->str, 0, $search_len);
	}

	public function contains($search_str){
		$pos = strpos($this->str, $search_str);
		return $pos === false ? null : $pos;
	}



}

?>