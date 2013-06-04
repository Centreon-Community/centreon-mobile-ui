

<?php
/*requête utilisé pour supprimmer les downtimes de l'historique (different de la base ou sont listé les downtime repertorié dans centreon)*/
$query_delete_downtime	=	"DELETE FROM ".$ndoDB_assoc["db_name"].".".$ndoDB_assoc["db_prefix"]."downtimehistory WHERE internal_downtime_id =".$_GET['downdel'];

?>
