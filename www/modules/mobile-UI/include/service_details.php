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
if (isset ($_GET['host_id']) && isset ($_GET['service_id']) && isset ($_GET['status_id']) && isset ($_GET['hostname']) && isset ($_GET['service']) && isset ($_GET['inerror'])){
$host_id = $_GET['host_id'];
$service_id = $_GET['service_id'];
$servicestatus_id = $_GET['status_id'];
$hostname = $_GET['hostname'];
$service = $_GET['service'];
$inerror = $_GET['inerror'];}
else {exit();}

/*sélection du fichier contenant les requetes*/
include $Broker_queries_path.'queries_service_details_1.php';

/*on execute les requetes nécessaires à la page*/	
$result_details_service = mysql_query ($query_details_service);
$result_metric_details = mysql_query ($query_metric_details);
$obj_details_service = mysql_fetch_object ($result_details_service) ;
$obj_metric_details = mysql_fetch_object ($result_metric_details);
$result_session_id = mysql_query ($query_session_id);
$obj_session_id = mysql_fetch_object ($result_session_id);

/*sélection du fichier contenant les requetes*/
include $Broker_queries_path.'queries_service_details_2.php';

/*on execute les requetes nécessaires à la page*/
$result_metric_exist = mysql_query ($query_metric_exist);
$nbr_metric_exist = mysql_num_rows ($result_metric_exist);

/*on inclus le header*/
include ("header.php");

include ("functions.php");

/*-----------------------------------------------------------------------------------------------------------------*/
/*Traitement du post*/
if(isset($_POST['soumettre'])){
	
if (isset ($_POST["check_sticky"])){
	$post_sticky = $_POST["check_sticky"];}
else {
	$post_sticky = "0";}
	
if (isset ($_POST["check_notify"])){
	$post_notify = $_POST["check_notify"];}
else {
	$post_notify = "0";}

if (isset ($_POST["check_persistent"])){
	$post_persistent = $_POST["check_persistent"];}
else {
	$post_persistent = "0";}

$host_display_name = $obj_details_service->host_display_name;
$service_display_name = $obj_details_service->service_display_name;

set_include_path('../../../include/monitoring/external_cmd/');
include '../../../include/monitoring/external_cmd/functions.php';
/*include_once 'engine/external_cmd/functions.php';*/
/*include $engine_cmd_path.'ack_svc_problem.php';*/

Echo "Pas encore disponible";

exit();

}

?>

