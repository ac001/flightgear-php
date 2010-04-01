<?php
/** General Site Helper
 * @package FlightGear
 * @subpackage WWW
 * @copyright (C) 2010 Peter Morgan
 * @author Peter Morgan <ac001@daffodil.uk.com>
 * @version 0.1
 *
 *
*/

class fgSite
{
	const CACHE_DIR = '__rw_cache__/cache/';
	const SMARTY_COMPILE_DIR = '__rw_cache__/smarty_compile_dir/';

    private  $_DATA = array();

	private $nav_items;
	private $site_items;

	public $tm = '<span class="tm">FlightGear</span>';
	public $site_id;
	public $site_title;
	public $section;
	public $page;

	public function __construct(){
		$this->site_items = array();
		$this->nav_items = array();
	}

	//*** Autload Classes
    public function __get($key) {
		if($key == 'gallery'){
			$this->_DATA[$key] = new fgGallery();
		}
        if (isset($this->_DATA[$key])) {
            return $this->_DATA[$key];
        }else{
            return null;
        }
    }


	//*** Sites Navigation
	public function sitesNav(){
		return $this->site_items;
	}
	public function addSiteNav($url, $label, $site_id){
		$this->site_items[] = array('url' => $url, 'label' => $label, 'site_id' =>$site_id);
	}


	//*** Page Navigation
	public function pageNav(){
		return $this->nav_items;
	}
	public function addPageNav($section, $label, $page_title=null, $subs=null){
		$this->nav_items[$section] = array(	'section' => $section, 
											'label' => $label, 
											'title' => is_null($page_title) ? $label : $page_title
										);
		if($subs){
			$this->nav_items[$section]['subnav'] = array();
			foreach($subs as $ki => $sub){
				$this->nav_items[$section]['subnav'][$sub[0]]  = array(	'section' => $section,
																		'page' => $sub[0],
																		'label' => $sub[1], 
																		'title' => isset($sub[2]) ? $sub[2] : $sub[1]
																);
			}
		}
	}


	//*** Page Handlers
	public function mainPage(){
		if(is_null($this->page)){
			return 'web_site/'.$this->section.'.html';
		}
		return 'web_site/'.$this->section.'.'.$this->page.'.html';
	}
	public function pageTitle(){
		if(is_null($this->page)){
			return $this->nav_items[$this->section]['title'];
		}else{
			return $this->nav_items[$this->section]['subnav'][$this->page]['title'];
		}
	}


	//*** Gallery
	//public function gallery(){
	//	return fgGallery::gallery();
	//}
	//public function gallery_random(){
	//	//$gallery = new fgGallery();
	//	return fgGallery::gallery_random();
	//}
}
?>