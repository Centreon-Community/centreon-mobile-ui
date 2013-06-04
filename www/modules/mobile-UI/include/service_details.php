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
$obj_details_service = mysql_fetch_object ($result_details_service) ;

include $Broker_queries_path.'queries_service_metric.php';

$result_metric_details = mysql_query ($query_metric_details);
$obj_metric_details = mysql_fetch_object ($result_metric_details);

$result_session_id = mysql_query ($query_session_id);
$obj_session_id = mysql_fetch_object ($result_session_id);

/*sélection du fichier contenant les requetes*/
include $Broker_queries_path.'queries_service_details_2.php';
include $Broker_queries_path.'queries_service_getdowntime.php';

$result_downtime = mysql_query ($query_downtime);

/*on execute les requetes nécessaires à la page*/
$result_metric_exist = mysql_query ($query_metric_exist);
$nbr_metric_exist = mysql_num_rows ($result_metric_exist);

/*on inclus le header*/
include ("header.php");

include ("functions.php");

/*Création des variables pour les graphs*/
$tps = time();
$tps_jour = time()-(60*60*24);
$tps_moi = time()-(60*60*24*31);
$tps_an = time()-(60*60*24*365);
$src_jour=('../../../include/views/graphs/generateGraphs/generateImage.php?session_id='.$obj_session_id->session_id.'&index='.$obj_metric_details->index_data_id.'&end='.$tps.'&start='.$tps_jour.'');
$src_moi=('../../../include/views/graphs/generateGraphs/generateImage.php?session_id='.$obj_session_id->session_id.'&index='.$obj_metric_details->index_data_id.'&end='.$tps.'&start='.$tps_moi.'');
$src_an=('../../../include/views/graphs/generateGraphs/generateImage.php?session_id='.$obj_session_id->session_id.'&index='.$obj_metric_details->index_data_id.'&end='.$tps.'&start='.$tps_an.'');

/*-----------------------------------------------------------------------------------------------------------------*/
/*Traitement du post*/
if(isset($_POST['ack']))
{
	if (isset ($_POST["check_sticky"]))
		$post_sticky = "1";
	else 
		$post_sticky = "0";
	
	if (isset ($_POST["check_notify"]))
		$post_notify = "1";
	else 
		$post_notify = "0";

	if (isset ($_POST["check_persistent"]))
		$post_persistent = "1";
	else 
		$post_persistent = "0";

	$host_display_name = $obj_details_service->host_display_name;
	$service_display_name = $obj_details_service->service_display_name;

	$param['comment'] = $_POST['commentaire'];
	if ($param['comment']=='')
	{
		$param['comment'] = "Pas de commentaire";
	}
	$param['sticky'] = $post_sticky;
	$param["notify"] = $post_notify;
	$param['persistent'] = $post_persistent;
	$param["host_name"] = $host_display_name;
	$param["service_description"] = $service_display_name;
	$param["author"] = $_POST["auteur"];
	$param['force_check'] = 1;

	acknowledgeService($param);
}

if(isset($_POST['nonack']))
{

	acknowledgeServiceDisable();

}

if(isset($_POST['stop']))
{

	$a = strptime($_POST["debut"], '%Y/%m/%d %H:%M');
	$debut = mktime($a['tm_hour'], $a['tm_min'], 0, $a['tm_mon']+1 , $a['tm_mday'], $a['tm_year']+1900);

	$b = strptime($_POST["fin"], '%Y/%m/%d %H:%M');
	$fin = mktime($b['tm_hour'], $b['tm_min'], 0, $b['tm_mon']+1 , $b['tm_mday'], $b['tm_year']+1900);

	if (isset ($_POST["check_fixe"]))
	{
		$post_fixe = "1";
	}
	else 
	{
		$post_fixe = "0";
	}

	if ($_POST["commentaire"]=='')
	{
		$commentaire = "Pas de commentaire";
	}
	else
	{
		$commentaire = $_POST["commentaire"];
	}


	send_cmd(" SCHEDULE_SVC_DOWNTIME;".urldecode($obj_details_service->host_display_name).";".urldecode($obj_details_service->service_display_name).";".$debut.";".$fin.";".$post_fixe.";0;".$_POST['durer'].";".$_POST['auteur'].";".$commentaire, GetMyHostPoller($pearDB, urldecode($_GET["hostname"])));
}

