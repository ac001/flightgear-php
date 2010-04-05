<?php
/** An aircraft *-set.xml 
 * @package FlightGear
 * @subpackage General
 * @copyright (C) 2010 FlightGear Team
 * @author Peter Morgan <ac001@daffodil.uk.com>
 * @version 0.2
 *
 *
*/
class fgXmlAeroSet extends fgXml
{

	public function __construct($file, $path){	
		echo $file."========".$path."\n\n";
		parent::__construct($file, $path);
	}

	public function help(){
		$x = 0;
		
		$path = '/sim';
		$node = $this->Doc[$x]->sim;
		//print_r($node);
		echo "\n-------------------------------\n";
		$foo = $this->Doc[$x]->xpath('/PropertyList/sim/help');
		print_r($foo);
		echo "\n-----------================================--------------------\n";
		print_r($this->Doc[$x]);
		//return ''.$this->Doc->sim->help->text;
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
		//print_r($this->Doc);
		//print_r($nodes);
		$arr = array();
		foreach($nodes->tank as $k => $node){
			$arr[] = array('name' => ''.$node->name);
		}
		sort($arr); // wtf - this is wrong for now but it kinda work !!
		return $arr;
	}

	public function modelPath(){
		return FG_ROOT.$this->Doc->sim->model->path;

	}

}

?>