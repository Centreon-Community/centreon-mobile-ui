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

$host_id = $_GET['host'];
$hoststatus_id = $_GET['statusid'];

/*sélection du fichier contenant les requetes*/
include $Broker_queries_path.'queries_host_details.php';

$result_details_host = mysql_query ($query_details_host);
$obj_details_host = mysql_fetch_object ($result_details_host);

include ("header.php");
?>

<!-----------------------------------------------------------------------------------------------------------------
HTML
------------------------------------------------------------------------------------------------------------------>


    <div data-role="page">
        <div data-role="header" data-theme="<?php echo $theme;?>">
			<a href="hosts.php?inerror=<?php echo $_GET['inerror'];?>" data-role="button" data-icon="back" class="ui-btn-left" data-transition="slidedown"><?php echo _("Back")?></a>
			<a href="mobile-UI.php" data-role="button" data-icon="home" class="ui-btn-right" data-transition="fade"><?php echo _("Home")?></a>
            <h1><?php echo _("Details")?></h1>
        </div>
		
		<div data-role="content">
			<font size="2">
			<table width="100%">
				<td width="1%"></td>
				<td style="text-align:center; width:98%"><?php echo _("Host detailed status")?></td>
				<td width="1%"></td>
				</tr>
			</table>
			</font>	
			<h6>
			<font color="#30536D"><b><?php echo _("Name: ")?></font></b><?php echo ''.$obj_details_host->display_name.''; ?>
			<ul data-role="listview" data-inset="true">
				<li>
					<div>
						<font size="1">
							<font color="#30536D"><?php echo _("Alias: ")?></font><?php echo ''.$obj_details_host->alias.' "('.$obj_details_host->address.')"'; ?>
								<table class="tbl-detail">
									<tr>
										<td class="td-titre-tbl-detail"><?php echo _("Host Status")?></td>
											<?php
											if ($obj_details_host->current_state == 0 ) 
											{echo '<td class="td-statut-Up">';echo _("Up");echo '</td>';}
											elseif ($obj_details_host->current_state == 1 )
											{echo '<td class="td-statut-down">';echo _("Down");echo '</td>';}
											elseif ($obj_details_host->current_state == 2 )
											{echo '<td class="td-statut-unreachable">';echo _("Unreachable");echo '</td>';}
											elseif ($obj_details_host->current_state == 3 )
											{echo '<td class="td-statut-pending">';echo _("Pending");echo'</td>';}
										?>
									<tr>
										<td class="td-tbl-detail"><?php echo _("Attempt:")?></td>
										<td class="td-tbl-detail"><?php echo ''.$obj_details_host->current_check_attempt.''; ?>/<?php echo ''.$obj_details_host->max_check_attempts.''; ?></td>
									</tr>
									<tr>
										<td class="td-tbl-detail"><?php echo _("Last check:")?></td>
										<td class="td-tbl-detail"><?php echo ''.$obj_details_host->last_check.''; ?></td>
									</tr>
									<tr>
										<td class="td-tbl-detail"><?php echo _("Next check:")?></td>
										<td class="td-tbl-detail"><?php echo ''.$obj_details_host->next_check.''; ?></td>
									</tr>
									<tr>
										<td class="td-tbl-detail"><?php echo _("Latency:")?></td>
										<td class="td-tbl-detail"><?php echo ''.$obj_details_host->latency.''; ?></td>
									</tr>
									<tr>
										<td class="td-tbl-detail"><?php echo _("Execution time")?></td>
										<td class="td-tbl-detail"><?php echo ''.$obj_details_host->execution_time.''; ?></td>
									</tr>
									<tr>
										<td class="td-tbl-detail"><?php echo _("Last change")?></td>
										<td class="td-tbl-detail"><?php echo ''.$obj_details_host->last_state_change.''; ?></td>
									</tr>
									<tr>
										<td class="td-tbl-detail"><?php echo _("Active notifications?")?></td>
										<?php
											if ($obj_details_host->notifications_enabled == 0 ) 
											{echo '<td class="td-notif-ctrl-tbl-detail-non">';echo _("No");echo '</td>';}
											elseif ($obj_details_host->notifications_enabled == 1 )
											{echo '<td class="td-notif-ctrl-tbl-detail-oui">';echo _("Yes");echo '</td>';}
										?>
									</tr>
									<tr>
										<td class="td-tbl-detail"><?php echo _("Actives checks")?></td>
										<?php
											if ($obj_details_host->active_checks_enabled == 0 ) 
											{echo '<td class="td-notif-ctrl-tbl-detail-non">';echo _("No");echo '</td>';}
											elseif ($obj_details_host->active_checks_enabled == 1 )
											{echo '<td class="td-notif-ctrl-tbl-detail-oui">';echo _("Yes");echo '</td>';}
										?>
									</tr>
									<tr>
										<td class="td-tbl-detail"><?php echo _("Passives checks")?></td>
										<?php
											if ($obj_details_host->passive_checks_enabled == 0 ) 
											{echo '<td class="td-notif-ctrl-tbl-detail-non">';echo _("No");echo '</td>';}
											elseif ($obj_details_host->passive_checks_enabled == 1 )
											{echo '<td class="td-notif-ctrl-tbl-detail-oui">';echo _("Yes");echo '</td>';}
										?>
									</tr>
								</table>
							</h3>
						</font>
					</div>
				</li>
			</ul>
			<div>
				<font><?php echo _("Host detailed status:")?></font>
				<br />
				<font><?php echo ''.$obj_details_host->output.''; ?></font>
			</div>
			</h6>
		</div>
	</div>
</body>
</html>