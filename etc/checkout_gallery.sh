#!/bin/bash

echo "-------- SVN Checkout --------"
echo "Fetching out flightgear-gallery from google"

mkdir ../gallery

svn co https://flightgear-gallery.googlecode.com/svn/trunk/v2.0/ ../gallery/

