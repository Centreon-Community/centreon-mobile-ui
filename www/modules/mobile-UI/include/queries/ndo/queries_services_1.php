<?php

/*NDO*/

//>>--------------------------<<//									
//////////////////////////////////
// requests used in services.php /
//////////////////////////////////
//>>--------------------------<<//

$query_service_status_1	=	'SELECT 
								'.$ndoDB_assoc["db_prefix"].'hosts.host_id,
								'.$ndoDB_assoc["db_prefix"].'hosts.alias,
								'.$ndoDB_assoc["db_prefix"].'hosts.display_name AS hostname,
								'.$ndoDB_assoc["db_prefix"].'services.service_id,
								'.$ndoDB_assoc["db_prefix"].'services.config_type,
								'.$ndoDB_assoc["db_prefix"].'services.display_name,
								'.$ndoDB_assoc["db_prefix"].'services.icon_image,
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
								
?>