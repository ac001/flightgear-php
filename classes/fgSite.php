<?php
/** Core Site Object
 * @package FlightGear
 * @subpackage Core
 * @copyright (C) 2010 FlightGear Team
 * @author Peter Morgan <ac001@daffodil.uk.com>
 * @version 0.1
 *
 *
*/

class fgSite
{
	//* Defines
	const CACHE_DIR = '__rw_cache__/cache/';
	const SMARTY_COMPILE_DIR = '__rw_cache__/smarty_compile_dir/';
	CONST GIT = 'http://github.com/ac001/flightgear-php/';

	//* Local "property" object - see __get()
    private  $_PROPS = array();

	//* Navigation
	private $nav_items;
	private $site_items;

	//* Public Props
	public $tm = '<span class="tm">FlightGear</span>';
	public $id;
	public $title;
	public $section;
	public $page;

	public $Request;

	//* Construct and load Sites array - Hard coded here atmo
	public function __construct($id, $title){
		$this->id = $id;
		$this->title = $title;

		

		$this->site_items = array();
		$this->nav_items = array();

		//** Intersite Navigation
		$this->addSiteNav('portal', 'index.php',  'Home' );
		$this->addSiteNav('online', 'online.php',  'Online' );
		$this->addSiteNav('www', 'www.php',  'Website');
		$this->addSiteNav('aircraft', 'aircraft.php',  'Aircraft');
		$this->addSiteNav('scenery', 'http://scenemodels.flightgear.org/',  'Scenery');
		$this->addSiteNav('wiki', 'http://wiki.flightgear.org',  'Wiki');
		$this->addSiteNav('forums', 'http://www.flightgear.org/forums/',  'Forums');
		$this->addSiteNav('dev', 'dev.php',  'Dev');
		$this->addSiteNav('webdev', 'webdev.php',  'WebDev');

		//** Set up  $section and $page
		$this->section = isset($_REQUEST['section']) && $_REQUEST['section'] != '' ? $_REQUEST['section'] : 'index';
		$this->page = isset($_REQUEST['page']) && $_REQUEST['page'] != '' ? $_REQUEST['page'] : null;
		
		$this->Request = new fgObject($_REQUEST);

		//** Set skin
		if(!isset($_SESSION[SITE_KEY]['skin'])){
			$_SESSION[SITE_KEY]['skin'] = 'skin.ac001.css';
		}
		$this->skin = $_SESSION[SITE_KEY]['skin'];
		
		//** Process incoming actions
		if(array_key_exists('do', $_REQUEST)){
			switch($_REQUEST['do']){
				case 'set_skin':
					$_SESSION[SITE_KEY]['skin'] =  $_REQUEST['skin'];
					$this->skin = $_SESSION[SITE_KEY]['skin'];
					
			}
		}

	}

	//***  Sites Navigation
	public function sitesNav(){
		return $this->site_items;
	}
	public function addSiteNav($site_id, $url, $label){
		$this->site_items[$site_id] = array('url' => $url, 'label' => $label, 'id' => $site_id);
	}
	public function siteUrl($id){
		return $this->site_items[$id]['url'];
	}

	public function processAction($vars){
		if(array_key_exists('do', $vars)){
			print_r($vars);
			switch($vars['do']){
				case 'set_skin':
					return $this->setSessionVar('skin', $vars['skin']);
					
			}
		}
	}

	//*** Autoload Proeprty Classes
    public function __get($key) {

		if(!isset($this->_PROPS[$key])){
			$class_file = SITE_ROOT.'classes/'.$key.'.php';
			if(file_exists($class_file)){
				require_once($class_file);
				$this->_PROPS[$key] = new $key;
			}
		}

        if (isset($this->_PROPS[$key])) {
            return $this->_PROPS[$key];
        }else{
            return null;
        }
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


	//*** Content Template
	public function contentTemplate(){
		if(is_null($this->page)){
			return $this->id.'/'.$this->section.'.html';
		}
		return $this->id.'/'.$this->section.'.'.$this->page.'.html';
	}

	//*** Page Title
	public function pageTitle(){
		if(is_null($this->page)){
			return $this->nav_items[$this->section]['title'];
		}else{
			return $this->nav_items[$this->section]['subnav'][$this->page]['title'];
		}
	}

	public function display(){
		global $smarty;
		$smarty->assign('Site', $this);
		$smarty->display('web_container.html');
	}

	public static function configPath(){
		return SITE_ROOT.'config/';
	}

}
?>