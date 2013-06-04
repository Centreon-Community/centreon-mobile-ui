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
if (isset ($_GET['host']) && isset ($_GET['statusid']) && isset ($_GET['inerror']))
{
	$host_id = $_GET['host'];
	$hoststatus_id = $_GET['statusid'];
	$inerror = $_GET['inerror'];
}
else
{
	exit();
}

/*sélection du fichier contenant les requetes*/
include $Broker_queries_path.'queries_host_details.php';

$result_details_host = mysql_query ($query_details_host);
$obj_details_host = mysql_fetch_object ($result_details_host);

include ("header.php");
include ("functions.php");

include $Broker_queries_path.'queries_host_getdowntime.php';

$result_downtime_host = mysql_query ($query_downtime_host);

/*-----------------------------------------------------------------------------------------------------------------*/
/*Traitement du post*/
if(isset($_POST['ack']))
{
	if (isset ($_POST["check_sticky"]))
	{
		$post_sticky = "1";
	}
	else 
	{
		$post_sticky = "0";
	}
	
	if (isset ($_POST["check_notify"]))
	{
		$post_notify = "1";
	}
	else 
	{
		$post_notify = "0";
	}

	if (isset ($_POST["check_persistent"]))
	{
		$post_persistent = "1";
	}
	else 
	{
		$post_persistent = "0";
	}

	if (isset ($_POST["check_ackhostservice"]))
	{
		$post_ackhostservice = "1";
	}
	else 
	{
		$post_ackhostservice = "0";
	}

	$param['comment'] = $_POST['commentaire'];
	if ($param['comment']=='')
	{
		$param['comment'] = "Pas de commentaire";
	}

	$param['sticky'] = $post_sticky;
	$param["notify"] = $post_notify;
	$param['persistent'] = $post_persistent;
	$param["host_name"] = $obj_details_host->display_name;
	$param["author"] = mysql_real_escape_string($_POST["auteur"]);
	$param['ackhostservice']=$post_ackhostservice;

	acknowledgeHost($param);
}

if(isset($_POST['nonack']))
{

	acknowledgeHostDisable();

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

	if (isset ($_POST["check_svc"]))
	{
		$post_svc = "1";
	}
	else 
	{
		$post_svc = "0";
	}

	if ($_POST["commentaire"]=='')
	{
		$commentaire = "Pas de commentaire";
	}
	else
	{
		$commentaire = $_POST["commentaire"];
	}

	include $Broker_queries_path.'queries_svc_host.php';

	send_cmd(" SCHEDULE_HOST_DOWNTIME;".urldecode($obj_details_host->display_name).";".$debut.";".$fin.";".$post_fixe.";0;".$_POST['durer'].";".$_POST['auteur'].";".$commentaire, GetMyHostPoller($pearDB, urldecode($obj_details_host->display_name)));

	if($post_svc == "1")
	{
		$result = mysql_query ($query_svc_host);
		while($svc_id = mysql_fetch_object ($result))
					{
						$query_real_name = 'SELECT '.$ndoDB_assoc["db_prefix"].'objects.name2 FROM '.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'objects WHERE '.$ndoDB_assoc["db_prefix"].'objects.object_id = '.$svc_id->service_object_id.'';
						$result2 = mysql_query ($query_real_name);
						$svc_name = mysql_fetch_object ($result2);

						send_cmd(" SCHEDULE_SVC_DOWNTIME;".urldecode($obj_details_host->display_name).";".$svc_name->name2.";".$debut.";".$fin.";".$post_fixe.";0;".$_POST['durer'].";".$_POST['auteur'].";".$commentaire, GetMyHostPoller($pearDB, urldecode($obj_details_host->display_name)));
					}
	}
}

if (isset($_POST['delete_down']))
{

	include $Broker_queries_path.'queries_deleteDowntimeFromDB.php';
	
	$result = mysql_query ($query_delete_downtime);

	send_cmd(" DEL_HOST_DOWNTIME;".$_GET['downdel'], GetMyHostPoller($pearDB, urldecode($_GET["hostname"])));
}

?>

<!-----------------------------------------------------------------------------------------------------------------
HTML
------------------------------------------------------------------------------------------------------------------>


<?php 
	//Redirection et timer pour compenser le lag de nagios
	if (isset ($_POST['ack']) || isset ($_POST['nonack']) || isset($_POST['stop']) || isset($_POST['delete_down']))
	{
		sleep(1);
		header('location:host_details.php?host='.$host_id.'&statusid='.$hoststatus_id.'&inerror='.$inerror.'&reload=yes');
	}
?>



