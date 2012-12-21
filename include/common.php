<?php

/////////////////////////////////
//général
/////////////////////////////////

$broker = "ndo";

//theme
$result_opt_theme = mysql_query('SELECT * FROM mui_opts mui_opts WHERE (mui_opts.opt_type = "opt_gen") AND (mui_opts.opt_label = "Theme")');
$row_opt_theme = mysql_fetch_array ($result_opt_theme);				
$theme = $row_opt_theme['opt_val'];

/*sélection du chemin contenant les fichiers de requetes en fonction du type de broker
et connexion à la BDD*/

if ($broker = "ndo")
	{$Broker_queries_path = "queries/ndo/";
	$ndoDB = mysql_query ('SELECT cfg_ndo2db.db_name, cfg_ndo2db.db_prefix FROM '.$conf_centreon['db'].'.cfg_ndo2db cfg_ndo2db');
	$ndoDB_assoc = mysql_fetch_assoc ($ndoDB);
	}
elseif ($broker = "broker")
	{$Broker_queries_path = "queries/centreon-broker/";}
else
	{	echo _("Your Broker is not currently supported");
		exit();
	}

	
?>				

