<?php
require_once "common.php";

//>>-------------<<//
/////////////////////
// common requests  /
/////////////////////
//>--------------<<//

//options selection (used in hosts.php, mobile-UI.php)

$query_verify_opts 	= 	'SELECT *
						FROM '.$conf_centreon['db'].'.mui_opts mui_opts
						WHERE user_id = "'.$centreon->user->user_id.'"';
$query_delete_opts 	= 	'DELETE FROM '.$conf_centreon['db'].'.mui_opts WHERE user_id = "'.$centreon->user->user_id.'"';
$create_opts 		= 	'INSERT INTO 
						'.$conf_centreon['db'].'.mui_opts (opt_type, opt_label, opt_val, user_id) 
						VALUES 
						("opt_gen", "show_icons", "1", "'.$centreon->user->user_id.'"),
						("opt_gen", "size_icons", "36", "'.$centreon->user->user_id.'"),
						("module_IsActive", "Syslog", "1", "'.$centreon->user->user_id.'"), 
						("module_IsActive", "Weathermap", "1", "'.$centreon->user->user_id.'"), 
						("opt_weathermap", "SuffixeMaps", "_mobile", "'.$centreon->user->user_id.'"), 
						("opt_weathermap", "ShowSuffixedMaps", "1", "'.$centreon->user->user_id.'"), 
						("opt_gen", "Theme", "b", "'.$centreon->user->user_id.'")';
$opt_icon_size = mysql_query  ('SELECT * FROM '.$conf_centreon['db'].'.mui_opts mui_opts WHERE (mui_opts.opt_type = "opt_gen") AND (mui_opts.opt_label = "size_icons") AND (mui_opts.user_id = "'.$centreon->user->user_id.'")');
$opt_icon_show = mysql_query  ('SELECT * FROM '.$conf_centreon['db'].'.mui_opts mui_opts WHERE (mui_opts.opt_type = "opt_gen") AND (mui_opts.opt_label = "show_icons") AND (mui_opts.user_id = "'.$centreon->user->user_id.'")');

$query_session_id = '	SELECT session_id
						FROM '.$conf_centreon['db'].'.session
						WHERE user_id = "'.$centreon->user->user_id.'"';

?>