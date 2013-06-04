<?php
require_once "include_first.php";

//---------------------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------------------------------------------------------------------------------------

/*on inclus les fichiers communs*/
include_once "common.php";
include "queries/queries_common.php";

/*r�cup�ration des variables pass�es en url ou cr�ation*/
if (isset ($_GET['nb']) && ctype_digit ($_GET['nb'])){
	$nb = $_GET['nb'];}
else {$nb = 5;}

if(isset ($_GET['page']) && ctype_digit ($_GET['page'])) {
$page = $_GET['page'];}
else  { $page = 0; }


/*on execute les requetes n�cessaires � la page*/	
$obj_opt_icon_size = mysql_fetch_object ($opt_icon_size);
$obj_opt_icon_show = mysql_fetch_object ($opt_icon_show);

if (isset ($_POST['search_input']) or (isset ($_GET['search'])))
	{
	if (isset ($_POST['search_input'])){$search = $_POST['search_input'];}
	elseif (isset ($_GET['search'])){$search = $_GET['search'];}
	/*s�lection du fichier contenant les requetes*/
	include $Broker_queries_path.'queries_hosts_1.php';
	$result_query_host_status = mysql_query ($query_host_status_1);
	echo $query_host_status_1;
	$query_count_selected_hosts = mysql_query($count_selected_hosts_1);
	$row_count_selected_hosts = mysql_fetch_row($query_count_selected_hosts);
	$total_count_selected_hosts = $row_count_selected_hosts[0];
	$max_pg = ceil($total_count_selected_hosts / $nb);
	$get_error = mysql_fetch_object ($query_host_status_1);
	$inerror = $query_host_status_1->current_state;
	}
else {
	/*s�lection du fichier contenant les requetes*/
	include $Broker_queries_path.'queries_hosts.php';
	if (!isset ($_GET['inerror']) or ($_GET['inerror'] == 2))
		{
		$inerror = "2";
		$result_query_host_status = mysql_query ($query_host_status_2) or die (mysql_error());
		$query_count_selected_hosts = mysql_query($count_selected_hosts_2);
		$row_count_selected_hosts = mysql_fetch_row($query_count_selected_hosts);
		$total_count_selected_hosts = $row_count_selected_hosts[0];
		$max_pg = ceil($total_count_selected_hosts / $nb);
		
		}

	elseif ($_GET['inerror'] == 1)
		{
		$inerror = "1";
		$result_query_host_status = mysql_query ($query_host_status_3);
		$query_count_selected_hosts = mysql_query($count_selected_hosts_3);
		$row_count_selected_hosts = mysql_fetch_row($query_count_selected_hosts);
		$total_count_selected_hosts = $row_count_selected_hosts[0];
		$max_pg = ceil($total_count_selected_hosts / $nb);
		}

elseif ($_GET['inerror'] == 3)
		{
		$inerror = "3";
		$result_query_host_status = mysql_query ($query_host_status_5);
		$query_count_selected_hosts = mysql_query($count_selected_hosts_5);
		$row_count_selected_hosts = mysql_fetch_row($query_count_selected_hosts);
		$total_count_selected_hosts = $row_count_selected_hosts[0];
		$max_pg = ceil($total_count_selected_hosts / $nb);
		}
	
	else 	{
			$inerror = "2";
			$result_query_host_status = mysql_query ($query_host_status_4);
			$query_count_selected_hosts = mysql_query($count_selected_hosts_4);
			$row_count_selected_hosts = mysql_fetch_row($query_count_selected_hosts);
			$total_count_selected_hosts = $row_count_selected_hosts[0];
			$max_pg = ceil($total_count_selected_hosts / $nb);
			}
		}


