<?php

global $wpdb, $current_user, $pmpro_msg, $pmpro_msgt;

if($_GET['user_id']!="")
{
$user_id=$_GET['user_id'];
$_SESSION['uid']=$user_id;
$loginusername=$_GET['user_name'];
$_SESSION['uname']=$loginusername;
$_SESSION['app']=1;

wp_set_current_user($user_id, $loginusername); 
			wp_set_auth_cookie($user_id); 
			do_action('wp_login', $loginusername);

            global $wpdb, $current_user, $pmpro_msg, $pmpro_msgt;

           
}
/*
if($_SERVER['HTTP_X_REQUESTED_WITH'] == "com.ideabytes.qezyplay.qezyplay_new"){
//echo "http_req:".$_SERVER['HTTP_X_REQUESTED_WITH'];
//echo "Android app";
$_SESSION['app']=1;
}
else
{
//echo "http_req:".$_SERVER['HTTP_X_REQUESTED_WITH'];
//echo "diff ";
}

if($_SERVER['HTTP_X_REQUESTED_WITH']=="" && !((strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile/') !== false) && (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari/') == false)) )
{
//echo "android-not det";
$_SERVER['HTTP_X_REQUESTED_WITH'] = "com.ideabytes.qezyplay.qezyplay_new";

$_SESSION['app']=1;
}
//echo "http_req:".$_SERVER['HTTP_X_REQUESTED_WITH'];
global $wpdb;

//echo "get1:".$_GET['user_id'];
//echo "server1:".$_SESSION['uid'];
//echo "id1:".$user_id;

if($_GET['user_id']!="")
{
$user_id=$_GET['user_id'];
$_SESSION['uid']=$user_id;
$_SESSION['app']=1;
}
else
{
$user_id=$_SESSION['uid'];

$_SESSION['app']=1;
}

if($_GET['user_name']!="")
{
$loginusername=$_GET['user_name'];
$_SESSION['uname']=$loginusername;
$_SESSION['app']=1;
}
else
{
$loginusername=$_SESSION['uname'];
$_SESSION['app']=1;
}

//echo "get2:".$_GET['user_id'];
//echo "server2:".$_SESSION['uid'];
//echo "id2:".$user_id;
//echo $loginusername;

wp_set_current_user($user_id, $loginusername);
wp_set_auth_cookie($user_id);
do_action('wp_login', $loginusername);
*/

if($current_user->ID)
    $current_user->membership_level = pmpro_getMembershipLevelForUser($current_user->ID);

if (isset($_REQUEST['msg'])) {
    if ($_REQUEST['msg'] == 1) {
        $pmpro_msg = __('Your subscription status has been updated - Thank you!', 'pmpro');
    } else {
        $pmpro_msg = __('Sorry, your request could not be completed - please try again in a few moments.', 'pmpro');
        $pmpro_msgt = "pmpro_error";
    }
} else {
    $pmpro_msg = false;
}

//if no user, redirect to levels page
if (empty($current_user->ID)) {
    $redirect = apply_filters("pmpro_account_preheader_no_user_redirect", pmpro_url("levels"));
    if ($redirect) {
        wp_redirect($redirect);
        exit;
    }
}

//if no membership level, redirect to levels page
if (empty($current_user->membership_level->ID)) {
    $redirect = apply_filters("pmpro_account_preheader_redirect", pmpro_url("levels"));
    if ($redirect) {
        //wp_redirect($redirect);
get_header();

		global $current_user;
		global $wpdb;
		get_currentuserinfo();
		$this_user = get_current_user_id();
		$userCount = $wpdb->get_var("SELECT count(user_id) as count FROM wp_pmpro_memberships_users where user_id = ".$this_user); 

		$userCount1 = $wpdb->get_var("SELECT count(subscriber_id) as count FROM agent_vs_subscription_credit_info where subscriber_id = ".$this_user); 
		
		if($userCount > 0 || $userCount1 > 0)
		{

			//echo do_shortcode('[pmpro_account]');
			//echo "hi";

		}
		else
		{
			echo "<div id='body' style='height:100%;'><div align='center' style='font-size:18px;margin:20%'>No Subscriptions. <a  style='font-size:18px;color:blue !important' href='../subscription/'>Subscribe Here</a> </div></div>";
get_footer();
		exit;
		}
        
    }
}

global $pmpro_levels;
$pmpro_levels = pmpro_getAllLevels();
