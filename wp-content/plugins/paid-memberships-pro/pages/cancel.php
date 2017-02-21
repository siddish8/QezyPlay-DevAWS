<?php 
	global $pmpro_msg, $pmpro_msgt, $pmpro_confirm, $current_user;

	if ((strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile/') !== false) && (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari/') == false))
	{
	$ios=1;
	}

	if($_SERVER['HTTP_X_REQUESTED_WITH'] == "com.ideabytes.qezyplay.qezyplay_new")
	{
	$android=1;
	}

	if ((strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile/') !== false) && (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari/') == false) or ($_SERVER['HTTP_X_REQUESTED_WITH'] == "com.ideabytes.qezyplay.qezyplay_new") or $_SESSION['app']==1) {	
	echo "<style>header, #bottom-nav_1, footer, .blog-heading {display:none;}</style>";
	$player_url="intent:#Intent;action=com.ideabytes.qezyplay.qezyplay_new;end";
	$myaccount_url="intent:#Intent;action=com.ideabytes.qezyplay.qezyplay_new;end";
	$app=1;
   	}
	else{
 	$player_url="../#bangla";
	$myaccount_url=pmpro_url("account"); 
	$app=0;}

	
	if(isset($_REQUEST['level']))
		$level = $_REQUEST['level'];
	else
		$level = false;
?>
<div align="center" id="pmpro_cancel" style="font-size: 18px;
margin: 30px auto;
width: 50%;
background-color: #ECE2AE ;
border: 4px solid #dba922;
padding: 20px;
border-radius: 5px;">		
	<?php
		if($pmpro_msg) 
		{
			?>
			<div class="pmpro_message <?php echo $pmpro_msgt?>"><?php echo $pmpro_msg?></div>
			<?php
		}
	?>
	<?php 
		if(!$pmpro_confirm) 
		{ 
			if($level)
			{
				if($level == "all")
				{
					?>
					<p><?php _e('Are you sure you want to cancel your subscription?', 'pmpro'); ?></p>
					<?php
				}
				else
				{
					?>
					<p><?php printf(__('Are you sure you want to cancel your %s subscription?', 'pmpro'), $current_user->membership_level->name); ?></p>
					<?php
				}
			?>			
			<div class="pmpro_actionlinks ">
				<a style="width: 90px; background-color: #C1C1C1;font-size: 17px; font-weight: 500;border-radius: 5px;
    padding: 10px 32px;margin: 15px 5px 0 5px;cursor: pointer;height: 35px; line-height: 1;text-align:center;" class="pmpro_btn pmpro_yeslink yeslink" href="<?php echo pmpro_url("cancel", "?confirm=true")?>"><?php _e('Yes', 'pmpro');?></a>
			<?php if($app==0){ ?>

					<a style="width: 90px; background-color: rgb(140, 212, 245);font-size: 17px;font-weight: 500;border-radius: 5px;
    padding: 10px 32px;margin: 15px 5px 0 5px;cursor: pointer;height: 35px; line-height: 1;align:center;" class="pmpro_btn pmpro_cancel pmpro_nolink nolink" href="<?php echo pmpro_url("account")?>"><?php _e('No', 'pmpro');?></a>

			<?php } if($app==1){ ?>
			
				<a style="width: 90px; background-color: rgb(140, 212, 245);font-size: 17px;font-weight: 500;border-radius: 5px;
    padding: 10px 32px;margin: 15px 5px 0 5px;cursor: pointer;height: 35px; line-height: 1;align:center;" class="pmpro_btn pmpro_cancel pmpro_nolink nolink" href="<?php echo site_url()?>/m-subscription-account/?user_id=<?php echo $_SESSION['uid']?>&user_name=<?php echo $_SESSION['uname'] ?>"><?php _e('No', 'pmpro');?></a>
			
			<?php } ?>
			</div>
			<?php
			}
			else
			{
				if($current_user->membership_level->ID) 
				{ 
					?>
					<hr />
					<h3><?php _e("My Subscriptions", "pmpro");?></h3>
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<thead>
							<tr>
								<th><?php _e("Plan", "pmpro");?></th>
								<th><?php _e("Expiration", "pmpro"); ?></th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="pmpro_cancel-membership-levelname">
									<?php echo $current_user->membership_level->name?>
								</td>
								<td class="pmpro_cancel-membership-expiration">
								<?php 
									if($current_user->membership_level->enddate) 
										echo date_i18n(get_option('date_format'), $current_user->membership_level->enddate);
									else
										echo "---";
								?>
								</td>
								<td class="pmpro_cancel-membership-cancel">
									<a href="<?php echo pmpro_url("cancel", "?level=" . $current_user->membership_level->id)?>"><?php _e("Cancel", "pmpro");?></a>
								</td>
							</tr>
						</tbody>
					</table>				
					<div class="pmpro_actionlinks">
						<!-- <a href="<?php echo pmpro_url("cancel", "?level=all"); ?>"><?php _e("Cancel All Subscriptions", "pmpro");?></a> -->
					</div>
					<?php
				}
			}
		}
		else 
		{ 
			?> 
			<!-- <p><a href="<?php echo get_home_url()?>"><?php _e('Click here to go to the home page.', 'pmpro');?></a></p> -->
			<?php 
		} 
	?>		
</div> <!-- end pmpro_cancel -->
