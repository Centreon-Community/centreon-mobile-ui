<?php 
require_once "include_first.php";

//--------------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------

/*on inclus les fichiers communs*/
include_once "common.php";
include_once "queries/queries_common.php";
include_once "engine/external_cmd/extcmd.php";
include_once "engine/external_cmd/common-Func.php";

function ShowUsernameById ($user_id){
	$obj_username = mysql_fetch_object ((mysql_query('SELECT * FROM centreon.contact WHERE contact_id = '.$user_id.'')));
	echo $obj_username->contact_alias;
	}

	/*
	 * Ack a host
	 */
	function acknowledgeHost($param){
		global $pearDB,$tab, $key, $is_admin, $oreon;

		$actions = false;
		$actions = $oreon->user->access->checkAction("host_acknowledgement");

		if ($actions == true || $is_admin) {
			$key = $param["host_name"];
			isset($param['sticky']) && $param['sticky'] == "1" ? $sticky = "2" : $sticky = "1";
			$host_poller = GetMyHostPoller($pearDB, htmlentities($param["host_name"], ENT_QUOTES, "UTF-8"));
			$flg = write_command(" ACKNOWLEDGE_HOST_PROBLEM;".urldecode($param["host_name"]).";$sticky;".htmlentities($param["notify"], ENT_QUOTES, "UTF-8").";".htmlentities($param["persistent"], ENT_QUOTES, "UTF-8").";".htmlentities($param["author"], ENT_QUOTES, "UTF-8").";".htmlentities($param["comment"], ENT_QUOTES, "UTF-8"), urldecode($host_poller));

			if (isset($param['ackhostservice']) && $param['ackhostservice'] == 1) {
				$svc_tab = getMyHostServices(getMyHostID(htmlentities($param["host_name"], ENT_QUOTES, "UTF-8")));
				if (count($svc_tab)) {
					foreach ($svc_tab as $key2 => $value) {
	            				write_command(" ACKNOWLEDGE_SVC_PROBLEM;".htmlentities(urldecode($param["host_name"]), ENT_QUOTES, "UTF-8").";".$value.";".$sticky.";".htmlentities($param["notify"], ENT_QUOTES, "UTF-8").";".htmlentities($param["persistent"], ENT_QUOTES, "UTF-8").";".htmlentities($param["author"], ENT_QUOTES, "UTF-8").";".htmlentities($param["comment"], ENT_QUOTES, "UTF-8"), urldecode($host_poller));
	                		}
				}
			}
			set_user_param($oreon->user->user_id, $pearDB, "ack_sticky", $param["sticky"]);
			set_user_param($oreon->user->user_id, $pearDB, "ack_notify", $param["notify"]);
			set_user_param($oreon->user->user_id, $pearDB, "ack_services", $param["ackhostservice"]);
			set_user_param($oreon->user->user_id, $pearDB, "ack_persistent", $param["persistent"]);
			return _("Your command has been sent");
		}
		return NULL;
	}

	/*
	 * Remove ack for a host
	 */
	function acknowledgeHostDisable(){
		global $pearDB,$tab, $_GET, $is_admin, $oreon;
		$actions = false;
		$actions = $oreon->user->access->checkAction("host_acknowledgement");

		if ($actions == true || $is_admin) {
			$flg = send_cmd(" REMOVE_HOST_ACKNOWLEDGEMENT;".urldecode($_GET["host_name"]), GetMyHostPoller($pearDB, urldecode($_GET["host_name"])));
			return $flg;
		}

		return NULL;
	}

	/*
	 * Remove ack for a service
	 */
	function acknowledgeServiceDisable(){
		global $pearDB,$tab, $is_admin, $oreon;
		$actions = false;
		$actions = $oreon->user->access->checkAction("service_acknowledgement");

		if ($actions == true || $is_admin) {
			$flg = send_cmd(" REMOVE_SVC_ACKNOWLEDGEMENT;".urldecode($_GET["host_name"]).";".urldecode($_GET["service_description"]), GetMyHostPoller($pearDB, urldecode($_GET["host_name"])));
			return $flg;
		}
		return NULL;
	}

	/*
	 * Ack a service
	 */
	function acknowledgeService($param){
		global $pearDB, $tab, $is_admin, $oreon;

		$actions = false;
		$actions = $oreon->user->access->checkAction("service_acknowledgement");

		if ($actions == true || $is_admin) {
			$param["comment"] = $param["comment"];
			$param["comment"] = str_replace('\'', ' ', $param["comment"]);
			isset($param['sticky']) && $param['sticky'] == "1" ? $sticky = "2" : $sticky = "1";
			$flg = send_cmd(" ACKNOWLEDGE_SVC_PROBLEM;".urldecode($param["host_name"]).";".urldecode($param["service_description"]).";".$sticky.";".$param["notify"].";".$param["persistent"].";".$param["author"].";".$param["comment"], GetMyHostPoller($pearDB, urldecode($param["host_name"])));
			isset($param['force_check']) && $param['force_check'] ? $force_check = 1 : $force_check = 0;
		    if ($force_check == 1 && $oreon->user->access->checkAction("service_schedule_forced_check") == true) {
				send_cmd(" SCHEDULE_FORCED_SVC_CHECK;".urldecode($param["host_name"]).";".urldecode($param["service_description"]).";".time(), GetMyHostPoller($pearDB, urldecode($param["host_name"])));
			}
			set_user_param($oreon->user->user_id, $pearDB, "ack_sticky", $param["sticky"]);
		    set_user_param($oreon->user->user_id, $pearDB, "ack_notify", $param["notify"]);
		    set_user_param($oreon->user->user_id, $pearDB, "ack_persistent", $param["persistent"]);
		    set_user_param($oreon->user->user_id, $pearDB, "force_check", $force_check);
			return $flg;
		}
		return NULL;
	}

?>
