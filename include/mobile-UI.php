<?php
require_once "include_first.php";

//--------------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------------------------------------------------------------------------------------------------------------

include_once "common.php";
include "queries/queries_common.php";

$result_verify_opts = mysql_query ($query_verify_opts);
$count_verify_opts = mysql_num_rows ($result_verify_opts);
if ($count_verify_opts != '7')
	{
	mysql_query ('DELETE FROM '.$conf_centreon['db'].'.mui_opts WHERE user_id = "'.$centreon->user->user_id.'"');
	mysql_query ($create_opts);
	}
//------------------------------------------------------------------------------------------------------------------------------------------

include $Broker_queries_path.'queries_mobile-UI_1.php';

include("header.php");
?>

<!-----------------------------------------------------------------------------------------------------------------
HTML
------------------------------------------------------------------------------------------------------------------>


	<div data-role="page" data-cache="never">
	
		<div data-role="header" data-theme="<?php echo $theme;?>">
			<a href="options.php" data-role="button" data-icon="gear" data-iconpos="notext" class="ui-btn-left" data-transition="fade"></a>
			<a href="../../../index.php?disconnect=1" rel="external" data-role="button" data-icon="delete" data-iconpos="notext" class="ui-btn-right" data-transition="fade"></a>
			<h6>Centreon</h6>
		</div>
			
		<div data-role="content">
			<font size="4">
			<table class="tbl_def">
				<td width="1%"></td>
				<td style="text-align:center; width:98%">IT & Network Monitoring</td>
				<td width="1%"></td>
				</tr>
			</table>
			</font>
			<h6>
				<p>
				<div id="div_recap">
					<table class="tbl_recap">
						<tr class="td_recap">
							<td><?php  echo _("Hosts")?></td>
							<td class="td_recap"><?php  echo _("Up")?></td>
							<td class="td_recap"><?php  echo _("Down")?></td>
							<td class="td_recap"><?php  echo _("Unreachable")?></td>
							<td class="td_recap"><?php  echo _("Pending")?></td>
						</tr>
						<tr>
						<td class="td_recap_resultsAll">
							<?php	$result_total_hosts = mysql_query ($query_total_hosts);
									$count_total_hosts = mysql_num_rows ($result_total_hosts);
									echo "$count_total_hosts";
							?>
						</td>
						<?php				
							$i=0;				
							for ($i = 0; $i <= 3; $i++) 
								{
								include $Broker_queries_path.'queries_mobile-UI_2.php';								
								$result_total_host_current_status = mysql_query( $query_total_host_current_status ); 
								$obj_total_host_current_status = mysql_num_rows($result_total_host_current_status);
								if ( $i == 0) 
									{
									$obj_total_host_current_status0 = $obj_total_host_current_status;
									echo '<td class="td_recap_resultsUp">'.$obj_total_host_current_status.'</td>';
									}
								elseif ( $i == 1 )
									{
									$obj_total_host_current_status1 = $obj_total_host_current_status;
									echo '<td class="td_recap_resultsDown">'.$obj_total_host_current_status.'</td>';
									}
								elseif ( $i == 2 )
									{
									$obj_total_host_current_status2 = $obj_total_host_current_status;
									echo '<td class="td_recap_resultsUnreachable">'.$obj_total_host_current_status.'</td>';
									}
								elseif ( $i == 3 )
									{
									$obj_total_host_current_status3 = $obj_total_host_current_status;
									echo '<td class="td_recap_resultsPending">'.$obj_total_host_current_status.'</td>';
									}
								}
						?>
						</tr>
					</table>
					<br/>
					<table class="tbl_recap">
						<tr class="td_recap">
							<td><?php  echo _("Services")?></td>
							<td class="td_recap"><?php  echo _("Ok")?></td>
							<td class="td_recap"><?php  echo _("Warning")?></td>
							<td class="td_recap"><?php  echo _("Critical")?></td>
							<td class="td_recap"><?php  echo _("Unknown")?></td>
							<td class="td_recap"><?php  echo _("Pending")?></td>
						</tr>
						<tr>
							<td class="td_recap_resultsAll">
								<?php
									$result_total_services = mysql_query ($query_total_services);
									$count_total_services = mysql_num_rows ($result_total_services);
									echo "$count_total_services";
				
								$i=0;				
								for ($i = 0; $i <= 4; $i++) 
									{
									include $Broker_queries_path.'queries_mobile-UI_2.php';								
									$result_total_service_current_status = mysql_query( $query_total_services_current_status ); 
									$obj_total_service_current_status = mysql_num_rows($result_total_service_current_status);
									if ( $i == 0) 
										{
										$obj_total_service_current_status0 = $obj_total_service_current_status;
										echo '<td class="td_recap_resultsUp">'.$obj_total_service_current_status.'</td>';
										}
									elseif ( $i == 1 )
										{
										$obj_total_service_current_status1 = $obj_total_service_current_status;
										echo '<td class="td_recap_resultsWarning">'.$obj_total_service_current_status.'</td>';
										}
									elseif ( $i == 2 )
										{
										$obj_total_service_current_status2 = $obj_total_service_current_status;
										echo '<td class="td_recap_resultsCritical">'.$obj_total_service_current_status.'</td>';
										}
									elseif ( $i == 3 )
										{
										$obj_total_service_current_status3 = $obj_total_service_current_status;
										echo '<td class="td_recap_resultsUnknown">'.$obj_total_service_current_status.'</td>';
										}
									elseif ( $i == 4 )
										{
										$obj_total_service_current_status4 = $obj_total_service_current_status;
										echo '<td class="td_recap_resultsPending">'.$obj_total_service_current_status.'</td>';
										}
									}
						
								?>
					</table>
				</div>		
				</p>
			</h6>
			
			<h4>
				<ul data-role="listview" data-inset="true">
					<li>
						<a href="hosts.php?inerror=1">
							<div><?php  echo _("Hosts")?></div>
							<span class="ui-li-count"><?php echo $obj_total_host_current_status1+$obj_total_host_current_status2+$obj_total_host_current_status3;?></span>
						</a>
					</li>
					<li>
						<a href="services.php?inerror=1">
							<div><?php  echo _("Services")?></div>
							<span class="ui-li-count"><?php echo $obj_total_service_current_status1+$obj_total_service_current_status2+$obj_total_service_current_status3+$obj_total_service_current_status4;?></span>
						</a>
					</li>				
					<?php
						//search for plugin file in plugins directory
						$dir_plugins = "plugins";
						$files_dir_plugins = scandir($dir_plugins);
						$IsPlugin_file = preg_grep("#^[a-zA-Z0-9]+_plugin_[a-zA-Z0-9._-]+#" , $files_dir_plugins);
						while (list($key, $val) = each($IsPlugin_file))
							{
							preg_match('#(^[a-zA-Z0-9]+)(_plugin_)([a-zA-Z0-9_-]+)#', $val, $matches);
							$query_opts = mysql_query('SELECT * FROM '.$conf_centreon['db'].'.mui_opts WHERE mui_opts.opt_type = "Module_IsActive" AND mui_opts.opt_label = "'.$matches[3].'"');
							$obj_opts = mysql_fetch_object ($query_opts);
							if ($obj_opts->opt_val == 1)
								{
								echo "<li>";
								echo '<a href="plugins/';
								echo $val;
								echo '">';
								echo '<div>';
								echo $matches[3];
								echo '</div>';
								echo "</a>";
								echo "</li>";
								}
							}
					?>
					<li>
						<a href="enginestats.php">
							<div><?php  echo _("Poller statistics")?></div>
						</a>
					</li>
				</ul>
			</h4>
			
			<h6>
			<p align="center">
				<a href="../../../main.php" rel="external"><?php  echo _("Desktop version")?></a>
			</p>
			</h6>
		</div>
	</div>
</body>
</html>