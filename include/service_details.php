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
include "queries/queries_common.php";

/*récupération des variables passées en url*/
$host_id = $_GET['host_id'];
$service_id = $_GET['service_id'];
$servicestatus_id = $_GET['status_id'];
$hostname = $_GET['hostname'];
$service = $_GET['service'];

/*sélection du fichier contenant les requetes*/
include $Broker_queries_path.'queries_service_details.php';

/*on execute les requetes nécessaires à la page*/	
$result_details_service = mysql_query ($query_details_service);
$result_metric_details = mysql_query ($query_metric_details);
$obj_details_service = mysql_fetch_object ($result_details_service);
$obj_metric_details = mysql_fetch_object ($result_metric_details);
$result_session_id = mysql_query ($query_session_id);
$obj_session_id = mysql_fetch_object ($result_session_id);

/*on inclus le header*/
include ("header.php");
?>

<!-----------------------------------------------------------------------------------------------------------------
HTML
------------------------------------------------------------------------------------------------------------------>

    <div data-role="page">
        <div data-role="header" data-theme="<?php echo $theme;?>">
			<a href="services.php?inerror=<?php echo $_GET['inerror'];?>" data-role="button" data-icon="back" class="ui-btn-left" data-transition="slidedown">Back</a>
			<a href="mobile-UI.php" data-role="button" data-icon="home" class="ui-btn-right" data-transition="fade">Home</a>
			<h1><?php echo _("Details")?></h1>
        </div>
		
		<div data-role="content">
			<font size="2">
			<table width="100%">
				<td width="1%"></td>
				<td style="text-align:center; width:98%"></td>
				<td width="1%">
					<a href="#popup_graphe_id" data-role="button" data-rel="popup" data-transition="flip" data-position-to="window"><img src="img/chart.gif"></a>
					<div data-role="popup" class="popup_graphe" id="popup_graphe_id">
					<a href="#" data-rel="back" data-role="button" data-icon="delete" data-iconpos="notext" class="ui-btn-right">Close</a>
					<img class="graphe_img" src="../../../include/views/graphs/generateGraphs/generateImage.php?session_id=<?php echo $obj_session_id->session_id; ?>&index=<?php echo $obj_metric_details->id; ?>&end=<?php echo time(); ?>&start=<?php echo time()-(60*60*24); ?>">
					</div>
				</td>
				</tr>
			</table>
			</font>	
			
			<h6>
				<font color="#30536D"><b><?php echo _("Name:")?></font></b>
					<?php echo ''.$obj_details_service->display_name.' '.$obj_details_service->alias.'' ; ?>
				<ul data-role="listview" data-inset="true">
					<li>
						<div><font size="1">
							<font color="#30536D"><?php echo _("Host is: ")?></font><?php echo ''.$obj_details_service->host_display_name.''; ?>
								<table class="tbl-detail">
									<tr>
										<td class="td-titre-tbl-detail"><?php echo _("Service status")?></td>
											<?php
												if ($obj_details_service->current_state == 0 ) 
													{echo '<td class="td-statut-OK">';echo _("Ok");echo '</td>';}
												elseif ($obj_details_service->current_state == 1 )
													{echo '<td class="td-statut-warning">';echo _("Warning");echo '</td>';}
												elseif ($obj_details_service->current_state == 2 )
													{echo '<td class="td-statut-critical">';echo _("Critical");echo '</td>';}
												elseif ($obj_details_service->current_state == 3 )
													{echo '<td class="td-statut-unknown">';echo _("Unknown");echo '</td>';}
												elseif ($obj_details_service->current_state == 4 )
													{echo '<td class="td-statut-pending">';echo _("Pending");echo '</td>';}
											?>
									<tr>
										<td class="td-tbl-detail"><?php echo _("Attempt:")?></td>
										<td class="td-tbl-detail">
										<?php echo ''.$obj_details_service->current_check_attempt.''; ?>/<?php echo ''.$obj_details_service->max_check_attempts.''; ?></td>
									</tr>
									<tr>
										<td class="td-tbl-detail"><?php echo _("Last check:")?></td>
										<td class="td-tbl-detail">
										<?php echo ''.$obj_details_service->last_check.''; ?></td>
									</tr>
									<tr>
										<td class="td-tbl-detail"><?php echo _("Next check")?></td>
										<td class="td-tbl-detail">
										<?php echo ''.$obj_details_service->next_check.''; ?></td>
									</tr>
									<tr>
										<td class="td-tbl-detail"><?php echo _("Latency:")?></td>
										<td class="td-tbl-detail">
										<?php echo ''.$obj_details_service->latency.''; ?></td>
									</tr>
									<tr>
										<td class="td-tbl-detail"><?php echo _("Execution time")?></td>
										<td class="td-tbl-detail">
										<?php echo ''.$obj_details_service->execution_time.''; ?></td>
									</tr>
									<tr>
										<td class="td-tbl-detail"><?php echo _("Last change")?></td>
										<td class="td-tbl-detail">
										<?php echo ''.$obj_details_service->last_state_change.''; ?></td>
									</tr>
									<tr>
										<td class="td-tbl-detail"><?php echo _("Notifications enabled?")?></td>
										<?php
											if ($obj_details_service->notifications_enabled == 0 ) 
												{echo '<td class="td-notif-ctrl-tbl-detail-non">';echo _("No");echo '</td>';}
											elseif ($obj_details_service->notifications_enabled == 1 )
												{echo '<td class="td-notif-ctrl-tbl-detail-oui">';echo _("Yes");echo '</td>';}
										?>
									</tr>
									<tr>
										<td style="border:1px solid #fffff2"><?php echo _("Active checks")?></td>
										<?php
											if ($obj_details_service->active_checks_enabled == 0 ) 
												{echo '<td class="td-notif-ctrl-tbl-detail-non">'; echo _("No");echo '</td>';}
											elseif ($obj_details_service->active_checks_enabled == 1 )
												{echo '<td class="td-notif-ctrl-tbl-detail-oui">'; echo _("Yes");echo '</td>';}
										?>
									</tr>
									<tr>
										<td style="border:1px solid #fffff2"><?php echo _("Passive checks")?></td>
										<?php
											if ($obj_details_service->passive_checks_enabled == 0 ) 
												{echo '<td class="td-notif-ctrl-tbl-detail-non">';echo _("No");echo '</td>';}
											elseif ($obj_details_service->passive_checks_enabled == 1 )
												{echo '<td class="td-notif-ctrl-tbl-detail-oui">';echo _("Yes");echo '</td>';}
										?>
									</tr>
								</table>
							</font>
						</div>
					</li>
				</ul>
			</h6>
			<div>
				<font><?php echo _("Detailed status")?></font>
				<br />
				<font>
				<?php echo ''.$obj_details_service->output.''; ?>
				<br />
				</font>
			</div>
		</div>
	</div>	
</body>
</html>
