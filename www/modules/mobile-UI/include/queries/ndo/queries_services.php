<?php

$query_service_status_6	=			'SELECT 
									AND('.$ndoDB_assoc["db_prefix"].'servicestatus.problem_has_been_acknowledged = 0)
									AND('.$ndoDB_assoc["db_prefix"].'servicestatus.scheduled_downtime_depth = 0)  