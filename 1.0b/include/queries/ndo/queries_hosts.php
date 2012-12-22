<?php

/*NDO*/

//>>----------------------<<//
//////////////////////////////
// requests used in host.php /
//////////////////////////////
//>>----------------------<<//						
							
	$query_host_status_2 =		'SELECT 
								'.$ndoDB_assoc["db_prefix"].'hosts.host_id,
								'.$ndoDB_assoc["db_prefix"].'hosts.config_type,
								'.$ndoDB_assoc["db_prefix"].'hosts.alias,
								'.$ndoDB_assoc["db_prefix"].'hoststatus.hoststatus_id,
								'.$ndoDB_assoc["db_prefix"].'hoststatus.current_state,
								'.$ndoDB_assoc["db_prefix"].'hoststatus.last_state_change,
								'.$ndoDB_assoc["db_prefix"].'hoststatus.last_hard_state_change,
								'.$ndoDB_assoc["db_prefix"].'hoststatus.last_time_up,
								'.$ndoDB_assoc["db_prefix"].'hoststatus.last_time_down,
								'.$ndoDB_assoc["db_prefix"].'hosts.icon_image
								FROM '.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'hoststatus '.$ndoDB_assoc["db_prefix"].'hoststatus
								INNER JOIN
								'.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'hosts '.$ndoDB_assoc["db_prefix"].'hosts
								ON ('.$ndoDB_assoc["db_prefix"].'hoststatus.host_object_id = '.$ndoDB_assoc["db_prefix"].'hosts.host_object_id)
								WHERE ('.$ndoDB_assoc["db_prefix"].'hosts.config_type = 0)
								LIMIT '.($page * $nb).','.$nb.'';
	$count_selected_hosts_2 =	'SELECT COUNT(*)
								FROM '.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'hoststatus '.$ndoDB_assoc["db_prefix"].'hoststatus
								INNER JOIN
								'.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'hosts '.$ndoDB_assoc["db_prefix"].'hosts
								ON ('.$ndoDB_assoc["db_prefix"].'hoststatus.host_object_id = '.$ndoDB_assoc["db_prefix"].'hosts.host_object_id)
								WHERE ('.$ndoDB_assoc["db_prefix"].'hosts.config_type = 0)';

	$query_host_status_3 =		'SELECT 
								'.$ndoDB_assoc["db_prefix"].'hosts.host_id,
								'.$ndoDB_assoc["db_prefix"].'hosts.config_type,
								'.$ndoDB_assoc["db_prefix"].'hosts.alias,
								'.$ndoDB_assoc["db_prefix"].'hoststatus.hoststatus_id,
								'.$ndoDB_assoc["db_prefix"].'hoststatus.current_state,
								'.$ndoDB_assoc["db_prefix"].'hoststatus.last_state_change,
								'.$ndoDB_assoc["db_prefix"].'hoststatus.last_hard_state_change,
								'.$ndoDB_assoc["db_prefix"].'hoststatus.last_time_up,
								'.$ndoDB_assoc["db_prefix"].'hoststatus.last_time_down,
								'.$ndoDB_assoc["db_prefix"].'hosts.icon_image
								FROM '.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'hoststatus '.$ndoDB_assoc["db_prefix"].'hoststatus
								INNER JOIN
								'.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'hosts '.$ndoDB_assoc["db_prefix"].'hosts
								ON ('.$ndoDB_assoc["db_prefix"].'hoststatus.host_object_id = '.$ndoDB_assoc["db_prefix"].'hosts.host_object_id)
								WHERE (('.$ndoDB_assoc["db_prefix"].'hoststatus.current_state = 1)
								OR ('.$ndoDB_assoc["db_prefix"].'hoststatus.current_state = 2)
								OR ('.$ndoDB_assoc["db_prefix"].'hoststatus.current_state = 3))
								AND ('.$ndoDB_assoc["db_prefix"].'hosts.config_type = 0)
								LIMIT '.($page * $nb).','.$nb.'';
	$count_selected_hosts_3 =	'SELECT COUNT(*)
								FROM '.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'hoststatus '.$ndoDB_assoc["db_prefix"].'hoststatus
								INNER JOIN
								'.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'hosts '.$ndoDB_assoc["db_prefix"].'hosts
								ON ('.$ndoDB_assoc["db_prefix"].'hoststatus.host_object_id = '.$ndoDB_assoc["db_prefix"].'hosts.host_object_id)
								WHERE (('.$ndoDB_assoc["db_prefix"].'hoststatus.current_state = 1)
								OR ('.$ndoDB_assoc["db_prefix"].'hoststatus.current_state = 2)
								OR ('.$ndoDB_assoc["db_prefix"].'hoststatus.current_state = 3))
								AND ('.$ndoDB_assoc["db_prefix"].'hosts.config_type = 0)';							

	$query_host_status_4 =			'SELECT 
									'.$ndoDB_assoc["db_prefix"].'hosts.host_id,
									'.$ndoDB_assoc["db_prefix"].'hosts.config_type,
									'.$ndoDB_assoc["db_prefix"].'hosts.alias,
									'.$ndoDB_assoc["db_prefix"].'hoststatus.hoststatus_id,
									'.$ndoDB_assoc["db_prefix"].'hoststatus.current_state,
									'.$ndoDB_assoc["db_prefix"].'hoststatus.last_state_change,
									'.$ndoDB_assoc["db_prefix"].'hoststatus.last_hard_state_change,
									'.$ndoDB_assoc["db_prefix"].'hoststatus.last_time_up,
									'.$ndoDB_assoc["db_prefix"].'hoststatus.last_time_down,
									'.$ndoDB_assoc["db_prefix"].'hosts.icon_image
									FROM '.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'hoststatus '.$ndoDB_assoc["db_prefix"].'hoststatus
									INNER JOIN
									'.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'hosts '.$ndoDB_assoc["db_prefix"].'hosts
									ON ('.$ndoDB_assoc["db_prefix"].'hoststatus.host_object_id = '.$ndoDB_assoc["db_prefix"].'hosts.host_object_id)
									WHERE ('.$ndoDB_assoc["db_prefix"].'hosts.config_type = 0)
									LIMIT '.($page * $nb).','.$nb.'';
	$count_selected_hosts_4 =		'SELECT COUNT(*)
									FROM '.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'hoststatus '.$ndoDB_assoc["db_prefix"].'hoststatus
									INNER JOIN
									'.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'hosts '.$ndoDB_assoc["db_prefix"].'hosts
									ON ('.$ndoDB_assoc["db_prefix"].'hoststatus.host_object_id = '.$ndoDB_assoc["db_prefix"].'hosts.host_object_id)
									WHERE ('.$ndoDB_assoc["db_prefix"].'hosts.config_type = 0)';								
							
?>