/*on inclus le header*/
include ("header.php");
?>


    <div data-role="page">
	
        <div data-role="header" data-theme="<?php echo $theme;?>">
			<a href="mobile-UI.php" data-role="button" data-icon="home" class="ui-btn-right" data-transition="fade">Home</a>
            <h1><?php echo _("Hosts")?></h1>
        </div>
		
        <div data-role="content">
		
			<table width="100%">
				<tr>
					<td width="100%" align="center">
						<form method="post">
							<input type="search" name="search_input" id="search"<?php if (isset ($_POST['search_input'])) {echo ' value="'.$_POST['search_input'].'"';}?>/>
						</form>
					</td>
				</tr>
				<tr>
		
					<td width="100%" align="center">
						<form method="post" id="SelectHosts">
							<fieldset data-role="fieldcontain">
								<select name="host" onChange="location = this.options[this.selectedIndex].value">
									<option <?php if ($inerror == 3) {echo "selected ";} echo 'value="hosts.php?inerror=3"';?>><?php echo _("Hosts Unhandled")?></option>
									<option <?php if ($inerror == 1) {echo "selected ";} echo 'value="hosts.php?inerror=1"';?>><?php echo _("Hosts with errors")?></option>
									<option <?php if ($inerror == 2) {echo "selected ";} echo 'value="hosts.php?inerror=2"';?>><?php echo _("All hosts")?></option>
									<?php if (isset ($_POST['search_input']) or isset ($_GET['search'])) {echo '<option selected>';echo _("Search results");echo '</option>';}?>
								</select>
							</fieldset>
						</form>
					</td>
				</tr>
			</table>

			<table style="width:100%">
				<tr>
					<td>
						<font size="2"><?php echo _("Pge N&deg;:")?></font>
					</td>
					<td>
						<font size="2"><?php echo _("Results/page:")?></font>
						</td>
					</tr>
				<tr>
					<td style="text-align:left; width:40%;">
						<form method="post">
							<fieldset data-role="fieldcontain">
								<select name="pge_number" onChange="location = this.options[this.selectedIndex].value">							
									<?php
												echo "<option value='hosts.php?page=0&nb='.$nb.'&inerror='.$inerror.'>&nbsp; </option>";
												for($i = 0 ; $i < $max_pg ; $i++) 
													{
													if ($i == $page)
													{	echo '<option selected value="hosts.php?page='.$i.'&nb='.$nb.'&inerror='.$inerror.'';
															if (isset ($_POST['search_input']))
															{echo '&search='.$_POST['search_input'].'';}
															elseif (isset ($_GET['search']))
															{echo '&search='.$_GET['search'].'';}
														echo '">'.$i.'</option>';}
													else 
														{echo '<option value="hosts.php?page='.$i.'&nb='.$nb.'&inerror='.$inerror.'';
															if (isset ($_POST['search_input']))
															{echo '&search='.$_POST['search_input'].'';}
															elseif (isset ($_GET['search']))
															{echo '&search='.$_GET['search'].'';}
													echo'">'.$i.'</option>';}
													}
												
									?>
								</select>
							</fieldset>
						</form>
					</td>	
				 	<td style="text-align:left; width:60%;">
						<select name="results_pge" onChange="location = this.options[this.selectedIndex].value">									
							<?php	if (!isset ($_GET['nb']))	
										{
										echo '<option selected value="hosts.php?page='.$page.'&nb=5&inerror='.$inerror.'';
												if (isset ($_POST['search_input']))
															{echo '&search='.$_POST['search_input'].'';}
															elseif (isset ($_GET['search']))
															{echo '&search='.$_GET['search'].'';}
											echo '">5</option>';
										echo '<option value="hosts.php?page='.$page.'&nb=10&inerror='.$inerror.'';
												if (isset ($_POST['search_input']))
															{echo '&search='.$_POST['search_input'].'';}
															elseif (isset ($_GET['search']))
															{echo '&search='.$_GET['search'].'';}
											echo '">10</option>';
										echo '<option value="hosts.php?page='.$page.'&nb=15&inerror='.$inerror.'';
												if (isset ($_POST['search_input']))
															{echo '&search='.$_POST['search_input'].'';}
															elseif (isset ($_GET['search']))
															{echo '&search='.$_GET['search'].'';}
											echo '">15</option>';
										echo '<option value="hosts.php?page='.$page.'&nb=20&inerror='.$inerror.'';
												if (isset ($_POST['search_input']))
															{echo '&search='.$_POST['search_input'].'';}
															elseif (isset ($_GET['search']))
															{echo '&search='.$_GET['search'].'';}
											echo '">20</option>';
										}
									else
										{
											if ($nb == 5)
											{	echo '<option selected value="hosts.php?page='.$page.'&nb=5&inerror='.$inerror.'';
													if (isset ($_POST['search_input']))
															{echo '&search='.$_POST['search_input'].'';}
															elseif (isset ($_GET['search']))
															{echo '&search='.$_GET['search'].'';}
													echo '">5</option>';
												echo '<option value="hosts.php?page='.$page.'&nb=10&inerror='.$inerror.'';
														if (isset ($_POST['search_input']))
															{echo '&search='.$_POST['search_input'].'';}
															elseif (isset ($_GET['search']))
															{echo '&search='.$_GET['search'].'';}
													echo '">10</option>';
												echo '<option value="hosts.php?page='.$page.'&nb=15&inerror='.$inerror.'';
														if (isset ($_POST['search_input']))
															{echo '&search='.$_POST['search_input'].'';}
															elseif (isset ($_GET['search']))
															{echo '&search='.$_GET['search'].'';}
													echo '">15</option>';
												echo '<option value="hosts.php?page='.$page.'&nb=20&inerror='.$inerror.'';
														if (isset ($_POST['search_input']))
															{echo '&search='.$_POST['search_input'].'';}
															elseif (isset ($_GET['search']))
															{echo '&search='.$_GET['search'].'';}
													echo '">20</option>';
											}
											elseif ($nb == 10)
											{	echo '<option value="hosts.php?page='.$page.'&nb=5&inerror='.$inerror.'';
													if (isset ($_POST['search_input']))
															{echo '&search='.$_POST['search_input'].'';}
															elseif (isset ($_GET['search']))
															{echo '&search='.$_GET['search'].'';}
													echo '">5</option>';
												echo '<option selected value="hosts.php?page='.$page.'&nb=10&inerror='.$inerror.'';
														if (isset ($_POST['search_input']))
															{echo '&search='.$_POST['search_input'].'';}
															elseif (isset ($_GET['search']))
															{echo '&search='.$_GET['search'].'';}
													echo '">10</option>';
												echo '<option value="hosts.php?page='.$page.'&nb=15&inerror='.$inerror.'';
														if (isset ($_POST['search_input']))
															{echo '&search='.$_POST['search_input'].'';}
															elseif (isset ($_GET['search']))
															{echo '&search='.$_GET['search'].'';}
													echo '">15</option>';
												echo '<option value="hosts.php?page='.$page.'&nb=20&inerror='.$inerror.'';
														if (isset ($_POST['search_input']))
															{echo '&search='.$_POST['search_input'].'';}
															elseif (isset ($_GET['search']))
															{echo '&search='.$_GET['search'].'';}
													echo '">20</option>';
											}
											elseif ($nb == 15)
											{	echo '<option value="hosts.php?page='.$page.'&nb=5&inerror='.$inerror.'';
													if (isset ($_POST['search_input']))
															{echo '&search='.$_POST['search_input'].'';}
															elseif (isset ($_GET['search']))
															{echo '&search='.$_GET['search'].'';}
													echo '">5</option>';
												echo '<option value="hosts.php?page='.$page.'&nb=10&inerror='.$inerror.'';
														if (isset ($_POST['search_input']))
															{echo '&search='.$_POST['search_input'].'';}
															elseif (isset ($_GET['search']))
															{echo '&search='.$_GET['search'].'';}
													echo '">10</option>';
												echo '<option selected value="hosts.php?page='.$page.'&nb=15&inerror='.$inerror.'';
														if (isset ($_POST['search_input']))
															{echo '&search='.$_POST['search_input'].'';}
															elseif (isset ($_GET['search']))
															{echo '&search='.$_GET['search'].'';}
													echo '">15</option>';
												echo '<option value="hosts.php?page='.$page.'&nb=20&inerror='.$inerror.'';
														if (isset ($_POST['search_input']))
															{echo '&search='.$_POST['search_input'].'';}
															elseif (isset ($_GET['search']))
															{echo '&search='.$_GET['search'].'';}
													echo '">20</option>';
											}
											elseif ($nb == 20)
											{	echo '<option value="hosts.php?page='.$page.'&nb=5&inerror='.$inerror.'';
													if (isset ($_POST['search_input']))
															{echo '&search='.$_POST['search_input'].'';}
															elseif (isset ($_GET['search']))
															{echo '&search='.$_GET['search'].'';}
													echo '">5</option>';
												echo '<option value="hosts.php?page='.$page.'&nb=10&inerror='.$inerror.'';
														if (isset ($_POST['search_input']))
															{echo '&search='.$_POST['search_input'].'';}
															elseif (isset ($_GET['search']))
															{echo '&search='.$_GET['search'].'';}
													echo '">10</option>';
												echo '<option value="hosts.php?page='.$page.'&nb=15&inerror='.$inerror.'';
														if (isset ($_POST['search_input']))
															{echo '&search='.$_POST['search_input'].'';}
															elseif (isset ($_GET['search']))
															{echo '&search='.$_GET['search'].'';}
													echo '">15</option>';
												echo '<option selected value="hosts.php?page='.$page.'&nb=20&inerror='.$inerror.'';
														if (isset ($_POST['search_input']))
															{echo '&search='.$_POST['search_input'].'';}
															elseif (isset ($_GET['search']))
															{echo '&search='.$_GET['search'].'';}
													echo '">20</option>';
											}
										}
									?>
						</select>
					</td>
				</tr>
			</table>
			
			<ul data-role="listview" data-inset="true">
				<?php
				
					while($obj_query_host_status = mysql_fetch_object ($result_query_host_status))
						{
							echo '
									<li class="li_host-error">
									<a data-transition="slideup" href="host_details.php?host='.$obj_query_host_status->host_id.'&statusid='.$obj_query_host_status->hoststatus_id.'&inerror='.$inerror.'">
										<div>
											<table class="tbl-host-status">
												<tr>';
													if (($obj_opt_icon_show->opt_val == 1) && ($obj_query_host_status->icon_image != null))
														{
														echo '	<td class="td1-host-status">
																	<img src="icone.php?HostIconPath='.$obj_query_host_status->icon_image.'&IconSize='.$obj_opt_icon_size->opt_val.'&hst=1" />
																</td>';
														}
							echo '						<td class="td2-host-status"><font size="2">
														'.$obj_query_host_status->display_name.'
													</td><td>';

													/*Requete pour tester le downtime*/
													$result_down = mysql_query ('SELECT * FROM '.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'hoststatus WHERE host_object_id = (SELECT object_id FROM '.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'objects WHERE name1 = (SELECT '.$ndoDB_assoc["db_prefix"].'hosts.display_name FROM '.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'hosts WHERE host_id = "'.$obj_query_host_status->host_id.'") AND (objecttype_id = "1"))');
													/*-----------------------------------------*/

													if(isset ($result_down))
													{
														$object_down = mysql_fetch_object($result_down);
														if ($object_down->scheduled_downtime_depth == "1")
														{
															echo('<img src="img/down-icon.png" title="'); echo _("Downtime Ongowing"); echo ('"  width="20px" height="20px">');
														}														
													}

													echo ("</td><td>");

													/*Requete pour tester l'Ack*/
													$result_ack = mysql_query ('SELECT '.$ndoDB_assoc["db_prefix"].'hoststatus.problem_has_been_acknowledged FROM '.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'hoststatus WHERE host_object_id = (SELECT '.$ndoDB_assoc["db_prefix"].'objects.object_id FROM '.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'objects WHERE name1 = (SELECT '.$ndoDB_assoc["db_prefix"].'hosts.display_name FROM '.$ndoDB_assoc["db_name"].'.'.$ndoDB_assoc["db_prefix"].'hosts WHERE host_id = "'.$obj_query_host_status->host_id.'") AND (objecttype_id = "1"))');
													/*-------------------------------*/	

													if(isset($result_ack))
													{
														$object_ack = mysql_fetch_object($result_ack);
														if($object_ack->problem_has_been_acknowledged == "1")
														{
															echo ' <img src="img/ack-icon.png" title="'; echo _("Acknowledged"); echo '" width="20px" height="20px"> ';
														}
													}




													echo '</td><td class=td3-host-status">
														<img src="img/std_small_host_'.$obj_query_host_status->current_state.'.png" />
													</td>
												</tr>
											</table>
										</div>
									</a>
									</li>';
						}
				?>
				
			</ul></div>
		</div>
	<div data-role="footer" data-theme="<?php echo $theme;?>">
	</div>
</body>
</html>

</html>
