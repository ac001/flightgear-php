<?php
/** Example Object
 * @package FlightGear
 * @subpackage WWW
 * @author Peter Morgan <ac001@daffodil.uk.com>
 * @version 0.1
 *
 *
*/

class fgFoo
{
	private $_cache = null;

	public function bar(){
		return strrev('hello flight gear and Brandano');
	}

	public function messages(){
		if(is_null($this->_cache)){
			//** do stuff to get data eg from db
			$this->_cache = array(
						array('label' => 'Free'),
						array('label' =>  'And'),
						array('label' => 'Open'),
						array('label' => 'Source')
			);
		}
		return $this->_cache;
	}
	public function random(){
		$messages = $this->messages();
		return $messages[array_rand($messages)];
	}
}

?>