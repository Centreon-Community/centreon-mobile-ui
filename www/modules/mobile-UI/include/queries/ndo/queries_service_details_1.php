<?php

/*NDO*/

//>>---------------------------------<<//									
/////////////////////////////////////////
// requests used in service_details.php /
/////////////////////////////////////////
//>>---------------------------------<<//

	$query_details_service =	'SELECT 
								'.$ndoDB_assoc["db_prefix"].'hosts.alias AS host_alias,
								'.$ndoDB_assoc["db_prefix"].'hosts.display_name AS host_display_name,
								'.$ndoDB_assoc["db_prefix"].'services.service_id,
								'.$ndoDB_assoc["db_prefix"].'services.display_name AS service_display_name,
								'.$ndoDB_assoc["db_prefix"].'servicestatus.servicestatus_id,
								'.$ndoDB_assoc["db_prefix"].'servicestatus.instance_id,								
								'.$ndoDB_assoc["db_prefix"].'servicestatus.output,
								'.$ndoDB_assoc["db_prefix"].'servicestatus.perfdata,
								'.$ndoDB_assoc["db_prefix"].'servicestatus.current_state,
								'.$ndoDB_assoc["db_prefix"].'servicestatus.has_been_checked,
								'.$ndoDB_assoc["db_prefix"].'servicestatus.current_check_attempt,
								'.$ndoDB_assoc["db_prefix"].'servicestatus.max_check_attempts,
								'.$ndoDB_assoc["db_prefix"].'servicestatus.last_check,
								'.$ndoDB_assoc["db_prefix"].'servicestatus.next_check,
								'.$ndoDB_assoc["db_prefix"].'servicestatus.last_state_change,
								'.$ndoDB_assoc["db_prefix"].'servicestatus.check_type,
								'.$ndoDB_assoc["db_prefix"].'servicestatus.last_hard_state_change,
								'.$ndoDB_assoc["db_prefix"].'servicestatus.last_hard_state,
								'.$ndoDB_assoc["db_prefix"].'servicestatus.last_time_ok,
								'.$ndoDB_assoc["db_prefix"].'servicestatus.last_time_warning,
								'.$ndoDB_assoc["db_prefix"].'servicestatus.last_time_unknown,
								'.$ndoDB_assoc["db_prefix"].'servicestatus.last_time_critical,
								'.$ndoDB_assoc["db_prefix"].'servicestatus.state_type,
								'.$ndoDB_assoc["db_prefix"].'servicestatus.execution_time,
								'.$ndoDB_assoc["db_prefix"].'servicestatus.notifications_enabled,
								'.$ndoDB_assoc["db_prefix"].'servicestatus.problem_has_been_acknowledged,
								'.$ndoDB_assoc["db_prefix"].'servicestatus.acknowledgement_type,
								'.$ndoDB_assoc["db_prefix"].'servicestatus.active_checks_enabled,
								'.$ndoDB_assoc["db_prefix"].'servicestatus.passive_checks_enabled,
								'.$ndoDB_assoc["db_prefix"].'servicestatus.latency,
								'.$ndoDB_assoc["db_prefix"].'acknowledgements.acknowledgement_id,
								'.$ndoDB_assoc["db_prefix"].'hosts.config_type
							FROM    
								(('.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'services '.$ndoDB_assoc["db_prefix"].'services
							INNER JOIN
								'.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'hosts '.$ndoDB_assoc["db_prefix"].'hosts
							ON 
								('.$ndoDB_assoc["db_prefix"].'services.host_object_id =
								'.$ndoDB_assoc["db_prefix"].'hosts.host_object_id))
							INNER JOIN
								'.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'servicestatus '.$ndoDB_assoc["db_prefix"].'servicestatus
							ON 
								('.$ndoDB_assoc["db_prefix"].'servicestatus.service_object_id =
								'.$ndoDB_assoc["db_prefix"].'services.service_object_id))
							LEFT OUTER JOIN
								'.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'acknowledgements '.$ndoDB_assoc["db_prefix"].'acknowledgements
							ON 
								('.$ndoDB_assoc["db_prefix"].'services.host_object_id = '.$ndoDB_assoc["db_prefix"].'acknowledgements.object_id)
							WHERE    
								('.$ndoDB_assoc["db_prefix"].'services.service_id = '.$service_id.')
							AND 
								('.$ndoDB_assoc["db_prefix"].'servicestatus.servicestatus_id = '.$servicestatus_id.')
							AND 
								('.$ndoDB_assoc["db_prefix"].'hosts.config_type = 0)';

$query_metric_details = 	'SELECT index_data.id AS index_data_id
							FROM centstorage.index_data
							WHERE (index_data.host_name = "'.$hostname.'")
							AND (index_data.service_description = "'.$service.'")';

?>