<!-----------------------------------------------------------------------------------------------------------------
HTML
------------------------------------------------------------------------------------------------------------------>
<?php if (isset ($_POST['soumettre'])){header('location:service_details.php?host_id='.$host_id.'&service_id='.$service_id.'&hostname='.$obj_details_service->hostname.'&service='.$obj_details_service->display_name.'&status_id='.$obj_details_service->servicestatus_id.'&inerror='.$inerror.'');}?>
    <div data-role="page">
        <div data-role="header" data-theme="<?php echo $theme;?>">
			<a href="services.php?inerror=<?php echo $_GET['inerror'];?>" data-role="button" data-icon="back" class="ui-btn-left" data-transition="slidedown">Back</a>
			<a href="mobile-UI.php" data-role="button" data-icon="home" class="ui-btn-right" data-transition="fade"><?php echo _("Home");?></a>
			<h1><?php echo _("Details")?></h1>
        </div>
		
		<div data-role="content" data-theme="<?php echo $theme;?>">
			<table width="100%">
				<td width="45%">						
							<?php 	
							
							if ($obj_details_service->current_state != 0){
								if ($obj_details_service->problem_has_been_acknowledged == 0){
									echo '<a href="#popup_ack_id" data-role="button" data-rel="popup" data-position-to="window" data-mini="true" data-icon="coche-grise">';
									echo _("Acknowledge this problem");
									echo '</a>';
									echo '<div data-role="popup" id="popup_ack_id" class="ui-content" data-theme="a" data-overlay-theme="a">';
									echo '<span class="span-align-center">'; 
									echo ("Acknowledge"); 
									echo '</span>
											<form action="service_details.php?';
										echo 'host_id='; echo $host_id;
										echo '&service_id='; echo $service_id;
										echo '&hostname='; echo $hostname;
										echo '&service='; echo $obj_details_service->display_name;
										echo '&status_id='; echo $obj_details_service->servicestatus_id;
										echo '&inerror='; echo $inerror;
										echo '" method="post">
										<div data-role="fieldcontain">
											<fieldset data-role="controlgroup">
											   <input type="checkbox" name="check_sticky[]" id="sticky_id" value="1" data-mini="true" />
											   <label for="sticky_id">';echo ("Sticky: "); echo'</label>
											   <input type="checkbox" name="check_notify[]" id="notify_id" value="1" data-mini="true" />
											   <label for="notify_id">';echo ("Notify: "); echo'</label>
											   <input type="checkbox" name="check_persistent[]" id="persistent_id" value="1" data-mini="true" />
											   <label for="persistent_id">';echo ("Persistent: "); echo'</label>
											</fieldset>
										</div>
										<div data-role="fieldcontain" data-theme="a" data-mini="true">
											<label for="auteur" data-mini="true">';echo ("Author: "); echo'</label>
											<input type="text" data-mini="true" name="auteur" id="auteur"  data-theme="a" class="ui-disabled" value="';ShowUsernameById($centreon->user->user_id); echo'"/>
										</div>
										<div data-role="fieldcontain" data-theme="a">
											<label for="commentaire">';echo ("Comment: "); echo'</label>
											<textarea name="commentaire" id="commentaire" data-theme="a"></textarea>
										</div>
										<span>
											<input type="submit" name="soumettre" value="';echo _("Confirm"); echo'" data-icon="plus" data-role="button">
											<a href="#" data-rel="back" data-icon="delete" data-theme="c" data-role="button">';echo _("Cancel");echo '</a>
											</span>
										</div>
										</form>';										
									}
								else 	
									{
										echo '<a href="#popup_ack_id" data-role="button" data-rel="popup" data-position-to="window" data-mini="true" data-icon="coche-verte">';
										echo _("Delete acknowledgement");
										echo '</a>';
										echo '<div data-role="popup" id="popup_ack_id" class="ui-content" data-theme="a" data-overlay-theme="a">';
										echo '<form action="service_details.php" method="post">
												<span>
												Are you sure?
												</span>
												<div data-role="fieldcontain" data-theme="a">
												<span>
													<a href="index.html" data-icon="plus" data-role="button">';echo _("Confirm"); echo'</a>
													<a href="#" data-rel="back" data-icon="delete" data-theme="c" data-role="button">';echo _("Cancel");echo '</a>
												</span>
												</div>';
										;}
								}
							?>
				</td>
				<td width="5%">&nbsp;</td>
				<td width="5%">&nbsp;</td>
				<td width="45%"><? if ($nbr_metric_exist != 0)
				{ echo '
					<a href="#popup_graphe_id" data-role="button" data-rel="popup" data-position-to="window" data-mini="true"><img src="img/chart.gif"></a>
						<div data-role="popup" class="popup_graphe" id="popup_graphe_id" data-theme="'.$theme.'" data-overlay-theme="'.$theme.'">
							<a href="#" data-rel="back" data-role="button" data-icon="delete" data-iconpos="notext" class="ui-btn-right">'; echo _("Close");echo '</a>

							<img id="graphe_img_jour" src="../../../include/views/graphs/generateGraphs/generateImage.php?session_id='.$obj_session_id->session_id.'&index='.$obj_metric_details->index_data_id.'&end=';echo time(); echo'&start='; echo time()-(60*60*24);echo '">
							<img id="graphe_img_mois" src="../../../include/views/graphs/generateGraphs/generateImage.php?session_id='.$obj_session_id->session_id.'&index='.$obj_metric_details->index_data_id.'&end=';echo time(); echo '&start='; echo time()-(60*60*24*31);echo '">
							<img id="graphe_img_an" src="../../../include/views/graphs/generateGraphs/generateImage.php?session_id='.$obj_session_id->session_id.'&index=<'.$obj_metric_details->index_data_id.'&end=';echo time(); echo'&start='; echo time()-(60*60*24*365); echo '">
							
							<span class="btns_graphes">
							<fieldset data-role="controlgroup" data-type="horizontal" data-mini="true">  	
								<input type="radio" name="radio-choice-2" id="radio-choice-21" value="choice-1" checked="checked" OnClick="affiche_jour("graphe_img_jour");cache_mois("graphe_img_mois");cache_an("graphe_img_an")"/>
									<label for="radio-choice-21">'; echo _("1 day");echo '</label>
								<input type="radio" name="radio-choice-2" id="radio-choice-22" value="choice-2" OnClick="cache_jour("graphe_img_jour");affiche_mois("graphe_img_mois");cache_an("graphe_img_an")" />
									<label for="radio-choice-22">'; echo _("31 days");echo '</label>
								<input type="radio" name="radio-choice-2" id="radio-choice-23" value="choice-3" OnClick="cache_jour("graphe_img_jour");cache_mois("graphe_img_mois");affiche_an("graphe_img_an")" />
									<label for="radio-choice-23">';echo _("365 days"); echo '</label>
							</fieldset>
						</div>';}?>
				</td>
				</tr>
			</table>
			</span>
				<span class="content_small_bold" ><?php echo _("Name: ")?>
					<?php echo ''.$obj_details_service->service_display_name.' &rarr; '.$obj_details_service->host_alias.'' ; ?>
				</span>
				<br />
				<ul data-role="listview" data-inset="true">
					<li>
						<div>
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
			
			<div>
				<font><?php echo _("Detailed status")?></font>
				<br />
				<font>
				<?php echo ''.$obj_details_service->output.''; ?>
				<br />
				</font>
			</div>
		</div>
	<div data-role="footer">&nbsp;
	</div>
</body>
</html>