if (isset($_POST['delete_down']))
{
	include $Broker_queries_path.'queries_deleteDowntimeFromDB.php';
	
	$result = mysql_query ($query_delete_downtime);

	send_cmd(" DEL_SVC_DOWNTIME;".$_GET['downdel'], GetMyHostPoller($pearDB, urldecode($_GET["hostname"])));
}
?>

<!-----------------------------------------------------------------------------------------------------------------
HTML
------------------------------------------------------------------------------------------------------------------>

<?php 
	if ((isset ($_POST['ack'])) || (isset ($_POST['nonack'])) || (isset($_POST['stop'])) || (isset($_POST['delete_down'])))
	{
		//Redirection et timer pour compenser le lag de nagios
		sleep(1);
		if(isset($_GET['back']))
		{
		header('Location: service_details.php?host_id='.$host_id.'&service_id='.$service_id.'&hostname='.$_GET['hostname'].'&service='.$_GET['service'].'&status_id='.$obj_details_service->servicestatus_id.'&inerror='.$inerror.'&back='.$_GET['back'].'');
		}
		else
		{
		header('Location: service_details.php?host_id='.$host_id.'&service_id='.$service_id.'&hostname='.$_GET['hostname'].'&service='.$_GET['service'].'&status_id='.$obj_details_service->servicestatus_id.'&inerror='.$inerror.'');
		}
	} 
