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
	private $nav_items;
	private $site_items;

	public $tm = '<span class="tm">FlightGear</span>';
	public $site_id;
	public $site_title;
	public $section;
	public $page;

	public function __construct($site_id, $site_title, $section, $page){
		$this->site_id = $site_id;
		$this->site_title = $site_title;
		$this->section = $section;
		$this->page = $page;

		$this->site_items = array();
		$this->nav_items = array();
	}

	public function addSiteNav($url, $label, $site_id){
		$this->site_items[] = array('url' => $url, 'label' => $label, 'site_id' =>$site_id);
	}
	public function sitesNav(){
		return $this->site_items;
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

	public function pageNav(){
		return $this->nav_items;
	}

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


}
?>