<?php


$query_metric_details = 	'SELECT index_data.id AS index_data_id
							FROM '.$conf_centreon['dbcstg'].'.index_data
							WHERE (service_description = "'.$obj_details_service->service_display_name.'") AND (host_name = "'.$hostname.'")';

?>
