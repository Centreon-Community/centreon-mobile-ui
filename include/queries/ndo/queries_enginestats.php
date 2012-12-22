<?php

/*NDO*/

//>>-----------------------------<<//									
/////////////////////////////////////
// requests used in enginestats.php /
/////////////////////////////////////
//>>-----------------------------<<//		

$query_instances =	'SELECT
					instance.instance_id,
					instance.instance_name
					FROM
					'.$conf_centreon['dbcstg'].'.instance instance';
$result_instances = mysql_query ($query_instances);

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