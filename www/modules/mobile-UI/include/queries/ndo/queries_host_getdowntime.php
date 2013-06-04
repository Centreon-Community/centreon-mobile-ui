

<?php
/*requête renvoyant les information des downtimes sur un host*/
	$query_downtime_host='SELECT * FROM '.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'scheduleddowntime WHERE (object_id = (SELECT object_id FROM '.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'objects WHERE (name1 = "'.$obj_details_host->display_name.'") AND (objecttype_id = "1")))';
?>
  
