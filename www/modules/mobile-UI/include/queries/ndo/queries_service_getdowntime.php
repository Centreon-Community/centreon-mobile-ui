<?php
/*requete utiliser pour récupérer les informations sur les downtimes d'un service*/
$query_downtime= 	'SELECT * FROM '.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'scheduleddowntime WHERE object_id = (SELECT '.$ndoDB_assoc["db_prefix"].'services.service_object_id FROM '.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'services WHERE service_id = "'.$obj_details_service->service_id.'")';

?>
