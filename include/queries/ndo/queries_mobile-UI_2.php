<?php 

/*NDO*/

//>>---------------------------<<//
///////////////////////////////////
// requests used in mobile-UI.php /
///////////////////////////////////
//>>---------------------------<<//

$query_total_host_current_status =	'SELECT 
																	'.$ndoDB_assoc["db_prefix"].'hoststatus.current_state,
																	'.$ndoDB_assoc["db_prefix"].'hosts.config_type,
																	'.$ndoDB_assoc["db_prefix"].'hosts.alias
																	FROM '.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'hoststatus '.$ndoDB_assoc["db_prefix"].'hoststatus
																	INNER JOIN
																	'.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'hosts '.$ndoDB_assoc["db_prefix"].'hosts
																	ON ('.$ndoDB_assoc["db_prefix"].'hoststatus.host_object_id = '.$ndoDB_assoc["db_prefix"].'hosts.host_object_id)
																	WHERE ('.$ndoDB_assoc["db_prefix"].'hoststatus.current_state = '.$i.')
																	AND ('.$ndoDB_assoc["db_prefix"].'hosts.config_type = 0)';
																
$query_total_services_current_status =	'SELECT '.$ndoDB_assoc["db_prefix"].'servicestatus.current_state,
																			'.$ndoDB_assoc["db_prefix"].'services.config_type,
																			'.$ndoDB_assoc["db_prefix"].'hosts.config_type
																			FROM ('.$ndoDB_assoc["db_name"].'.nagios_services '.$ndoDB_assoc["db_prefix"].'services
																			INNER JOIN
																			'.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'hosts '.$ndoDB_assoc["db_prefix"].'hosts
																			ON ('.$ndoDB_assoc["db_prefix"].'services.host_object_id = '.$ndoDB_assoc["db_prefix"].'hosts.host_object_id))
																			INNER JOIN
																			'.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'servicestatus '.$ndoDB_assoc["db_prefix"].'servicestatus
																			ON ('.$ndoDB_assoc["db_prefix"].'servicestatus.service_object_id =
																			'.$ndoDB_assoc["db_prefix"].'services.service_object_id)
																			WHERE ('.$ndoDB_assoc["db_prefix"].'servicestatus.current_state = '.$i.')
																			AND ('.$ndoDB_assoc["db_prefix"].'services.config_type = 0)
																			AND ('.$ndoDB_assoc["db_prefix"].'hosts.config_type = 0)';
													
?>