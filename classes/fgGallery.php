<?php
/** Basic Setter/Getter Object with inheritance
 * @package FlightGear
 * @subpackage WWW
 * @copyright (C) 2010 Peter Morgan
 * @author Peter Morgan <ac001@daffodil.uk.com>
 * @version 0.1
 *
 *
*/
class fgGallery 
{
	const path = 'gallery/images/';
	
	private $_cache = null;

	public function index(){
		if($this->_cache){
			return $this->_cache;
		}
		$cache_file = SITE_ROOT.fgSite::CACHE_DIR.'gallery.txt';
		if(file_exists($cache_file)){
			$data = json_decode( file_get_contents($cache_file), true);
			return $data['gallery'];
		}
		$files = scandir(SITE_ROOT.self::path); //* why php dont have return dirs|no_dot
		$files = array_flip($files);
		unset($files['.']);
		unset($files['..']);
		unset($files['.svn']);
		$this->_cache = array_keys($files);
		file_put_contents($cache_file, json_encode(array('gallery' => $this->_cache)) );
		return $this->_cache;
	}

	public function random(){
		$files = $this->index();
		return $files[array_rand($files)];
	}	

	
}
?>