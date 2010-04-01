----------------------------------------------
---- FlightGear.php   ----
----------------------------------------------

This is some playing with running flightgear site on php

Working dev test copy is at
http://flightgear.simpits.org

--------------------------------------------------------------------
How to run on http://localhost
--------------------------------------------------------------------
Here's some rough instructions to set up on a local machine

Required: Apache and php5 are installed.

example below is in the user "user_name"'s public_html/ 
html so appears at
http://localhost/~user_name/flightgear-simpits/

; Take a snapshot
cd ~user_name/public_html/
git checkout git@github.com:ac001/flightgear.simpits.git 

; you need to make the smarty templates directory and cache writable by www server
cd flightgear.simpits
chmod +w __rw_cache__


; The gallery not included. So to get then run the checkout gallery script
; this will create a gallery/ directory and then checkout a version from google svn
cd etc/
./checkout_gallery.sh

;; View it - now navigate to
http://localhost/~user_name/flightgear-simpits/


--------------------------------------------------------------------
Hacking
--------------------------------------------------------------------

The site layout is designed around a two tier level
  $section/$page
All urls take the form 
  script.php?section=foo&page=bar 
todo is to use mod_rewite for 
  /section/*page*/

Site user $smarty templating
  http://smarty.net
The smarty tempaltes are in directory
  templates/* 

the "main html containter" displays all the images, layout and navigation, js, css etc
  templates/web_container.html

this is displayed by smarty
  $smarty->display('web_container.html);

Teh main container includes the section/page file eg
  {include file=$Site->mainPage()}; <<  "templates/web_site/section.page.html"

web site "section/pages"  html files are in the directory
  templates/web_site/* 

in the form
  section.html
  section.page.html

--------------------------------------------------------------------
config/config.inc.php
--------------------------------------------------------------------
The "enviroment" is configured for both shell and web (eg cron, xmlrpc, or browsing)
by including the config file. This not only "defines stuff", bu also can load db and smarty
Two variables $REQUIRE_SMARTY and $REQUIRE_DB needs to be declared before including.
	$REQUIRE_SMARTY = 1; // we need smarty for this web page
	// $REQUIRE_DB = 1; // don't need database
    require_once('config/config.inc.php');

Notable defines are
  SITE_ROOT
    The website root is a constant and path reference is to the "parent" directory.
    echo SITE_ROOT;
    >> outputs /home/user_name/public_html/flightgear-simpits/

--------------------------------------------------------------------
__autoload()
--------------------------------------------------------------------
The site makes extensive use of somewhat relies on the php function
 function  __auto_load($class_name)

which either loads known classes from libs/
  case: 'db_driver':
	require_once('libs/my_driver_class.php');

or loads from classes/
  default:
    require_once(SITE_ROOT."classes/$class_name.php");


--------------------------------------------------------------------
$Site and fgSite() object
--------------------------------------------------------------------
A $Site is a handler object created that loads and deals with a site.
It requires some key variables.
  $Site = new fgSite();
  $Site->site_id = 'my_site_id'; << unique "sites_nav_ki";
  $Site->site_title = 'My Fg Site';

The my_site.php?section=foo&page=bar need to be assigned to the object
Note: Current both GET and POST are recieved. Later we need to differentiate maybe.
  $Site->section = isset($_REQUEST['section']) ? $_REQUEST['section'] : 'index';
  $Site->page = isset($_REQUEST['page']) ? $_REQUEST['page'] : null;

//* Page Navigation
Add some page Navigation presented in a two tier structure
Naviagation is in the form 
  // ($key, $nav_label, $page_title, [$sub_pages_array = [$key, $nav_label, $page_title]]);
  $Site->addPageNav('my_section', 'Nav Label', 'Lost in space',
					array(
						array('x_page', 'My X', 'My X lady'),
						array('my_zzz', 'Zzzzz', 'Sleep time cpu')
				)
  );

//* Inter Site Navigation
Currently the $Site->siteNav() is hardcoded into the constructor,
this is presented at the top


----------------------------------------------------
--- Sample Site
----------------------------------------------------
Here is an example of creating a site called "Foo"

first at top level create the script
 <?php
  //** This is foo.php

//** load the configuration
$REQUIRE_SMARTY = 1;
require_once('config/config.inc.php');

$smarty->assign('Site', $Site);
$smarty->display('foo_container/html');

Classes are autoloaded on demand, within tempaltes

for example to create a plugin called fgFoo()

First add to navigation in main page eg web.php
$Site->addPageNav('foo', 'Nav label','Foo title');

Create the "section" file eg
web_site/foo.html

Create the left_box and content_box , and drop in our foo
<div id="right_box">
	<h3>Random Foo</h3>
	<p>{$Site->fgFoo->random();
</div>

<div id="content_box">
	<h1>{$Site->pageTitle()}</h1>
	{foreeach from=$Site->fgFoo->mesages() item=Mess}
		<li>{$Mess.label}</li>
	{/foreach}
</div>

create the classes/fgFoo.php files

class fgFoo
{
	private = $_cache = null;

	public function bar(){
		return 'hello';
	}
	public function messages(){
		if(is_null($this->_cache)){
			//** do stuff to get data eg from db
			$this->_cache = array(
						array('label' => 'Free'),
						array('label' =>  'And'),
						array('label' => 'Open'),
						array('label' => 'Source')
			);
		}
		return $this->_cache;
	}
	public function random(){
		$messages = $this->messages();
		return $messages[array_rand($messages];
	}
}



