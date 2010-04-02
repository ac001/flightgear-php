<?php



//**************************************************************
//* Servers
//**************************************************************

$tables['servers'] = "
server_id I AUTO PRIMARY NOTNULL,
type C(20) INDEX,
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
name C(20) INDEX,
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

?>