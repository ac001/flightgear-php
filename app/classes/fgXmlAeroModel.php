<?php
/** A model Xml
 * @package FlightGear
 * @subpackage General
 * @copyright (C) 2010 FlightGear Team
 * @author Peter Morgan <ac001@daffodil.uk.com>
 * @version 0.2
 *
 *
*/
class fgXmlAeroModel extends fgXml
{
	
	public function __construct($file_path = null){
		parent::__construct($file_path);

		//print_r($this->Doc);
		
	}

	public function help(){
		return ''.$this->Doc->sim->help->text;
	}

	public function keyboard(){
		//$keys = $this->Doc->input->keyboard;
		$nodes = $this->Doc->sim->help;
		$arr = array();
		foreach($nodes->key as $k => $node){
			$arr[] = array('key' => ''.$node->name, 'description' => ''.$node->desc);
		}
		sort($arr); // wtf - this is wrong for now but it kinda work !!
		return $arr;
	}

	public function tanks(){
		$nodes = $this->Doc->consumables->fuel;
		$arr = array();
		foreach($nodes->tank as $k => $node){
			$arr[] = array('name' => ''.$node->name);
		}
		sort($arr); // wtf - this is wrong for now but it kinda work !!
		return $arr;
	}


}

?>