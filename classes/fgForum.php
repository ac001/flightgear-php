<?php
/** Forum Handler
 * @package FlightGear
 * @subpackage WWW
 * @author Peter Morgan <ac001@daffodil.uk.com>
 * @version 0.1
 *
 *
*/
class fgForum
{
	public function index(){
		return array(
			array('key' => 'general', 'id'=> 2, 'title'=> 'General Help'),
			array('key'=> 'install', 'id'=> 11,'title'=> 'Install Help'),
			array('key'=> 'events', 'id'=> 10, 'title'=>'Events'),
			array('key'=> 'aircraft', 'id'=> 4, 'title'=>'Aircraft Development'),
			array('key'=> 'scenery', 'id'=> 5, 'title'=>'Scenery Enancment'),
			array('key'=> 'stories', 'id'=> 3, 'title'=>'Stories and Humour'),
			array('key'=> 'new_features', 'id'=> 6, 'title'=>'New Features')
		);
	}	
}
?>