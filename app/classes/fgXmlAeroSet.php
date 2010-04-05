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
		parent::__construct($file, $path);
	}

	public function help(){
		$path = '/PropertyList/sim/help/text';
		return wordwrap($this->getNode($path, 80));
	}

	public function keyboard(){
		$path = '/PropertyList/input/keyboard/key';
		$mapping = array('name' => 'key', 'desc' => 'description');
		return $this->getNodes($path, $mapping);
	}

	public function tanks(){
		$path =  '/PropertyList/consumables/fuel';
		$mapping = array('name' => 'name');
		return $this->getNodes($path, $mapping);
	}

	public function modelPath(){
		return FG_ROOT.$this->Doc->sim->model->path;
	}

}

?>