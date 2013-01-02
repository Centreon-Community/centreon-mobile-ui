<?php

/*NDO*/

//>>---------------------------------<<//									
/////////////////////////////////////////
// requests used in service_details.php /
/////////////////////////////////////////
//>>---------------------------------<<//


					
$acknowledgement_1 = 		'UPDATE '.$ndoDB_assoc["db_prefix"].'.servicestatus
							SET '.$ndoDB_assoc["db_prefix"].'servicestatus.problem_has_been_acknowledged = "1"
							WHERE '.$ndoDB_assoc["db_prefix"].'servicestatus.servicestatus_id =	'.$servicestatus_id.'';
							
$acknowledgement_2 =		'INSERT INTO '.$ndoDB_assoc["db_prefix"].'.acknowledgements (
							acknowledgement_id,
							instance_id,
							entry_time,
							entry_time_usec,
							acknowledgement_type,
							object_id,
							state,
							author_name,
							comment_data, 
							is_sticky,
							persistent_comment,
							notify_contacts
							)
							VALUES (
							NULL,
							"'.$obj_details_service->instance_id.'",
							"'.$post_date.'",
							"'.$post_utime.'",
							"1",
							"'.$servicestatus_id.'",
							"1",
							"'.$_POST['auteur'].'",
							"'.$_POST['commentaire'].'",
							"'.$post_sticky.'",
							"'.$post_persistent.'",
							"'.$post_notify.'")
							';

?>