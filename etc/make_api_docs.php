#!/bin/sh

#phpdoc -t ./class_docs -f ../classes/class.appo.php -ti Mash Morgan -o HTML:Smarty:*
/home/docs/public_html/PhpDocumentor/phpdoc \
 -s on \
 -dn FlightGear-php \
 -t ./docs/ \
 -d ../classes \
 -ti "FlightGear-php" -o HTML:frames:earthli

