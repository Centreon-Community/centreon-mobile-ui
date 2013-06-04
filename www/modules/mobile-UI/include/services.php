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

if (isset ($_GET['nb']) && ctype_digit ($_GET['nb'])){
	$nb = $_GET['nb'];}
else {$nb = 5;}

if(isset ($_GET['page']) && ctype_digit($_GET['page'])) {
$page = $_GET['page'];}
else  { $page = 0; }

$obj_opt_icon_size = mysql_fetch_object ($opt_icon_size);
$obj_opt_icon_show = mysql_fetch_object ($opt_icon_show);

if (isset ($_POST['search_input']) or (isset ($_GET['search'])))
	{
	if (isset ($_POST['search_input'])){$search = $_POST['search_input'];}
	elseif (isset ($_GET['search'])){$search = $_GET['search'];}
	/*sélection du fichier contenant les requetes*/
	include $Broker_queries_path.'queries_services_1.php';
	$result_service_status = mysql_query ($query_service_status_1);
	$query_count_selected_service = mysql_query($count_selected_service_1);
	$row_count_selected_service = mysql_fetch_row($query_count_selected_service);
	$total_count_selected_service = $row_count_selected_service[0];
	$max_pg = ceil($total_count_selected_service / $nb);
	$get_error = mysql_fetch_object ($query_service_status_1);
	$inerror = $query_service_status_1->current_state;
	}
else {
	/*sélection du fichier contenant les requetes*/
	include $Broker_queries_path.'queries_services.php';
	if (!isset ($_GET['inerror']))
		{
		$inerror = "2";
		$result_service_status = mysql_query ($query_service_status_2);
		$query_count_selected_service = mysql_query($count_selected_service_2);
		$row_count_selected_service = mysql_fetch_row($query_count_selected_service);
		$total_count_selected_service = $row_count_selected_service[0];
		$max_pg = ceil($total_count_selected_service / $nb);
		}

	elseif ($_GET['inerror'] == 1)
		{
		$inerror = "1";
		$result_service_status = mysql_query ($query_service_status_3);
		$query_count_selected_service = mysql_query($count_selected_service_3);
		$row_count_selected_service = mysql_fetch_row($query_count_selected_service);
		$total_count_selected_service = $row_count_selected_service[0];
		$max_pg = ceil($total_count_selected_service / $nb);
		}

	elseif ($_GET['inerror'] == 2)
		{
		$inerror = "2";
		$result_service_status = mysql_query ($query_service_status_4);
		$query_count_selected_service = mysql_query($count_selected_service_4);
		$row_count_selected_service = mysql_fetch_row($query_count_selected_service);
		$total_count_selected_service = $row_count_selected_service[0];
		$max_pg = ceil($total_count_selected_service / $nb);
		}
	elseif ($_GET['inerror'] == 3)
		{
		$inerror = "3";
		$result_service_status = mysql_query ($query_service_status_6);
		$query_count_selected_service = mysql_query($count_selected_service_6);
		$row_count_selected_service = mysql_fetch_row($query_count_selected_service);
		$total_count_selected_service = $row_count_selected_service[0];
		$max_pg = ceil($total_count_selected_service / $nb);
		}
	
	else 	{
			$inerror = "2";
			$result_service_status = mysql_query ($query_service_status_5);
			$query_count_selected_service = mysql_query($count_selected_service_5);
			$row_count_selected_service = mysql_fetch_row($query_count_selected_service);
			$total_count_selected_service = $row_count_selected_service[0];
			$max_pg = ceil($total_count_selected_service / $nb);
			}
		}

