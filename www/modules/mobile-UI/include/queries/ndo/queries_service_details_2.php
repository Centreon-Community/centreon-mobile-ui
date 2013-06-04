<?php

/*NDO*/

							
$query_metric_exist =		'SELECT index_data.id
							FROM ('.$conf_centreon['dbcstg'].'.metrics metrics
							INNER JOIN
								'.$conf_centreon['dbcstg'].'.index_data index_data
							ON (metrics.index_id = index_data.id))
							INNER JOIN
								'.$conf_centreon['dbcstg'].'.data_bin data_bin
							ON (data_bin.id_metric = metrics.metric_id)
							WHERE (index_data.id = '.$obj_metric_details->index_data_id.')
							GROUP BY index_data.id';




?>
