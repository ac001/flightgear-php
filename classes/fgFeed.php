<?php
/** Feed Handler
 * @package FlightGear
 * @subpackage www
 * @copyright (C) 2010 FlightGear Team
 * @author Peter Morgan <ac001@daffodil.uk.com>
 * @version 0.1
 *
 *
*/
class fgFeed
{
	const ini = 'feeds.ini';

	private $_feeds = array();
	private $_handlers = array();

	public function __construct(){
		$ini = fgHelper::loadIniFile(self::ini);
		foreach($ini as $feed => $v){
			$this->_feeds[$feed] = array('feed' => $feed, 'title' => $v['title'], 'description' => $v['description']);
			if(array_key_exists('title', $v)){
				$this->_handlers[$feed] = $v['handler'];
			}
		}
	}

	public function index(){
		return $this->_feeds;
	}

	public function feedIndex(){
		$arr = array();
		$arr['help'] = 'Welcome to the FlightGear feeds';
		$arr['feeds'] = array_values($this->_feeds);
		$arr['formats'] = self::formats();
		return $arr;
	}

	public function formats(){
		return array('json','xml','yaml','atom');
	}
	public function hasFeed($feed){
		return array_key_exists($feed, $this->_feeds);
	}

	public function validateRequest($feed){
		//* Check feed exists
		if(!array_key_exists($feed, $this->_feeds)){
			throw new fgException($feed.': feed not found', 'The requested feed is not recognised');
		}
		//* Check handler is defined
		if(!array_key_exists($feed, $this->_handlers)){
			throw new fgException($feed.': no handler class defined', 'The class name may be incorrect');
		}
		//* Check file exists
		if(!fgClass::fileExists($this->_handlers[$feed])){
			throw new fgException($this->_handlers[$feed].': class file not exist', "The class file '".$this->_handlers[$feed].".php' not exist");
		}

		//* Check method feed() exists
		if(!fgClass::methodExists($this->_handlers[$feed], 'feed')){
			throw new fgException($this->_handlers[$feed].': class function feed()  not exist', "There needs to be a feed() method in the class");
		}
	}

	public function getFeed($feed){
		$className = $this->_handlers[$feed];
		//echo $className;
		$Object = new $className();
		//print_r($Object);
		//print_r( $Object->feed());
		return $Object->feed();
	}


}
?>