# -*- coding: utf-8 -*-

import os
import sys


## Root path of the google application project
ROOT_PATH = "/home/flight-sim/FlightGear-AppEngine-Cloud/"

## DLight Gear Root
FG_ROOT = '../CVS/data'
FG_DATA_AIRCRAFT_PATH = '%s/Aircraft/' % FG_ROOT

## path to the fgmap repos
FG_MAP_ROOT = '/home/flight-sim/public_html/fgmap'


## place to spool bits and dics as cvs import
CVS_LOGS = '/home/flight-sim/fg-aircraft/temp/logs/'
CVS_DIC = '/home/flight-sim/fg-aircraft/temp/dic/'

#CVS_DATA = '/home/flight-sim/fg-aircraft/temp/dic/'

#YAML_PATH = '/home/flight-sim/fg-aircraft/fg-aircraft.appspot.com/aicraft_yaml'


if sys.argv.count('--live') > 0:
	WWW = 'http://flightgear.daffodil.uk.com/'
	#FG_ROOT = '/home/flight-sim/flight-gear-9/data'
else:
	WWW = 'http://localhost/~flight-sim/flightgear-php/'
	#FG_ROOT = '/home/flight-sim/flight-gear-9/data'