

<?php
/*requete permettant de récupéré la liste des services d'un host*/
$query_svc_host =	'SELECT '.$ndoDB_assoc["db_prefix"].'services.service_object_id FROM '.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'services WHERE '.$ndoDB_assoc["db_prefix"].'services.host_object_id = (SELECT '.$ndoDB_assoc["db_prefix"].'hosts.host_object_id FROM '.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'hosts WHERE '.$ndoDB_assoc["db_prefix"].'hosts.host_id = '.$host_id.')';

?>
