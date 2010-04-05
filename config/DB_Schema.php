<?php

//**************************************************************
//* Aircraft
//**************************************************************
$tables['aero'] = "
aero_id I AUTO PRIMARY NOTNULL,
aero C(30) NOTNULL INDEX,
directory C(20) INDEX,
xml_set C(30) NOTNULL INDEX,
name C(100) INDEX,
nick C(100) INDEX,
description C(100) INDEX,
splash C(100) INDEX,
fdm C(20) INDEX,
status C(150) INDEX,
date_created T INDEX,
date_updated T INDEX
";

//**************************************************************
//* Servers
//**************************************************************

$tables['server_types'] = "
server_type_id I AUTO PRIMARY NOTNULL,
server_type_key C(20) INDEX,
server_type C(50) INDEX
";


//**************************************************************
//* Servers
//**************************************************************

$tables['servers'] = "
server_id I AUTO PRIMARY NOTNULL,
server_type_id I INDEX,
nick C(50) INDEX,
host C(100) INDEX,
ip C(100) INDEX,
contact C(150) INDEX,
irc C(20) INDEX,
location C(50) INDEX,
date_created T INDEX,
date_updated T INDEX,
tracked L,
active L,
rank I
";


//**************************************************************
//* Users
//**************************************************************
$tables['users'] = "
user_id I AUTO PRIMARY NOTNULL,
name C(100) INDEX,
email C(100) INDEX,
passwd C(60),
irc C(50) INDEX,
callsign C(50) INDEX,
cvs C(50) INDEX,
location C(50),
www C(50),
hangar C(50),
date_created T INDEX,
date_updated T INDEX,
active L INDEX,
karma I INDEX,
security C(50) INDEX,
token C(100)
";



$tables['user_links'] = "
user_id I NOTNULL INDEX,
aero_id I NOTNULL INDEX,
server_id I NOTNULL INDEX
";
?>