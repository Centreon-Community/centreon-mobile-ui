<?php

/*NDO*/

//>>----------------------<<//
//////////////////////////////
// requests used in host.php /
//////////////////////////////
//>>----------------------<<//

	$query_host_status_1 =		'SELECT 
								'.$ndoDB_assoc["db_prefix"].'hosts.host_id,
								'.$ndoDB_assoc["db_prefix"].'hosts.config_type,
								'.$ndoDB_assoc["db_prefix"].'hosts.display_name,
								'.$ndoDB_assoc["db_prefix"].'hoststatus.current_state,
								'.$ndoDB_assoc["db_prefix"].'hosts.alias,
								'.$ndoDB_assoc["db_prefix"].'hosts.address,
								'.$ndoDB_assoc["db_prefix"].'hoststatus.hoststatus_id,
								'.$ndoDB_assoc["db_prefix"].'hosts.icon_image
								FROM '.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'hoststatus '.$ndoDB_assoc["db_prefix"].'hoststatus
								INNER JOIN
								'.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'hosts '.$ndoDB_assoc["db_prefix"].'hosts
								ON ('.$ndoDB_assoc["db_prefix"].'hoststatus.host_object_id = '.$ndoDB_assoc["db_prefix"].'hosts.host_object_id)
								WHERE ('.$ndoDB_assoc["db_prefix"].'hosts.config_type = 0)
								AND (('.$ndoDB_assoc["db_prefix"].'hosts.display_name LIKE "%'.$search.'%")
								OR ('.$ndoDB_assoc["db_prefix"].'hosts.alias LIKE "%'.$search.'%")
								OR ('.$ndoDB_assoc["db_prefix"].'hosts.address LIKE "%'.$search.'%"))
								LIMIT '.($page * $nb).','.$nb.'';
														
	$count_selected_hosts_1 =	'SELECT COUNT(*)
								FROM '.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'hoststatus '.$ndoDB_assoc["db_prefix"].'hoststatus
								INNER JOIN
								'.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'hosts '.$ndoDB_assoc["db_prefix"].'hosts
								ON ('.$ndoDB_assoc["db_prefix"].'hoststatus.host_object_id = '.$ndoDB_assoc["db_prefix"].'hosts.host_object_id)
								WHERE ('.$ndoDB_assoc["db_prefix"].'hosts.config_type = 0)
								AND (('.$ndoDB_assoc["db_prefix"].'hosts.display_name LIKE "%'.$search.'%")
								OR ('.$ndoDB_assoc["db_prefix"].'hosts.alias LIKE "%'.$search.'%")
								OR ('.$ndoDB_assoc["db_prefix"].'hosts.address LIKE "%'.$search.'%"))';
								
?>