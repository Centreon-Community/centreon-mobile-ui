<?php
									
//>>------------------------------<<//									
//////////////////////////////////////
// requests used in host_details.php /
//////////////////////////////////////
//>>------------------------------<<//

$query_details_host =	'SELECT '.$ndoDB_assoc["db_prefix"].'hosts.alias,
						'.$ndoDB_assoc["db_prefix"].'hoststatus.current_state,
						'.$ndoDB_assoc["db_prefix"].'hosts.display_name,
						'.$ndoDB_assoc["db_prefix"].'hosts.address,
						'.$ndoDB_assoc["db_prefix"].'hoststatus.output,
						'.$ndoDB_assoc["db_prefix"].'hoststatus.has_been_checked,
						'.$ndoDB_assoc["db_prefix"].'hoststatus.current_check_attempt,
						'.$ndoDB_assoc["db_prefix"].'hoststatus.max_check_attempts,
						'.$ndoDB_assoc["db_prefix"].'hoststatus.status_update_time,
						'.$ndoDB_assoc["db_prefix"].'hoststatus.last_check,
						'.$ndoDB_assoc["db_prefix"].'hoststatus.next_check,
						'.$ndoDB_assoc["db_prefix"].'hoststatus.last_state_change,
						'.$ndoDB_assoc["db_prefix"].'hoststatus.last_time_up,
						'.$ndoDB_assoc["db_prefix"].'hoststatus.last_time_down,
						'.$ndoDB_assoc["db_prefix"].'hoststatus.last_time_unreachable,
						'.$ndoDB_assoc["db_prefix"].'hoststatus.state_type,
						'.$ndoDB_assoc["db_prefix"].'hoststatus.execution_time,
						'.$ndoDB_assoc["db_prefix"].'hoststatus.notifications_enabled,
						'.$ndoDB_assoc["db_prefix"].'hoststatus.problem_has_been_acknowledged,
						'.$ndoDB_assoc["db_prefix"].'hoststatus.acknowledgement_type,
						'.$ndoDB_assoc["db_prefix"].'hoststatus.passive_checks_enabled,
						'.$ndoDB_assoc["db_prefix"].'hoststatus.active_checks_enabled,
						'.$ndoDB_assoc["db_prefix"].'hoststatus.event_handler_enabled,
						'.$ndoDB_assoc["db_prefix"].'hoststatus.percent_state_change,
						'.$ndoDB_assoc["db_prefix"].'hoststatus.latency,
						'.$ndoDB_assoc["db_prefix"].'hoststatus.execution_time,
						'.$ndoDB_assoc["db_prefix"].'hosts.config_type,
						'.$ndoDB_assoc["db_prefix"].'hosts.host_id,
						'.$ndoDB_assoc["db_prefix"].'hoststatus.hoststatus_id
						FROM '.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'hoststatus '.$ndoDB_assoc["db_prefix"].'hoststatus
						INNER JOIN
						'.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'hosts '.$ndoDB_assoc["db_prefix"].'hosts
						ON ('.$ndoDB_assoc["db_prefix"].'hoststatus.host_object_id = '.$ndoDB_assoc["db_prefix"].'hosts.host_object_id)
						WHERE ('.$ndoDB_assoc["db_prefix"].'hosts.config_type = 0)
						AND ('.$ndoDB_assoc["db_prefix"].'hosts.host_id = '.$host_id.')
						AND ('.$ndoDB_assoc["db_prefix"].'hoststatus.hoststatus_id = '.$hoststatus_id.')';
						
						