<div data-role="page">
	<div data-role="header" data-theme="<?php echo $theme;?>">
		<a href="hosts.php?inerror=<?php echo $_GET['inerror'];?>" data-role="button" data-icon="back" class="ui-btn-left" data-transition="slidedown">Back</a>
		<a href="mobile-UI.php" data-role="button" data-icon="home" class="ui-btn-right" data-transition="fade"><?php echo _("Home");?></a>
		<h1><?php echo _("Details")?></h1>
	</div>
			<div data-role="content" data-theme="<?php echo $theme;?>">
		<table width="100%">
			<tr>
				<td width="50%">	
					
					<?php 			
							if ($obj_details_host->current_state != 0){
								if ($obj_details_host->problem_has_been_acknowledged == 0){
									echo '<a href="#popup_ack_id" data-role="button" data-rel="popup" data-position-to="window" data-mini="true" data-icon="coche-grise">';
									echo _("Acknowledge");
									echo '</a>';
									echo '<div data-role="popup" id="popup_ack_id" class="ui-content" data-theme="a" data-overlay-theme="a">';
									echo '<span class="span-align-center">'; 
									echo _("Acknowledge this problem"); 
									echo '</span>
											<form action="host_details.php?';
										echo 'host='; echo $host_id;
										echo '&statusid='; echo $hoststatus_id;
										echo '&inerror='; echo $inerror;
										echo '" method="post">
										<div data-role="fieldcontain">
											<fieldset data-role="controlgroup">
											   <input type="checkbox" name="check_sticky[]" id="sticky_id" value="1" data-mini="true" />
											   <label for="sticky_id">';echo _("Sticky"); echo'</label>
											   <input type="checkbox" name="check_notify[]" id="notify_id" value="1" data-mini="true" />
											   <label for="notify_id">';echo _("Notify"); echo'</label>
											   <input type="checkbox" name="check_persistent[]" id="persistent_id" value="1" data-mini="true" />
											   <label for="persistent_id">';echo _("Persistent"); echo'</label>
											  <input type="checkbox" name="check_ackhostservice[]" id="ackhostservice_id" value="1" data-mini="true" />
											   <label for="ackhostservice_id">';echo _("Acknowledge Services"); echo'</label>
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
											<form action="host_details.php?';
										echo 'host='; echo $host_id;
										echo '&statusid='; echo $hoststatus_id;
										echo '&inerror='; echo $inerror;
										echo '&host_name='; echo $obj_details_host->display_name;
										echo '" method="post">
										
										<span>
											<input type="submit" name="nonack" value="';echo _("Confirm"); echo'" data-icon="plus" data-role="button">
											<a href="#" data-rel="back" data-icon="delete" data-theme="c" data-role="button">';echo _("Cancel"); echo '</a>
										</span>
										
										</form>';
										}
								}
								
								echo '</td><td width="50%"><a href="#popup_ack_id2" data-role="button" data-icon="alert" data-rel="popup" data-position-to="window" data-mini="true">';
									echo _("Downtime");
									echo '</a>';
									echo '<div data-role="popup" id="popup_ack_id2" class="ui-content" data-theme="a" data-overlay-theme="a">';
									echo '<span class="span-align-center">'; 
									echo _("Add a Downtime"); 
									echo '</span>
											<form action="host_details.php?';
										echo 'host='; echo $host_id;
										echo '&statusid='; echo $hoststatus_id;
										echo '&inerror='; echo $inerror;
										echo '" method="post">

										<div data-role="fieldcontain" data-theme="a">
											<label for="debut">';echo _("Start");echo'</label>
											<textarea name="debut" id="debut" data-theme="a">'; echo date("Y/m/d H:i"); echo '</textarea>
										</div>

										<div data-role="fieldcontain" data-theme="a">
											<label for="fin">';echo _("End"); echo'</label>
											<textarea name="fin" id="fin" data-theme="a">'; echo date("Y/m/d "); echo date("H")+3; echo date(":i"); echo '</textarea>
										</div>

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
										<div data-role="fieldcontain">
											<fieldset data-role="controlgroup">
											   <input type="checkbox" name="check_svc[]" id="svc_id" value="1" data-mini="true" />
											   <label for="svc_id">';echo _("Downtime Host's Services"); echo'</label>
											</fieldset>
										</div>
										<span>
											<input type="submit" name="stop" value="';echo _("Confirm"); echo'" data-icon="plus" data-role="button">
											<a href="#" data-rel="back" data-icon="delete" data-theme="c" data-role="button">';echo _("Cancel");echo '</a>
										</span>
										
										</form> </td>';
							?>
				</tr>
			</table>


            </span>
				
				<br />
				<ul data-role="listview" data-inset="true">
					<li>
						<div>
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
							<font color="#30536D"><?php echo _("Alias: ")?></font><?php echo ''.$obj_details_host->alias.' : '.$obj_details_host->address; ?>
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
			<ul data-role="listview" data-inset="true">
				<div><table><tr><td>
					<b><?php echo _("Host detailed status")?></b></td><td>
					<?php echo ''.$obj_details_host->output.''; ?></td></tr></table>
				</div>
			</ul>
			
			<ul data-role="listview" data-inset="true">
		<center><table width="90%">	
				<?php 
				$bol = true;
					while($obj_downtime = mysql_fetch_object ($result_downtime_host))
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
						echo '</td><td>';
						echo '<a href="#popup_ack_id3" data-role="button" data-rel="popup" data-position-to="window" data-mini="true">'; echo _("Delete"); echo '</a>
								<div data-role="popup" id="popup_ack_id3" class="ui-content" data-theme="a" data-overlay-theme="a">
									'; echo _("Delete Downtime"); echo '
									<form action="host_details.php?';
										echo 'host='; echo $host_id;
										echo '&statusid='; echo $hoststatus_id;
										echo '&inerror='; echo $inerror;
										echo '&downdel='; echo $obj_downtime->internal_downtime_id; 
										echo '" method="post">
									<input type="submit" name="delete_down" value="'; echo _("Delete"); echo '" data-role="button">
									<a href="#" data-rel="back" data-icon="delete" data-theme="c" data-role="button">';echo _("Cancel");echo '</a></form>
								</div>
							</td></tr>';
					}		
				?>	
		</table></center>
		</ul>

		<?php 
			$obj_opt_icon_size = mysql_fetch_object ($opt_icon_size);
			$obj_opt_icon_show = mysql_fetch_object ($opt_icon_show);

			include $Broker_queries_path.'queries_host_services.php';

			$result_host_services = mysql_query ($query_host_services);
		?>

		<ul data-role="listview" data-inset="true">
				<?php
				if(isset($result_host_services))
				{
					while($obj_service_status = mysql_fetch_object ($result_host_services))
						{ 
							echo '	
									<li class="list-item-services">
									<a data-transition="slideup" href="service_details.php?host_id='.$obj_service_status->host_id.'&service_id='.$obj_service_status->service_id.'&hostname='.$obj_service_status->hostname.'&service='.$obj_service_status->display_name.'&status_id='.$obj_service_status->servicestatus_id.'&inerror='.$inerror.'&back='.$hoststatus_id.'">
										<div>
											<table class="tbl-service-status">
												<tr>';
													if (($obj_opt_icon_show->opt_val == 1)  && ($obj_service_status->icon_image != null))
														{
														echo '	<td class="td1-host-status">
																	<img src="icone.php?HostIconPath='.$obj_service_status->icon_image.'&IconSize='.$obj_opt_icon_size->opt_val.'"svce=1" />
																</td>';
														}
							echo'					<td class="td2-service-status"><font size="2">
													'.$obj_service_status->hostname.'<br />&rarr; '.$obj_service_status->display_name.'
													</td><td>';

													/*Requete pour tester le downtime*/
													$result_down = mysql_query ('SELECT * FROM '.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'servicestatus WHERE service_object_id = (SELECT '.$ndoDB_assoc["db_prefix"].'services.service_object_id FROM '.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'services WHERE service_id = "'.$obj_service_status->service_id.'")');
													/*-----------------------------------------*/

													if(isset ($result_down))
													{
														$object_down = mysql_fetch_object($result_down);
														if ($object_down->scheduled_downtime_depth >= "1")
														{
															echo('<img src="img/down-icon.png" title="'); echo _("Downtime Ongowing"); echo ('"  width="20px" height="20px">');
														}														
													}

													echo ("</td><td>");

													/*Requete pour tester l'Ack*/
													$result_ack = mysql_query ('SELECT * FROM '.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'servicestatus WHERE service_object_id = (SELECT '.$ndoDB_assoc["db_prefix"].'services.service_object_id FROM '.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'services WHERE service_id = "'.$obj_service_status->service_id.'")');
													/*-------------------------------*/	

													if(isset($result_ack))
													{
														$object_ack = mysql_fetch_object($result_ack);
															if($object_ack->problem_has_been_acknowledged == "1")
															{
																echo ' <img src="img/ack-icon.png" title="'; echo _("Acknowledged"); echo '" width="20px" height="20px"> ';
															}
													}

													echo '</td><td class="td3-service-status">
														<img src="img/std_small_service_'.$obj_service_status->current_state.'.png" />
													</td>
												</tr>
											</table>
										</div>
									</a>
									</li>';
						}
				}
					
				?>
			</ul>



		</div>
		<div data-role="footer" data-theme="<?php echo $theme;?>">
	</div>
	</span>
</body>
</html>