include ("header.php");
?>


    <div data-role="page">
	
        <div data-role="header" data-theme="<?php echo $theme;?>">
		<a href="mobile-UI.php" data-role="button" data-icon="home" class="ui-btn-right" data-transition="fade">Home</a>
            <h1><?php echo _("Services")?></h1>
        </div>
		
        <div data-role="content">
		
			<table width="100%">
			<tr><td width="100%" align="center">
				<form method="post">
				<input type="search" name="search_input" id="search"<?php if (isset ($_POST['search_input'])) {echo ' value="'.$_POST['search_input'].'"';}?>/>
				</form>
			</td></tr>
			<tr><td width="100%" align="center">
			<form method="post">
				<fieldset data-role="fieldcontain">
				<select name="host" onChange="location = this.options[this.selectedIndex].value">
					<option <?php if ($inerror == 3) {echo "selected ";} echo 'value="services.php?inerror=3"';?>><?php echo _("Services Unhandled")?></option>
					<option <?php if ($inerror == 1) {echo "selected ";} echo 'value="services.php?inerror=1"';?>><?php echo _("Services problems")?></option>
					<option <?php if ($inerror == 2) {echo "selected ";} echo 'value="services.php?inerror=2"';?>><?php echo _("All services")?></option>
					<?php if (isset ($_POST['search_input'])or isset ($_GET['search'])) {echo '<option selected>'; echo _("Search results");echo '</option>';}?>
				</select>
				</fieldset>
			</form>
			</td></tr>
			</table>
			
			<table style="width:100%">
				<tr><td><font size="2"><?php echo _("Pge N&deg;:")?></font></td><td><font size="2"><?php echo _("Results/page:")?></font></td></tr>
				<tr>
					<td style="text-align:left; width:40%;">
					<form method="post">
					<fieldset data-role="fieldcontain"><select name="pge_number" onChange="location = this.options[this.selectedIndex].value">							
						<?php
							
									for($i = 0 ; $i < $max_pg ; $i++) 
										{
										if ($i == $page)
											{echo '<option selected value="services.php?page='.$i.'&nb='.$nb.'&inerror='.$inerror.'';
													if (isset ($_POST['search_input']))
														{echo '&search='.$_POST['search_input'].'';}
													elseif (isset ($_GET['search']))
														{echo '&search='.$_GET['search'].'';}
										echo'">'.$i.'</option>';}
										else 
											{echo '<option value="services.php?page='.$i.'&nb='.$nb.'&inerror='.$inerror.'';
													if (isset ($_POST['search_input']))
														{echo '&search='.$_POST['search_input'].'';}
													elseif (isset ($_GET['search']))
														{echo '&search='.$_GET['search'].'';}
										echo'">'.$i.'</option>';}
										}
									
						?>
						</select></fieldset></form>
					</td>
						
				 	<td style="text-align:left; width:60%;"><select name="results_pge" onChange="location = this.options[this.selectedIndex].value">									
						<?php	if (!isset ($_GET['nb']))	
									{
									echo '<option selected value="services.php?page='.$page.'&nb=5&inerror='.$inerror.'';
											if (isset ($_POST['search_input']))
														{echo '&search='.$_POST['search_input'].'';}
													elseif (isset ($_GET['search']))
														{echo '&search='.$_GET['search'].'';}
										echo '">5</option>';
									echo '<option value="services.php?page='.$page.'&nb=10&inerror='.$inerror.'';
											if (isset ($_POST['search_input']))
														{echo '&search='.$_POST['search_input'].'';}
													elseif (isset ($_GET['search']))
														{echo '&search='.$_GET['search'].'';}
										echo '">10</option>';
									echo '<option value="services.php?page='.$page.'&nb=15&inerror='.$inerror.'';
											if (isset ($_POST['search_input']))
														{echo '&search='.$_POST['search_input'].'';}
													elseif (isset ($_GET['search']))
														{echo '&search='.$_GET['search'].'';}
										echo '">15</option>';
									echo '<option value="services.php?page='.$page.'&nb=20&inerror='.$inerror.'';
											if (isset ($_POST['search_input']))
														{echo '&search='.$_POST['search_input'].'';}
													elseif (isset ($_GET['search']))
														{echo '&search='.$_GET['search'].'';}
										echo '">20</option>';
									}
								else
									{
										if ($nb == 5)
										{	echo '<option selected value="services.php?page='.$page.'&nb=5&inerror='.$inerror.'';
												if (isset ($_POST['search_input']))
														{echo '&search='.$_POST['search_input'].'';}
													elseif (isset ($_GET['search']))
														{echo '&search='.$_GET['search'].'';}
												echo '">5</option>';
											echo '<option value="services.php?page='.$page.'&nb=10&inerror='.$inerror.'';
													if (isset ($_POST['search_input']))
														{echo '&search='.$_POST['search_input'].'';}
													elseif (isset ($_GET['search']))
														{echo '&search='.$_GET['search'].'';}
												echo '">10</option>';
											echo '<option value="services.php?page='.$page.'&nb=15&inerror='.$inerror.'';
													if (isset ($_POST['search_input']))
														{echo '&search='.$_POST['search_input'].'';}
													elseif (isset ($_GET['search']))
														{echo '&search='.$_GET['search'].'';}
												echo '">15</option>';
											echo '<option value="services.php?page='.$page.'&nb=20&inerror='.$inerror.'';
													if (isset ($_POST['search_input']))
														{echo '&search='.$_POST['search_input'].'';}
													elseif (isset ($_GET['search']))
														{echo '&search='.$_GET['search'].'';}
												echo '">20</option>';
										}
										elseif ($nb == 10)
										{	echo '<option value="services.php?page='.$page.'&nb=5&inerror='.$inerror.'';
												if (isset ($_POST['search_input']))
														{echo '&search='.$_POST['search_input'].'';}
													elseif (isset ($_GET['search']))
														{echo '&search='.$_GET['search'].'';}
												echo '">5</option>';
											echo '<option selected value="services.php?page='.$page.'&nb=10&inerror='.$inerror.'';
													if (isset ($_POST['search_input']))
														{echo '&search='.$_POST['search_input'].'';}
													elseif (isset ($_GET['search']))
														{echo '&search='.$_GET['search'].'';}
												echo '">10</option>';
											echo '<option value="services.php?page='.$page.'&nb=15&inerror='.$inerror.'';
													if (isset ($_POST['search_input']))
														{echo '&search='.$_POST['search_input'].'';}
													elseif (isset ($_GET['search']))
														{echo '&search='.$_GET['search'].'';}
												echo '">15</option>';
											echo '<option value="services.php?page='.$page.'&nb=20&inerror='.$inerror.'';
													if (isset ($_POST['search_input']))
														{echo '&search='.$_POST['search_input'].'';}
													elseif (isset ($_GET['search']))
														{echo '&search='.$_GET['search'].'';}
												echo '">20</option>';
										}
										elseif ($nb == 15)
										{	echo '<option value="services.php?page='.$page.'&nb=5&inerror='.$inerror.'';
												if (isset ($_POST['search_input']))
														{echo '&search='.$_POST['search_input'].'';}
													elseif (isset ($_GET['search']))
														{echo '&search='.$_GET['search'].'';}
												echo '">5</option>';
											echo '<option value="services.php?page='.$page.'&nb=10&inerror='.$inerror.'';
													if (isset ($_POST['search_input']))
														{echo '&search='.$_POST['search_input'].'';}
													elseif (isset ($_GET['search']))
														{echo '&search='.$_GET['search'].'';}
												echo '">10</option>';
											echo '<option selected value="services.php?page='.$page.'&nb=15&inerror='.$inerror.'';
													if (isset ($_POST['search_input']))
														{echo '&search='.$_POST['search_input'].'';}
													elseif (isset ($_GET['search']))
														{echo '&search='.$_GET['search'].'';}
												echo '">15</option>';
											echo '<option value="services.php?page='.$page.'&nb=20&inerror='.$inerror.'';
													if (isset ($_POST['search_input']))
														{echo '&search='.$_POST['search_input'].'';}
													elseif (isset ($_GET['search']))
														{echo '&search='.$_GET['search'].'';}
												echo '">20</option>';
										}
										elseif ($nb == 20)
										{	echo '<option value="services.php?page='.$page.'&nb=5&inerror='.$inerror.'';
												if (isset ($_POST['search_input']))
														{echo '&search='.$_POST['search_input'].'';}
													elseif (isset ($_GET['search']))
														{echo '&search='.$_GET['search'].'';}
												echo '">5</option>';
											echo '<option value="services.php?page='.$page.'&nb=10&inerror='.$inerror.'';
													if (isset ($_POST['search_input']))
														{echo '&search='.$_POST['search_input'].'';}
													elseif (isset ($_GET['search']))
														{echo '&search='.$_GET['search'].'';}
												echo '">10</option>';
											echo '<option value="services.php?page='.$page.'&nb=15&inerror='.$inerror.'';
													if (isset ($_POST['search_input']))
														{echo '&search='.$_POST['search_input'].'';}
													elseif (isset ($_GET['search']))
														{echo '&search='.$_GET['search'].'';}
												echo '">15</option>';
											echo '<option selected value="services.php?page='.$page.'&nb=20&inerror='.$inerror.'';
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
				
					while($obj_service_status = mysql_fetch_object ($result_service_status))
						{ 
							echo '	
									<li class="list-item-services">
									<a data-transition="slideup" href="service_details.php?host_id='.$obj_service_status->host_id.'&service_id='.$obj_service_status->service_id.'&hostname='.$obj_service_status->hostname.'&service='.$obj_service_status->display_name.'&status_id='.$obj_service_status->servicestatus_id.'&inerror='.$inerror.'">
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
					
				?>
			</ul>
		</div>
	</div>
	<div stat-role="footer">
	</div>
</body>
</html>
