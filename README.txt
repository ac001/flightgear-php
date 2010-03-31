
Working copy

http://flightgear.simpits.org

--------------------------------------------------------------------
How to run on localhost
--------------------------------------------------------------------
Here's some rough instructions to set up on a local machine

Required: Apache and php5 are installed.

example below is in the user "user_name"'s public_html 

Take a snapshot
cd ~user_name/public_html/
git checkout git@github.com:ac001/flightgear.simpits.git 

you need to make the smarty templates directory writable by www server
cd flightgear.simpits
chmod +w templates_c/

How goto
http://localhost/~user_name/flightgear-simpits/


--------------------------------------------------------------------
Code 
--------------------------------------------------------------------
Site user $smarty templating
http://smarty.net

configuration is in the config/config.inc.php file

the "main html page" is
templates/web_container.html

all urls take the form ?section=foo&page=bar 

templates are in the templates/www/* 
in the form
section.html + section.page.html



