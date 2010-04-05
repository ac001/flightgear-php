<?php
/** User Object
 * @package FlightGear
 * @subpackage General
 * @copyright (C) 2010 FlightGear Team
 * @author Peter Morgan <ac001@daffodil.uk.com>
 * @version 0.2
 *
 *
*/
class fgXml 
{
	public $Doc = array();
	public $path = null;

	public function __construct($file, $path=null){	
		if($path){
			$this->path = $path;
		}
		$this->loadFile($this->path.$file);
	}

	public function loadFile($file_path){
		echo "\n############################file_path=$file_path\n";	
		$new_idx = count($this->Doc);
		$string= fgHelper::loadFile($file_path);
		$this->Doc[$new_idx] = simplexml_load_string($string);

		$include = $this->hasInclude($new_idx);
		if($include){
			$this->loadFile($this->path.$include);
		}	

	}
	public function hasInclude($idx){
		$path = "/PropertyList[@include]";
		$inc = $this->Doc[$idx]->xpath($path); // TODO - this aint working
		if(count($inc) == 0){
			return null;
		}
		$attributes = $this->Doc[$idx]->attributes();
		return $attributes['include'];
	}

	public function getNodes($xpath, $keys){
		$arr = array();
		//echo "path=".$path."\n";
		//print_R($keys);
		//echo "---------------------------------------------------------------\n";
		for($x=0; $x < count($this->Doc); $x++){
			$nodes = $this->Doc[$x]->xpath($xpath);
			//print_r($nodes);
			foreach($nodes as $k => $node){	
				$idx = count($arr);
				foreach($keys as $node_name => $return_name){
					$n = $node->xpath($node_name);
					//print_r($n);
					if(count($n) != 0){
						$arr[$idx][$return_name] = ''.$n[0];
					}
				}
			}
		}
		return $arr;
	}

	public function getNode($xpath){
		for($x=0; $x < count($this->Doc); $x++){
			$arr =  $this->Doc[$x]->xpath($xpath);
			if(count($arr) > 0){
				return trim($arr[0]);
			}
		}
		return null;
	}
}

?>