<?php



//**************************************************************
//* Batches
//**************************************************************
$tables['servers'] = "
server_id I AUTO PRIMARY NOTNULL,
type C(20) INDEX,
nick C(50) INDEX,
host C(100) INDEX,
ip C(100) INDEX,
contact C(150) INDEX,
irc C(20) INDEX,
date_created T INDEX,
date_updated T INDEX
";


?>