#!/bin/bash


cvs -d :pserver:cvsguest@cvs.flightgear.org:/var/cvs/FlightGear-0.9 login
#CVS passwd: guest

cvs -d :pserver:cvsguest@cvs.flightgear.org:/var/cvs/FlightGear-0.9 co data 


cvs -d :pserver:cvsguest@cvs.flightgear.org:/var/cvs/FlightGear-0.9 login
#CVS passwd: guest

cvs -d :pserver:cvsguest@cvs.flightgear.org:/var/cvs/FlightGear-0.9 co source 
