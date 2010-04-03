#!/bin/bash


cvs -d :pserver:cvsguest@cvs.flightgear.org:/var/cvs/FlightGear-0.9 login
CVS passwd: guest

cvs -d :pserver:cvsguest@cvs.flightgear.org:/var/cvs/FlightGear-0.9 co fg_data


cvs -d :pserver:cvsguest@cvs.flightgear.org:/var/cvs/FlightGear-0.9 login
CVS passwd: guest

cvs -d :pserver:cvsguest@cvs.flightgear.org:/var/cvs/FlightGear-0.9 co fg_source