?>



    <div data-role="page">
        <div data-role="header" data-theme="<?php echo $theme;?>">
			<a href="
					<?php
						if(isset($_GET['back']))
						{
							echo'host_details.php?host='.$host_id.'&statusid='.$_GET['back'].'&inerror='.$_GET['inerror'].'';
						}
						else
						{
							echo 'services.php?inerror='.$_GET['inerror'];
						}
					?>
			" data-role="button" data-icon="back" class="ui-btn-left" data-transition="slidedown">Back</a>
			<a href="mobile-UI.php" data-role="button" data-icon="home" class="ui-btn-right" data-transition="fade"><?php echo _("Home");?></a>
			<h1><?php echo _("Details")?></h1>
        </div>
		
		<div data-role="content" data-theme="<?php echo $theme;?>">
			<table width="100%">
				<td width="40%">						
							<?php 	
							
							if ($obj_details_service->current_state != 0){
								if ($obj_details_service->problem_has_been_acknowledged == 0){
									echo '<a href="#popup_ack_id" data-role="button" data-rel="popup" data-position-to="window" data-mini="true" data-icon="coche-grise">';
									echo _("Acknowledge");
									echo '</a>';
									echo '<div data-role="popup" id="popup_ack_id" class="ui-content" data-theme="a" data-overlay-theme="a">';
									echo '<span class="span-align-center">'; 
									echo _("Acknowledge this problem"); 
									echo '</span>
											<form action="service_details.php?';
										echo 'host_id='; echo $host_id;
										echo '&service_id='; echo $service_id;
										echo '&hostname='; echo $obj_details_service->host_display_name;
										echo '&service='; echo $obj_details_service->service_display_name;
										echo '&status_id='; echo $obj_details_service->servicestatus_id;
										echo '&inerror='; echo $inerror;
										if(isset($_GET['back']))
										{
											echo '&back='; echo $_GET['back'];
										}
										echo '" method="post">
										<div data-role="fieldcontain">
											<fieldset data-role="controlgroup">
											   <input type="checkbox" name="check_sticky[]" id="sticky_id" value="1" data-mini="true" />
											   <label for="sticky_id">';echo _("Sticky"); echo'</label>
											   <input type="checkbox" name="check_notify[]" id="notify_id" value="1" data-mini="true" />
											   <label for="notify_id">';echo _("Notify"); echo'</label>
											   <input type="checkbox" name="check_persistent[]" id="persistent_id" value="1" data-mini="true" />
											   <label for="persistent_id">';echo _("Persistent"); echo'</label>
											</fieldset>
										</div>
										<div data-role="fieldcontain" data-theme="a" data-mini="true">
											';echo _("Author"); echo'
											<input type="text" data-mini="true" name="auteur" id="auteur"  data-theme="a" class="ui-disabled" value="';ShowUsernameById($centreon->user->user_id); echo'"/>
										</div>
										<div data-role="fieldcontain" data-theme="a">
											';echo _("Comment"); echo'
											<textarea name="commentaire" id="commentaire" data-theme="a"></textarea>
										</div>
										<span>
											<input type="submit" name="ack" value="';echo _("Confirm"); echo'" data-icon="plus" data-role="button">
											<a href="#" data-rel="back" data-icon="delete" data-theme="c" data-role="button">';echo _("Cancel");echo '</a>
										</span>
										
										</form>';										
									}
								else 	
									{

										echo '<a href="#popup_ack_id" data-role="button" data-rel="popup" data-position-to="window" data-mini="true" data-icon="coche-verte">';
									echo _("Delete Ack");
									echo '</a>';
									echo '<div data-role="popup" id="popup_ack_id" class="ui-content" data-theme="a" data-overlay-theme="a">';
									echo '<span class="span-align-center">'; 
									echo _("Delete acknowledgement"); 
									echo '</span>
											<form action="service_details.php?';
										echo 'host_id='; echo $host_id;
										echo '&service_id='; echo $service_id;
										echo '&hostname='; echo $obj_details_service->host_display_name;
										echo '&host_name='; echo $obj_details_service->host_display_name;
										echo '&service_description=';echo $obj_details_service->service_display_name;;
										echo '&service='; echo $obj_details_service->service_display_name;
										echo '&status_id='; echo $obj_details_service->servicestatus_id;
										echo '&inerror='; echo $inerror;
										if(isset($_GET['back']))
										{
											echo '&back='; echo $_GET['back'];
										}
										echo '" method="post">
										
										<span>
											<input type="submit" name="nonack" value="';echo _("Confirm"); echo'" data-icon="plus" data-role="button">
											<a href="#" data-rel="back" data-icon="delete" data-theme="c" data-role="button">';echo _("Cancel");echo '</a>
										</span>
										
										</form>';
										}
								}
						
									echo '</td><td width="40%"><a href="#popup_ack_id2" data-role="button" data-icon="alert" data-rel="popup" data-position-to="window" data-mini="true">';
									echo _("Downtime");
									echo '</a>';
									echo '<div data-role="popup" id="popup_ack_id2" class="ui-content" data-theme="a" data-overlay-theme="a">';
									echo '<span class="span-align-center">'; 
									echo _("Add a Downtime"); 
									echo '</span>
											<form action="service_details.php?';
										echo 'host_id='; echo $host_id;
										echo '&service_id='; echo $service_id;
										echo '&hostname='; echo $obj_details_service->host_display_name;
										echo '&service='; echo $obj_details_service->service_display_name;
										echo '&status_id='; echo $obj_details_service->servicestatus_id;
										echo '&inerror='; echo $inerror;
										if(isset($_GET['back']))
										{
											echo '&back='; echo $_GET['back'];
										}
										echo '" method="post">

										<div data-role="fieldcontain" data-theme="a">
											<label for="debut">';echo _("Start");echo'</label>
											<textarea name="debut" id="debut" data-theme="a">'; echo date("Y/m/d H:i"); echo '</textarea>
										</div>

										<div data-role="fieldcontain" data-theme="a">
											<label for="fin">';echo _("End"); echo'</label>
											<textarea name="fin" id="fin" data-theme="a">'; echo date("Y/m/d "); echo date("H")+3; echo date(":i"); echo '</textarea>
										</div>

										Duree
										<div data-role="fieldcontain">
											<fieldset data-role="controlgroup">
												';echo _("Duration"); echo'
											   <input type="checkbox" name="check_fixe[]" id="fixe_id" value="1" data-mini="true" onclick="change_gris()"/>
											   <label for="fixe_id">';echo _("Fixed"); echo'</label>
											</fieldset>
										</div>
										<div data-role="fieldcontain" data-theme="a">
											<textarea name="durer" id="durer" data-theme="a">3600</textarea>
										</div>

										<div data-role="fieldcontain" data-theme="a" data-mini="true">
											';echo _("Author"); echo'
											<input type="text" data-mini="true" name="auteur" id="auteur"  data-theme="a" class="ui-disabled" value="';ShowUsernameById($centreon->user->user_id); echo'"/>
										</div>
										<div data-role="fieldcontain" data-theme="a">
											';echo _("Comment"); echo'
											<textarea name="commentaire" id="commentaire" data-theme="a"></textarea>
										</div>
										<span>
											<input type="submit" name="stop" value="';echo _("Confirm"); echo'" data-icon="plus" data-role="button">
											<a href="#" data-rel="back" data-icon="delete" data-theme="c" data-role="button">';echo _("Cancel");echo '</a>
										</span>
										
										</form> </td>
				<td width="20%">';

					
				if ($nbr_metric_exist != 0)
				{ echo '
					<a href="#popup_graphe_id" data-role="button" data-rel="popup" data-position-to="window" data-mini="true"><img src="img/chart.gif"></a>
						<div data-role="popup" class="popup_graphe" id="popup_graphe_id" data-theme="'.$theme.'" data-overlay-theme="'.$theme.'">
							<a href="#" data-rel="back" data-role="button" data-icon="delete" data-iconpos="notext" class="ui-btn-right">'; echo _("Close");echo '</a>

							<img id="graphe_img" src="'.$src_moi.'">
							
							<span class="btns_graphes">
							<fieldset data-role="controlgroup" data-type="horizontal" data-mini="true">  	
								<input type="radio" name="radio-choice-2" id="radio-choice-21" value="choice-1" OnClick="change_src(\''.$src_jour.'\')" />
									<label for="radio-choice-21">'; echo _("1 day");echo '</label>
								<input type="radio" name="radio-choice-2" id="radio-choice-22" value="choice-2" checked="checked" OnClick="change_src(\''.$src_moi.'\')" />
									<label for="radio-choice-22">'; echo _("31 days");echo '</label>
								<input type="radio" name="radio-choice-2" id="radio-choice-23" value="choice-3" OnClick="change_src(\''.$src_an.'\')" />
									<label for="radio-choice-23">';echo _("365 days"); echo '</label>
							</fieldset>
						</div>';


				}?>
				</td>
				</tr>
			</table>
			</span>
				<span class="content_small_bold" ><?php echo _("Name: ")?>
					<?php echo ''.$obj_details_service->service_display_name.' &rarr; '.$obj_details_service->host_display_name.''; ?>
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
										?><ul data-role="listview" data-inset="true">
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
			<ul data-role="listview" data-inset="true">
			<div><table><tr><td>
				<b><?php echo _("Detailed status")?></b></td><td>
				<?php echo ''.$obj_details_service->output.''; ?></td></tr></table>
			</div>
			</ul>
	
		<ul data-role="listview" data-inset="true">
		<center><table width="90%">	
				<?php 
				$bol = true;
					while($obj_downtime = mysql_fetch_object ($result_downtime))
					{
						if($bol == true)
						{
							echo("<tr><td><b><center>");echo _("Start Date"); echo("</center></b></td><td><b><center>");echo _("End Date"); echo("</center></b></td></tr>");
							$bol = false;
						}
						echo ("<tr><td><center>".$obj_downtime->scheduled_start_time."</center></td>");
						echo ("<td><center>".$obj_downtime->scheduled_end_time."</center></td><td>");
										$x = strptime($obj_downtime->scheduled_start_time, '%Y-%m-%d %H:%M:%S');
										$xtime = mktime($x['tm_hour'], $x['tm_min'], $x['tm_sec'], $x['tm_mon']+1 , $x['tm_mday'], $x['tm_year']+1900);
										$y = strptime($obj_downtime->scheduled_end_time, '%Y-%m-%d %H:%M:%S');
										$ytime = mktime($y['tm_hour'], $y['tm_min'], $y['tm_sec'], $y['tm_mon']+1 , $y['tm_mday'], $y['tm_year']+1900);
										if (time() > $xtime && time() < $ytime)
										{
											echo "<b><font  color='red'>";echo _("Ongowing"); echo"</font></b>";
										}
						echo ('</td><td>');
						echo '<a href="#popup_ack_id3" data-role="button" data-rel="popup" data-position-to="window" data-mini="true">Supprimer</a>
								<div data-role="popup" id="popup_ack_id3" class="ui-content" data-theme="a" data-overlay-theme="a">
									'; echo _("Delete Downtime"); echo '
									<form action="service_details.php?';
									echo 'host_id='; echo $host_id;
									echo '&service_id='; echo $service_id;
									echo '&hostname='; echo $obj_details_service->host_display_name;
									echo '&service='; echo $obj_details_service->service_display_name;
									echo '&status_id='; echo $obj_details_service->servicestatus_id;
									echo '&inerror='; echo $inerror; 
									if(isset($_GET['back']))
										{
											echo '&back='; echo $_GET['back'];
										}
									echo '&downdel='; echo $obj_downtime->internal_downtime_id; 
									echo '" method="post">';
									echo '<input type="submit" name="delete_down" value="'; echo _("Delete"); echo '" data-role="button">
									<a href="#" data-rel="back" data-icon="delete" data-theme="c" data-role="button">';echo _("Cancel");echo '</a></form>
								</div>
							</td></tr>';
					}		
				?>	
		</table></center>
		</ul>
		</div>
	<div data-role="footer">&nbsp;
	</div>
</body>
</html>
