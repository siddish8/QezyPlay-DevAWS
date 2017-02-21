<?php
	global $besecure;
	$besecure = false;

	if ((strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile/') !== false) && (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari/') == false))
	{
	$ios=1;
	}

	if($_SERVER['HTTP_X_REQUESTED_WITH'] == "com.ideabytes.qezyplay.qezyplay_new")
	{
	$android=1;
	$myaccount_url="intent:#Intent;action=com.ideabytes.qezyplay.qezyplay_new;end";
	}

	if ((strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile/') !== false) && (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari/') == false) or ($_SERVER['HTTP_X_REQUESTED_WITH'] == "com.ideabytes.qezyplay.qezyplay_new") or $_SESSION['app']==1) {	
	echo "<style>header, #bottom-nav_1, footer, .blog-heading {display:none;}</style>";
	//$player_url="intent:#Intent;action=com.ib.qezyplay;end";
	
	$app=1;
   	}
	else{
 	//$player_url="../#bangla";
	$myaccount_url=pmpro_url("account"); 
	$app=0;
	}


	global $current_user, $pmpro_msg, $pmpro_msgt, $pmpro_confirm, $pmpro_error;

	date_default_timezone_set("UTC");

	//get level information for current user
	if($current_user->ID)
		$current_user->membership_level = pmpro_getMembershipLevelForUser($current_user->ID);

	//if no user or membership level, redirect to levels page
	if(!isset($current_user->membership_level->ID)) {
		wp_redirect(pmpro_url("levels"));
		exit;
	}

		//are we confirming a cancellation?
	if(isset($_REQUEST['confirm']))
		$pmpro_confirm = $_REQUEST['confirm'];
	else
		$pmpro_confirm = false;

	if($pmpro_confirm) {
		$old_level_id = $current_user->membership_level->id;
		
        $worked = pmpro_changeMembershipLevel(false, $current_user->ID, 'cancelled');

		
			//added
			//echo "alert('::::Note down the data from alerts:::::');";
			$txt="";
			global $wpdb;
			//$planstartdate=$wpdb->get_var("select plan_start_date from sub_support where user_id=".$current_user->ID." order by id desc limit 1 ");
			//$nextpaydate=$wpdb->get_var("select next_pay_date from sub_support where user_id=".$current_user->ID." order by id desc limit 1 ");

				$planstartdate=$wpdb->get_var("select plan_startdate from pmpro_dates_chk1 where user_id=".$current_user->ID." order by id desc limit 1 ");
				$nextpaydate=$wpdb->get_var("select next_paydate from pmpro_dates_chk1 where user_id=".$current_user->ID." order by id desc limit 1 ");
				
				$today=new DateTime("now");
				$today=$today->format("Y-m-d");
				$today=new DateTime($today);
				$planstartdate=new DateTime($planstartdate);
			
				if($planstartdate > $today )
				{
					$enddate=$planstartdate->format("Y-m-d");
				}
				else
				{
					$enddate=$nextpaydate;
				}

			$txt.=$enddate;

			//added
			echo "<script>console.log('enddate 1'+'".$enddate."')</script>";
			$ft_delay=get_user_meta($current_user->ID,'delay_from_free_trial',true);
			echo "<script>console.log('ft_delay before'+'".$ft_delay."')</script>";
			$enddate=date('Y-m-d', strtotime($enddate. ' '.$ft_delay.' days'));
			echo "<script>console.log('enddate 2'+'".$enddate."')</script>";

			update_user_meta($current_user->ID,'delay_from_free_trial',0);
			$ft_delay=get_user_meta($current_user->ID,'delay_from_free_trial',true);
			echo "<script>console.log('ft_delay after'+'".$ft_delay."')</script>";
		
			$enddateUpd=$enddate;

			$enddateUpd=date('Y-m-d', strtotime($enddateUpd. ' -1 days'));
			echo "<script>console.log('enddate 3final'+'".$enddateUpd."')</script>";
		
			$this_id=$wpdb->get_var("SELECT id FROM wp_pmpro_memberships_users where user_id=".$current_user->ID." order by id desc limit 1");
			$txt.=$this_id;
			//$updated=$wpdb->update("wp_pmpro_memberships_users",array(   "status" => "active",   "enddate"=>$enddateUpd), array("id"=>$this_id)); 
			
			$updated=$wpdb->query($wpdb->prepare("UPDATE wp_pmpro_memberships_users SET status=%s, enddate=%s WHERE id=%d",'active',$enddate,$this_id));

			//added for change of plan
				
				$today=new DateTime("now");
				$today=$today->format("Y-m-d");
				$today=new DateTime($today);

				$enddate=new DateTime($enddate);
				$enddate=$enddate->format("Y-m-d");
				$enddate=new DateTime($enddate);


				$temp = date_diff($today,$enddate);
				$delay=$temp->format('%R%a');

				if($delay < 0)
 					{$delay=0;}
				else
				{$delay=$temp->format('%a');}

				$subscription_delay=$delay;
				echo "<script>console.log('sub_delay'+'".$subscription_delay."')</script>";
				update_option("pmpro_sub_support_delay_" . $current_user->ID, $subscription_delay); //save new delay for this user on change of plan
					$chk=get_option('pmpro_sub_support_delay_' . $current_user->ID);
				echo "<script>console.log('upd_del:'+'".$chk."')</script>";


				$last_updatedate=new DateTime("now");
				$last_updatedate=$last_updatedate->format("Y-m-d");
				$next_paydate="0000-00-00 00:00:00";

				$this_chk_id=$wpdb->get_var("select id from pmpro_dates_chk1 where user_id=".$current_user->ID." order by id desc limit 1 ");
				echo "<script>console.log('nxt pay:'+'".$next_paydate."')</script>";

				echo "<script>console.log('insertion_col_id from chk:'+'".$this_chk_id."')</script>";

		

				$wpdb->update("pmpro_dates_chk1", array(
				"next_paydate" => $next_paydate,
					"delay"=> $subscription_delay,
				"record_updateddate"=>$last_updatedate),array("id"=>$this_chk_id)); 


 						
			//ended			

			$user_id=$current_user->ID;
			$user_name=$wpdb->get_var("SELECT user_login from wp_users where ID=".$user_id."");


        if($worked === true && empty($pmpro_error))
		{
			
			if($app==0){
				$pmpro_msg = __("Your subscription has been cancelled. <br> <a href='".pmpro_url("account")."'><button>OK</button></a>", 'pmpro');
			}elseif($app==1){
				$pmpro_msg = __("Your subscription has been cancelled. <br> <a href='".site_url()."/m-subscription-account/?user_id=".$user_id."&user_name=".$user_name."'><button>OK</button></a>", 'pmpro');
				
			}
			
			$pmpro_msgt = "pmpro_success";

			//send an email to the member
			$myemail = new PMProEmail();
			$myemail->sendCancelEmail();

			//send an email to the admin
			$myemail = new PMProEmail();
			$myemail->sendCancelAdminEmail($current_user, $old_level_id);
			

			

		} else {
			global $pmpro_error;
			$pmpro_msg = $pmpro_error;
			$pmpro_msgt = "pmpro_error";
		}
	}
	?>
	<script>
	function myaccount_url()
{

<?php if($app==1) { ?>

<?php if($android==1) { ?>

var x="sub";
Android.SubToast(x);
return;
<?php } ?>
<?php if($ios==1) { ?>


var x="sub";
var myAppName = 'myfakeappname';
var myActionType = 'myJavascriptActionType2';
var myActionParameters = {"redirect_url":"sub"}; // put extra info into a dict if you need it

// (separating the actionType from parameters makes it easier to parse in ObjC.)
var jsonString = (JSON.stringify(myActionParameters));
var escapedJsonParameters = escape(jsonString);
var url = myAppName + '://' + myActionType + "#" + escapedJsonParameters;
//alert(url);
document.location.href = url;
// window.location.href  = 'ios:webToNativeCall';

return;
<?php } ?>

<?php } else { ?>

window.location.href="<?php echo $myaccount_url ?>";
return;
<?php } ?>

}
	</script>