//>>--------------------------<<//									
//////////////////////////////////
// requests used in services.php /
//////////////////////////////////
//>>--------------------------<<//

		$query_service_status_1 =	'SELECT 
									'.$ndoDB_assoc["db_prefix"].'hosts.host_id,
									'.$ndoDB_assoc["db_prefix"].'hosts.alias,
									'.$ndoDB_assoc["db_prefix"].'services.service_id,
									'.$ndoDB_assoc["db_prefix"].'services.display_name,
									'.$ndoDB_assoc["db_prefix"].'services.icon_image,
									'.$ndoDB_assoc["db_prefix"].'servicestatus.problem_has_been_acknowledged,
									'.$ndoDB_assoc["db_prefix"].'servicestatus.servicestatus_id
									FROM
									('.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'services '.$ndoDB_assoc["db_prefix"].'services
									INNER JOIN
									'.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'hosts '.$ndoDB_assoc["db_prefix"].'hosts
									ON ('.$ndoDB_assoc["db_prefix"].'services.host_object_id = '.$ndoDB_assoc["db_prefix"].'hosts.host_object_id))
									INNER JOIN
									'.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'servicestatus '.$ndoDB_assoc["db_prefix"].'servicestatus
									ON ('.$ndoDB_assoc["db_prefix"].'servicestatus.service_object_id =
									'.$ndoDB_assoc["db_prefix"].'services.service_object_id)
									WHERE (('.$ndoDB_assoc["db_prefix"].'hosts.config_type = 0)
									AND ('.$ndoDB_assoc["db_prefix"].'services.config_type = 0))
									AND (('.$ndoDB_assoc["db_prefix"].'services.display_name LIKE "%'.$search.'%")
									OR ('.$ndoDB_assoc["db_prefix"].'hosts.alias LIKE "%'.$search.'%"))
									LIMIT '.($page * $nb).','.$nb.'';
	$count_selected_service_1 =		'SELECT COUNT(*)
									FROM
									('.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'services '.$ndoDB_assoc["db_prefix"].'services
									INNER JOIN
									'.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'hosts '.$ndoDB_assoc["db_prefix"].'hosts
									ON ('.$ndoDB_assoc["db_prefix"].'services.host_object_id = '.$ndoDB_assoc["db_prefix"].'hosts.host_object_id))
									INNER JOIN
									'.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'servicestatus '.$ndoDB_assoc["db_prefix"].'servicestatus
									ON ('.$ndoDB_assoc["db_prefix"].'servicestatus.service_object_id =
									'.$ndoDB_assoc["db_prefix"].'services.service_object_id)
									WHERE (('.$ndoDB_assoc["db_prefix"].'hosts.config_type = 0)
									AND ('.$ndoDB_assoc["db_prefix"].'services.config_type = 0))
									AND (('.$ndoDB_assoc["db_prefix"].'services.display_name LIKE "%'.$search.'%")
									OR ('.$ndoDB_assoc["db_prefix"].'hosts.alias LIKE "%'.$search.'%"))';
								
	$query_service_status_2	=		'SELECT 
									'.$ndoDB_assoc["db_prefix"].'hosts.host_id,
									'.$ndoDB_assoc["db_prefix"].'hosts.alias,
									'.$ndoDB_assoc["db_prefix"].'hosts.config_type,
									'.$ndoDB_assoc["db_prefix"].'services.service_id,
									'.$ndoDB_assoc["db_prefix"].'services.config_type,
									'.$ndoDB_assoc["db_prefix"].'services.display_name,
									'.$ndoDB_assoc["db_prefix"].'services.icon_image,
									'.$ndoDB_assoc["db_prefix"].'servicestatus.problem_has_been_acknowledged,
									'.$ndoDB_assoc["db_prefix"].'servicestatus.servicestatus_id,
									'.$ndoDB_assoc["db_prefix"].'servicestatus.output,
									'.$ndoDB_assoc["db_prefix"].'servicestatus.current_state,
									'.$ndoDB_assoc["db_prefix"].'servicestatus.last_state_change
									FROM
									('.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'services '.$ndoDB_assoc["db_prefix"].'services
									INNER JOIN
									'.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'hosts '.$ndoDB_assoc["db_prefix"].'hosts
									ON ('.$ndoDB_assoc["db_prefix"].'services.host_object_id = '.$ndoDB_assoc["db_prefix"].'hosts.host_object_id))
									INNER JOIN
									'.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'servicestatus '.$ndoDB_assoc["db_prefix"].'servicestatus
									ON ('.$ndoDB_assoc["db_prefix"].'servicestatus.service_object_id =
									'.$ndoDB_assoc["db_prefix"].'services.service_object_id)
									WHERE (('.$ndoDB_assoc["db_prefix"].'hosts.config_type = 0)
									AND('.$ndoDB_assoc["db_prefix"].'services.config_type = 0))
									LIMIT '.($page * $nb).','.$nb.'';
	$count_selected_service_2 =		'SELECT COUNT(*)
									FROM
									('.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'services '.$ndoDB_assoc["db_prefix"].'services
									INNER JOIN
									'.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'hosts '.$ndoDB_assoc["db_prefix"].'hosts
									ON ('.$ndoDB_assoc["db_prefix"].'services.host_object_id = '.$ndoDB_assoc["db_prefix"].'hosts.host_object_id))
									INNER JOIN
									'.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'servicestatus '.$ndoDB_assoc["db_prefix"].'servicestatus
									ON ('.$ndoDB_assoc["db_prefix"].'servicestatus.service_object_id =
									'.$ndoDB_assoc["db_prefix"].'services.service_object_id)
									WHERE (('.$ndoDB_assoc["db_prefix"].'hosts.config_type = 0)
									AND('.$ndoDB_assoc["db_prefix"].'services.config_type = 0))';
	
	$query_service_status_3 =		'SELECT 
									'.$ndoDB_assoc["db_prefix"].'hosts.host_id,
									'.$ndoDB_assoc["db_prefix"].'hosts.alias,
									'.$ndoDB_assoc["db_prefix"].'hosts.config_type,
									'.$ndoDB_assoc["db_prefix"].'services.service_id,
									'.$ndoDB_assoc["db_prefix"].'services.config_type,
									'.$ndoDB_assoc["db_prefix"].'services.display_name,
									'.$ndoDB_assoc["db_prefix"].'services.icon_image,
									'.$ndoDB_assoc["db_prefix"].'servicestatus.problem_has_been_acknowledged,
									'.$ndoDB_assoc["db_prefix"].'servicestatus.servicestatus_id,
									'.$ndoDB_assoc["db_prefix"].'servicestatus.output,
									'.$ndoDB_assoc["db_prefix"].'servicestatus.current_state,
									'.$ndoDB_assoc["db_prefix"].'servicestatus.last_state_change
									FROM
									('.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'services '.$ndoDB_assoc["db_prefix"].'services
									INNER JOIN
									'.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'hosts '.$ndoDB_assoc["db_prefix"].'hosts
									ON ('.$ndoDB_assoc["db_prefix"].'services.host_object_id = '.$ndoDB_assoc["db_prefix"].'hosts.host_object_id))
									INNER JOIN
									'.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'servicestatus '.$ndoDB_assoc["db_prefix"].'servicestatus
									ON ('.$ndoDB_assoc["db_prefix"].'servicestatus.service_object_id =
									'.$ndoDB_assoc["db_prefix"].'services.service_object_id)
									WHERE (('.$ndoDB_assoc["db_prefix"].'servicestatus.current_state = 1)
									OR ('.$ndoDB_assoc["db_prefix"].'servicestatus.current_state = 2)
									OR ('.$ndoDB_assoc["db_prefix"].'servicestatus.current_state = 3)
									OR ('.$ndoDB_assoc["db_prefix"].'servicestatus.current_state = 4))
									AND('.$ndoDB_assoc["db_prefix"].'hosts.config_type = 0)
									AND('.$ndoDB_assoc["db_prefix"].'services.config_type = 0)
									LIMIT '.($page * $nb).','.$nb.'';
	$count_selected_service_3 =		'SELECT COUNT(*)
									FROM
									('.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'services '.$ndoDB_assoc["db_prefix"].'services
									INNER JOIN
									'.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'hosts '.$ndoDB_assoc["db_prefix"].'hosts
									ON ('.$ndoDB_assoc["db_prefix"].'services.host_object_id = '.$ndoDB_assoc["db_prefix"].'hosts.host_object_id))
									INNER JOIN
									'.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'servicestatus '.$ndoDB_assoc["db_prefix"].'servicestatus
									ON ('.$ndoDB_assoc["db_prefix"].'servicestatus.service_object_id =
									'.$ndoDB_assoc["db_prefix"].'services.service_object_id)
									WHERE (('.$ndoDB_assoc["db_prefix"].'servicestatus.current_state = 1)
									OR ('.$ndoDB_assoc["db_prefix"].'servicestatus.current_state = 2)
									OR ('.$ndoDB_assoc["db_prefix"].'servicestatus.current_state = 3)
									OR ('.$ndoDB_assoc["db_prefix"].'servicestatus.current_state = 4))
									AND('.$ndoDB_assoc["db_prefix"].'hosts.config_type = 0)
									AND('.$ndoDB_assoc["db_prefix"].'services.config_type = 0)';
			
	$query_service_status_4 =		'SELECT 
									'.$ndoDB_assoc["db_prefix"].'hosts.host_id,
									'.$ndoDB_assoc["db_prefix"].'hosts.alias,
									'.$ndoDB_assoc["db_prefix"].'hosts.config_type,
									'.$ndoDB_assoc["db_prefix"].'services.service_id,
									'.$ndoDB_assoc["db_prefix"].'services.config_type,
									'.$ndoDB_assoc["db_prefix"].'services.display_name,
									'.$ndoDB_assoc["db_prefix"].'services.icon_image,
									'.$ndoDB_assoc["db_prefix"].'servicestatus.problem_has_been_acknowledged,
									'.$ndoDB_assoc["db_prefix"].'servicestatus.servicestatus_id,
									'.$ndoDB_assoc["db_prefix"].'servicestatus.output,
									'.$ndoDB_assoc["db_prefix"].'servicestatus.current_state,
									'.$ndoDB_assoc["db_prefix"].'servicestatus.last_state_change
									FROM
									('.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'services '.$ndoDB_assoc["db_prefix"].'services
									INNER JOIN
									'.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'hosts '.$ndoDB_assoc["db_prefix"].'hosts
									ON ('.$ndoDB_assoc["db_prefix"].'services.host_object_id = '.$ndoDB_assoc["db_prefix"].'hosts.host_object_id))
									INNER JOIN
									'.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'servicestatus '.$ndoDB_assoc["db_prefix"].'servicestatus
									ON ('.$ndoDB_assoc["db_prefix"].'servicestatus.service_object_id =
									'.$ndoDB_assoc["db_prefix"].'services.service_object_id)
									WHERE (('.$ndoDB_assoc["db_prefix"].'hosts.config_type = 0)
									AND('.$ndoDB_assoc["db_prefix"].'services.config_type = 0))
									LIMIT '.($page * $nb).','.$nb.'';
	$count_selected_service_4 =		'SELECT COUNT(*)
									FROM
									('.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'services '.$ndoDB_assoc["db_prefix"].'services
									INNER JOIN
									'.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'hosts '.$ndoDB_assoc["db_prefix"].'hosts
									ON ('.$ndoDB_assoc["db_prefix"].'services.host_object_id = '.$ndoDB_assoc["db_prefix"].'hosts.host_object_id))
									INNER JOIN
									'.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'servicestatus '.$ndoDB_assoc["db_prefix"].'servicestatus
									ON ('.$ndoDB_assoc["db_prefix"].'servicestatus.service_object_id =
									'.$ndoDB_assoc["db_prefix"].'services.service_object_id)
									WHERE (('.$ndoDB_assoc["db_prefix"].'hosts.config_type = 0)
									AND('.$ndoDB_assoc["db_prefix"].'services.config_type = 0))';
																
	$query_service_status_5 =		'SELECT 
									'.$ndoDB_assoc["db_prefix"].'hosts.host_id,
									'.$ndoDB_assoc["db_prefix"].'hosts.alias,
									'.$ndoDB_assoc["db_prefix"].'hosts.config_type,
									'.$ndoDB_assoc["db_prefix"].'services.service_id,
									'.$ndoDB_assoc["db_prefix"].'services.config_type,
									'.$ndoDB_assoc["db_prefix"].'services.display_name,
									'.$ndoDB_assoc["db_prefix"].'services.icon_image,
									'.$ndoDB_assoc["db_prefix"].'servicestatus.problem_has_been_acknowledged,
									'.$ndoDB_assoc["db_prefix"].'servicestatus.servicestatus_id,
									'.$ndoDB_assoc["db_prefix"].'servicestatus.output,
									'.$ndoDB_assoc["db_prefix"].'servicestatus.current_state,
									'.$ndoDB_assoc["db_prefix"].'servicestatus.last_state_change
									FROM
									('.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'services '.$ndoDB_assoc["db_prefix"].'services
									INNER JOIN
									'.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'hosts '.$ndoDB_assoc["db_prefix"].'hosts
									ON ('.$ndoDB_assoc["db_prefix"].'services.host_object_id = '.$ndoDB_assoc["db_prefix"].'hosts.host_object_id))
									INNER JOIN
									'.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'servicestatus '.$ndoDB_assoc["db_prefix"].'servicestatus
									ON ('.$ndoDB_assoc["db_prefix"].'servicestatus.service_object_id =
									'.$ndoDB_assoc["db_prefix"].'services.service_object_id)
									WHERE (('.$ndoDB_assoc["db_prefix"].'hosts.config_type = 0)
									AND('.$ndoDB_assoc["db_prefix"].'services.config_type = 0))
									LIMIT '.($page * $nb).','.$nb.'';
	$count_selected_service_5 =		'SELECT COUNT(*)
									FROM
									('.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'services '.$ndoDB_assoc["db_prefix"].'services
									INNER JOIN
									'.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'hosts '.$ndoDB_assoc["db_prefix"].'hosts
									ON ('.$ndoDB_assoc["db_prefix"].'services.host_object_id = '.$ndoDB_assoc["db_prefix"].'hosts.host_object_id))
									INNER JOIN
									'.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'servicestatus '.$ndoDB_assoc["db_prefix"].'servicestatus
									ON ('.$ndoDB_assoc["db_prefix"].'servicestatus.service_object_id =
									'.$ndoDB_assoc["db_prefix"].'services.service_object_id)
									WHERE (('.$ndoDB_assoc["db_prefix"].'hosts.config_type = 0)
									AND('.$ndoDB_assoc["db_prefix"].'services.config_type = 0))';								
		


		
//>>-----------------------------<<//									
/////////////////////////////////////
// requests used in enginestats.php /
/////////////////////////////////////
//>>-----------------------------<<//		

	$query_instances =		'SELECT
							instance.instance_id,
							instance.instance_name
							FROM
							'.$conf_centreon['dbcstg'].'.instance instance';
	$query_enginestats =	'SELECT 
							nagios_stats.stat_value
							FROM
							'.$conf_centreon['dbcstg'].'.nagios_stats nagios_stats
							INNER JOIN
							'.$conf_centreon['dbcstg'].'.instance instance
							ON
							(nagios_stats.instance_id = instance.instance_id)
							WHERE
							(instance.instance_id = '.$instance_id.')';

?>