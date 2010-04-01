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

	private $_feeds = array();
	private $_handlers = array();

	public function __construct(){
		$this->addFeed('mpservers','MultiPlayer', 'Multi Player info');
		$this->addFeed('irc', 'IRC', 'IRC info and channels', 'fgIrc');
		$this->addFeed('mirrors', 'Mirrors', 'Ftp Mirrors', 'fgMirror');
		ksort($this->_feeds);
	}

	public function index(){
		return $this->_feeds;
	}

	public function addFeed($feed, $title, $description=null, $handler_class=null){
		$this->_feeds[$feed] = array('title' => $title, 'description' => $description);
		if($handler_class){
			$this->_handlers[$feed] = $handler_class;
		}
	}

	public function hasFeed($feed){
		return array_key_exists($feed, $this->_feeds);
	}

	public function checkHandler($feed){
		if(!array_key_exists($feed, $this->_handlers)){
			throw new fgException($feed.': no handler class defined', 'The class name may be incorrect');
		}
		$file_name = CLASS_PATH.$this->_handlers[$feed].'.php';
		if(!file_exists($file_name)){
			throw new fgException($this->_handlers[$feed].': class file not exist', "The class file '".$this->_handlers[$feed].".php' not exist");
		}
	}

}
?>