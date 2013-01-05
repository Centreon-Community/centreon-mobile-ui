<?

$command_file_path = $nagios_conf_params["command_file"];
$now = time();

$command = 'printf "[%lu] ACKNOWLEDGE_SVC_PROBLEM;'.$host_display_name.';'.$service_display_name.';'.$post_sticky.';'.$post_notify.';'.$post_persistent.';'.$_POST["auteur"].';'.$_POST["commentaire"].'\n" '.$now.' > '.$command_file_path.'';

$result = shell_exec ($command);
echo $command;
?>