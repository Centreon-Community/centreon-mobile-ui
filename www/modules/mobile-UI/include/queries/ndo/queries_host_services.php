<?php


$query_host_services	=	'SELECT 
									AND('.$ndoDB_assoc["db_prefix"].'services.host_object_id = (SELECT object_id FROM '.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'objects WHERE name1 = (SELECT '.$ndoDB_assoc["db_prefix"].'hosts.display_name FROM '.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'hosts WHERE host_id = "'.$host_id.'") AND (objecttype_id = "1")))';

?>