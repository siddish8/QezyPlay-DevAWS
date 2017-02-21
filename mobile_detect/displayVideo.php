<?php

function displayVideo($a,$b,$c,$d,$e,$f,$g,$h,$i,$j,$k,$l,$m,$n,$o,$p,$q,$r,$s,$t){

	if(!is_user_logged_in()){
		header('Location:../');
	}

	require_once ABSPATH.'/mobile_detect/more_detection.php'; //LIVE
	//require_once $_SERVER['DOCUMENT_ROOT'].'/newqezyplay/mobile_detect/more_detection.php'; //DEMO


	$vidurl=$a;
	$imgurl=$b;
	$session_id=$c;
	$post_id=$d;
	$ip_address=$e;
	$ua=$f;

	$os_name=getOS($ua);
	$browser_array=getBrowser($ua);
	$browser_name=$browser_array[0];
	$browser_version=$browser_array[1];

	$page_referer=$g;
	$post_title=$h;
	$post_name=$i;
	$page_url=$j;

	$country_code=$k;
	$country_name=$l;
	$state=$m;
	$city=$n;
	$geoinfo_status=$o;
	$octo_js=$p;

	$vodurl=$q;
	$short_vodurl=$r;

	$vod_js=$s;
	$short_vod_js=$t;


	global $wpdb;
	global $current_user;	
	get_currentuserinfo();
	$user_id = get_current_user_id();
	$user_name = $current_user->user_login;

	$app_analytics_update_duration = get_option('app_analytics_update_duration');
	$app_force_update_status = get_option('app_force_update_status');
	$app_shutdown_wait_timeout = get_option('app_shutdown_wait_timeout');
	$app_android_version = get_option('app_android_version');
	$app_ios_version = get_option('app_ios_version');
	
	echo '<style>#player{display:block !important;}</style>';
	
//mem_id from wp pmpro users


	require_once ABSPATH.'/mobile_detect/Mobile_Detect.php'; //LIVE
	require_once ABSPATH.'/mobile_detect/secure_token.php'; //LIVE
	$detect = new Mobile_DetectNew;


$boqs=$wpdb->get_results("select term_taxonomy_id FROM wp_term_relationships where object_id=".$post_id." ");
$free_boq=0;
foreach($boqs as $boq)
{
//echo $boq->term_taxonomy_id;
if($boq->term_taxonomy_id==6)
$free_boq+=1;
}


$access_token=qezy_enc($user_id,$user_name,$post_id,$post_title,$post_name,$page_url,$page_referer,$os_name,$browser_name,$browser_version,$vidurl,$imgurl,$session_id,$ip_address,$country_code,$country_name,$state,$city,$geoinfo_status,$app_analytics_update_duration,$app_android_version,$app_ios_version,$app_force_update_status,$app_shutdown_wait_timeout);

$subAgent = $wpdb->get_var("SELECT plan_id FROM agent_vs_subscription_credit_info WHERE subscriber_id =  ".$user_id. " ORDER BY id DESC LIMIT 1
");
$enddateAgent = $wpdb->get_var("SELECT subscription_end_on FROM agent_vs_subscription_credit_info WHERE subscriber_id =  ".$user_id. " ORDER BY id DESC LIMIT 1");
//echo "<script>console.log('endDateAgent:".$enddateAgent."')</script>";
$dateNow = new DateTime("now");
$dateNow=$dateNow->format("Y-m-d");
$dateNow = new DateTime($dateNow);

$enddateAgent=new DateTime($enddateAgent);
$enddateAgent=$enddateAgent->format("Y-m-d");
$enddateAgent = new DateTime($enddateAgent);

	echo '<style>#player{display:block !important;}</style>';
	
//mem_id from wp pmpro users

//$sub_status = $wpdb->get_var("SELECT status FROM wp_pmpro_memberships_users WHERE user_id =  ".$user_id. " order by id desc limit 1");
$subStatus = $wpdb->get_var("SELECT count(user_id) FROM wp_pmpro_memberships_users WHERE user_id =  ".$user_id. " and status='active' ORDER BY id DESC LIMIT 1");

$validity=($enddateAgent >= $dateNow)?1:0;
$validity2=($enddateAgent >= $dateNow)?1:0;

//echo "<script>console.log('val1:".$validity1."')</script>";
//echo "<script>console.log('val:".$validity."')</script>";
//echo "<script>console.log('Direct Sub-status:".$sub_status."')</script>";

if( (int)$subAgent>0 and $validity==1)
{
//echo "<script>console.log('Payment through Agent Portal')</script>";
}

$user_access= $wpdb->get_var("SELECT user_id FROM user_video_accesslist WHERE user_id =  ".$user_id." ");
$user_access=(int)$user_access;

//if(  ( (int)$sub>0 and $validity1==1) or ( (int)$subAgent>0 and $validity2==1)  or ($user_id==4) ) 
if(  ( $subStatus==1 or ((int)$subAgent>0 and $validity2==1)) or $user_access or $free_boq!=0) {
//echo "<script>console.log('Subscribed.. Can watch')</script>";
update_option("subscribed_".$user_id,"true");
//echo "<script>console.log('subscribed_".$user_id.":".get_option("subscribed_".$user_id,"")."')</script>";
	//if(is_user_logged_in()){

		if($detect->isMobile()){

			$app_analytics_update_duration = get_option('app_analytics_update_duration');
			$app_force_update_status = get_option('app_force_update_status');
			$app_shutdown_wait_timeout = get_option('app_shutdown_wait_timeout');

			if($detect->isiOS())
				$device = "ios";
		 
			if($detect->isAndroidOS())
				$device = "android";
		
		 	
			if($detect->isAndroidOS()){
					//Android

				if($_SERVER['HTTP_X_REQUESTED_WITH'] == "com.ib.qezyplay"){ 
					//echo '<script>swal("isAndroidApp=true")</script>';
				 	$app=1; 
				}else{
					//echo '<script>swal("isAndroidApp=false")</script>'; 
					$app=0;
				}

				
				$app_android_version = get_option('app_android_version');
				

			  	echo '<script>	

					function playinAndroidApp(intent){					
							var app = "'.$app.'";					
							var intent = intent;
							var octourl="'.$vidurl.'";
							var aav = "'.$app_android_version.'";
							var aaud = "'.$app_analytics_update_duration.'";
							var afus = "'.$app_force_update_status.'";
							var aswt = "'.$app_shutdown_wait_timeout.'";
									
						if(app == 1){
							Android.playVideo(octourl,aaud,aav,afus,aswt);
						}else{
								swal({
									title: "Free App is availbale in stores",
									text: "Enjoy your player! Clickon Open if Qezyplay app is installed, Clickon Install if qezyplayapp is not installed.",
									type: "warning",
									html : true,
									showCancelButton: true,
									confirmButtonColor: "#DD6B55",
									confirmButtonText: "Open App",
									cancelButtonText: "Install App",
									closeOnConfirm: true,
									closeOnCancel: true
									},
									function(isConfirm){
									if (isConfirm) {

										var myWindow = window.open(intent,"_blank");
										
									} else {

										var myWindow = window.open(intent,"_blank");
										
									}
									});					
							/*var myWindow = window.open(intent,"_blank");*/
						}
					}			
				
					</script>';
				echo '<div align="center" id="player_img" style="background-image:url('.$imgurl.') !important;background-size: 100% 100% !important;width:650px;height:360px;background-color: white !important;border-color: black ;color: Orange;" align="center"><img id="chan_img" src="'.site_url().'/wp-content/uploads/2016/06/PlayImg.png" onclick="playinAndroidApp(\'intent:#Intent;action=com.ideabytes.qezyplay.LAUNCH_PLAYER;S.page_id='.$post_id.';S.post_title='.$post_title.';S.post_name='.$post_name.';S.user_id='.$user_id.';S.user_name='.$user_name.';S.page_url='.$page_url.';S.page_referer='.$page_referer.';S.browser_name='.$browser_name.';S.browser_version='.$browser_version.';S.session_id='.$session_id.';S.country_code='.$country_code.';S.country='.$country_name.';S.state='.$state.';S.city='.$city.';S.geo_info_status='.$geoinfo_status.';S.imgpath='.$imgurl.';S.octo_url='.$vidurl.';S.app_analytics_update_duration='.$app_analytics_update_duration.';S.app_android_version='.$app_android_version.';S.app_force_update_status='.$app_force_update_status.';S.app_shutdown_wait_timeout='.$app_shutdown_wait_timeout.';package=com.ib.qezyplay;end\')"></img><div><script>var app = "'.$app.'";	if(app == 1){jQuery("#chan_img").click();}</script>';
				//echo '<div align="center" id="player_img" style="background-image:url('.$imgurl.') !important;background-size: 100% 100% !important;width:650px;height:360px;background-color: white !important;border-color: black ;color: Orange;" align="center"><img src="'.site_url().'/wp-content/uploads/2016/06/PlayImg.png" onclick="playinAndroidApp(\'intent:#Intent;action=com.ideabytes.qezyplay.LAUNCH_PLAYER;S.user_id='.$user_id.';S.access_token='.$access_token.';package=com.ib.qezyplay;end\')"></img><div>';
						if($browser_name=="UCBrowser")
							{
							echo "<script>swal('Please switch to another Browser','This browser is not compatible to play channel');</script>";
							}
			}elseif($detect->isiOS()){

				//For ios code
				$app_ios_version = get_option('app_ios_version');
				
				echo '<script> 
					
					function playinIosApp(appstore){
							
								var app="qezyScheme://";
								app=appstore;

								swal({
									title: "Free App is availbale in stores",
									text: "Enjoy your player! Clickon Open if Qezyplay app is installed, Click on Install if qezyplayapp is not installed.",
									type: "warning",
									html : true,
									showCancelButton: true,
									confirmButtonColor: "#DD6B55",
									confirmButtonText: "Open App",
									cancelButtonText: "Install App",
									closeOnConfirm: true,
									closeOnCancel: true
									},
									function(isConfirm){
										
									if (isConfirm) {

										var myWindow = window.open(app,"_self");
										
									} else {

										var myWindow = window.open(appstore,"_self");
										
									}
									});
				}
				</script>';
				
	
				//echo '<div align="center" id="player_img" style="margin:0 auto;background-image:url('.$imgurl.') !important;background-size: 100% 100% !important;width:650px;height:360px;background-color: white !important;border-color: black ;color: Orange;" align="center"><img src="'.site_url().'/wp-content/uploads/2016/06/PlayImg.png" onclick="playinIosApp(\'iosQezyplayer://myapp?page_id='.$post_id.'&post_title='.$post_title.'&post_name='.$post_name.'&user_id='.$user_id.'&user_name='.$user_name.'&page_url='.$page_url.'&page_referer='.$page_referer.'&browser_name='.$browser_name.'&browser_version='.$browser_version.'&session_id='.$session_id.'&country_code='.$country_code.'&country='.$country_name.'&state='.$state.'&city='.$city.'&geo_info_status='.$geoinfo_status.'&imgpath='.$imgurl.'&octo_url='.$vidurl.'&app_analytics_update_duration='.$app_analytics_update_duration.'&app_ios_version='.$app_ios_version.'&app_force_update_status='.$app_force_update_status.'&app_shutdown_wait_timeout='.$app_shutdown_wait_timeout.'\')"></img><div>';

				echo '<div align="center" id="player_img" style="margin:0 auto;background-image:url('.$imgurl.') !important;background-size: 100% 100% !important;width:650px;height:360px;background-color: white !important;border-color: black ;color: Orange;" align="center"><img src="'.site_url().'/wp-content/uploads/2016/06/PlayImg.png" onclick="playinIosApp(\'https://appsto.re/us/Ug8_cb.i\')"></img><div>';
//onclick="playinIosApp(\'iosQezyplayer://myapp?user_id='.$user_id.'&access_token='.$access_token.'\')"
//onclick="swal(\'Sorry for Inconvenience\',\'  Currently we are not having the supporting player for IOS , Will be publised very soon.\')"
//Enjoy your player! Clickon Open if Qezyplay app is installed, Clickon Install if qezyplayapp is not installed
			}

		}else{		//Desktop
	
			echo '<script src="'.site_url().'/players/octoshape/swfobject.js" type="text/javascript"></script>
				<script src="'.site_url().'/players/octoshape/jquery-1.6.1.js" type="text/javascript"></script>
				<center><div id="player" ></div></center>';
?>

<script><?php echo str_replace("streamURL","streamVID",stripslashes($octo_js)) ?>;</script>
<script><?php echo str_replace("streamURL","streamVOD",stripslashes($vod_js)) ?>;
		if(typeof streamURL == "undefined"){

			//console.log("streamurl exists");
			//window.location.reload(true);
			
		}else{
			//console.log("no streamurl no");
			
		}
</script>

<?php
echo '<script src="'.site_url().'/players/octoshape/player.js" type="text/javascript"></script>';

/*$hf=get_user_meta($user_id,"hard_refresh",true);
echo '<script>console.log("hf:'.$hf.'")</script>';
if($hf==""){
	echo '<script>console.log("go for hf")</script>';
	update_user_meta($user_id,"hard_refresh",1);
	$hf2=get_user_meta($user_id,"hard_refresh",true);
	echo '<script>console.log("hf2:'.$hf2.'")</script>';
	echo '<script>location.reload(true)</script>';


}
else{
	
echo '<script>console.log("hf:'.$hf.'")</script>';
echo '<script>console.log("already hf done")</script>';
}
*/
?>
<script>
jQuery("#media_cont").append("&nbsp;<p style='text-align:center;font-size: 14px;  color: white;background-color: black;'>*Please press Ctrl+F5 if you are not able to view the player</p>");
var dplay=document.getElementById("player").display;
//console.log(dplay);
if(typeof dplay == "undefined"){

			//console.log("streamurl exists");
			//window.location.reload(true);
			
			
		}else{
			//console.log("no streamurl no");
			
		}

</script>
<script>
var id;
window.id=<?php echo $post_id; ?>;
	//console.log("win:"+window.id);
//document.getElementById("player").os_load("Qezy-TV-LIVE");

 jQuery( window ).load(function() { 

	var x,err;
	//window.x=2;
	window.err=2;

	
	//document.getElementById("player").os_load("Qezy-TV-LIVE");

	//function funcOnError(msg, code) {
        //console.log(msg + code);

	window.id=<?php echo $post_id; ?>;
	//console.log("win:"+window.id);
	/*setTimeout(function(){
	if(window.err==1){

	console.log(window.err+"ERR GO FOR FUCNS");
	setInactiveStatus();
	goforStatus();
	//console.log(window.err+"after FUCNS");
	}
	},
	2000
	);*/

	setTimeout(
	function(){checkStatus();},
	10000
	);

	function setInactiveStatus()
	{

	jQuery.ajax({
			    type: "POST",
			    url: "<?php echo site_url() ?>/qp1/uservalidation_check",
		
			    data: { "action" : "setStreamStatus","channel_id" : <?php echo $post_id ?> , "status" : 0},
		
			    success: function(response)
			    {

					//console.log(response+"deactivated");
				   }
			});

	}

	function goforStatus()
	{

	//console.log(window.x);
	
	jQuery.ajax({
			    type: "POST",
			    url: "<?php echo site_url() ?>/qp1/uservalidation_check",
		
			    data: { "action" : "getStreamStatus","channel_id" : <?php echo $post_id ?> },
		
			    success: function(response)
			    {
					var response=JSON.parse(response);
					response=response.status;
				//	window.x=resp.status;
				//console.log('win x:'+window.x);
				//console.log('resp:'+response);

				if(response==1 && window.x!=response)
				{

					swal({   title: " ",   text: "Playing LIVE <br> <img style='background-color:#ECE2AE !important;border: 1px solid #ECE2AE !important;border-radius:50%' src='../qp/images/live.gif' alt='Loading L I V E...' />",   html: true, timer: 4000,   showConfirmButton: false });
					document.getElementById("player").os_load("Qezy-TV-LIVE");

					//document.getElementById("ostat").innerHTML="1";
					window.x=1;
					
				}

				else if(response==0 && window.x!=response)
				{
					swal({   title: " ",   text: "Channel will be LIVE shortly. Till then Enjoy this VOD <br> <img style='background-color:#ECE2AE !important;border: 1px solid #ECE2AE !important;border-radius:50%' src='../qp/images/vod.gif' alt='Loading V O D...' />", html:true,  timer: 4000,   showConfirmButton: false });
					
					document.getElementById("player").os_load("Qezy-TV-VOD");

					//document.getElementById("ostat").innerHTML="0";
					window.x=0;
					
				

				}
				//$("#msgInHeader").empty().html(response);
			    }
			});

	}


	function checkStatus()
	{

		setInterval(function(){

		goforStatus();

		},20000);

	}

});


</script>
<?php
				
		}//DESKTOP_SUB

	}//SUBSCRIBED

	else{
		//not subscribed
		update_option("subscribed_".$user_id,"false");
		//echo "<script>console.log('subscribed_".$user_id.":".get_option("subscribed_".$user_id,"")."')</script>";

		if($detect->isAndroidOS()){
					//Android

				
				if($_SERVER['HTTP_X_REQUESTED_WITH'] == "com.ib.qezyplay"){ 
					//echo '<script>swal("isAndroidApp=true")</script>';

					
				 	$app=1; 
				}else{
					//echo '<script>swal("isAndroidApp=false")</script>'; 
					$app=0;
				}

				

				echo '<script>	
					
					
					playinAndroidApp(\'intent:#Intent;action=com.ideabytes.qezyplay.LAUNCH_PLAYER;S.page_id='.$post_id.';S.post_title='.$post_title.';S.post_name='.$post_name.';S.user_id='.$user_id.';S.user_name='.$user_name.';S.page_url='.$page_url.';S.page_referer='.$page_referer.';S.browser_name='.$browser_name.';S.browser_version='.$browser_version.';S.session_id='.$session_id.';S.country_code='.$country_code.';S.country='.$country_name.';S.state='.$state.';S.city='.$city.';S.geo_info_status='.$geoinfo_status.';S.imgpath='.$imgurl.';S.octo_url='.$vodurl.';S.app_analytics_update_duration='.$app_analytics_update_duration.';S.app_android_version='.$app_android_version.';S.app_force_update_status='.$app_force_update_status.';S.app_shutdown_wait_timeout='.$app_shutdown_wait_timeout.';package=com.ib.qezyplay;end\');
					

					function playinAndroidApp(intent){	
						
							var app = "'.$app.'";					
							var intent = intent;
							var octourl="'.$short_vodurl.'";
							var aav = "'.$app_android_version.'";
							var aaud = "'.$app_analytics_update_duration.'";
							var afus = "'.$app_force_update_status.'";
							var aswt = "'.$app_shutdown_wait_timeout.'";
									
						if(app == 1){ 
							Android.playVideo(octourl,aaud,aav,afus,aswt);
						}else{
													
							var myWindow = window.open(intent,"_blank");
						}

						
					}	

				setTimeout(function(){
							jQuery("#player").hide();
							jQuery("#media_cont").html("<div id=\'unreg_msg\' style=\'width:650px;height:360px;background-color: black !important;border-color: black;color: Orange;margin-top: -20px;\' align=\'center\'><h1 style=\'color: orangered;padding-top: 20%;font-size:25px;\'>Please subscribe to view this Channel LIVE <br> <a style=\'color:rgb(85, 213,208);font-size:25px;\' href=\'../subscription\'>Click here to Subscribe</a></h1></div>");

},3000);		
				
					</script>';	



			}
		elseif($detect->isiOS()){
			echo '<div id="unreg_msg" style="width:650px;height:360px;background-color: black !important;border-color: black;color: Orange;" align="center"><h1 style="
	    color: orangered;padding-top: 20%;font-size:25px;">Please subscribe with us to view this video. <br> <a style="color:rgb(85, 213, 208);;font-size:18px;" href="../subscription">Click here to Subscribe</a></h1></div>';
			}//ios_end
		else { //desktop
		//echo "<script>console.log('desktop free/unsub')</script>";
echo '
		<script src="'.site_url().'/players/octoshape/swfobject.js" type="text/javascript"></script>
		<script src="'.site_url().'/players/octoshape/jquery-1.6.1.js" type="text/javascript"></script>
		<center><div id="player" style="display:block"></div></center>
		<script type="text/javascript">// <![CDATA[
			'.stripslashes($short_vod_js).' // ]]></script> 
		<script src="'.site_url().'/players/octoshape/player1.js" type="text/javascript"></script>
		<script>

		var player_jsbridge = {

     				playerevents: {
				 onPlayerReady: "funcOnPlayerReady",
       				onStop: "funcOnStop",
          				onPause: "funcOnPause",
        				  onPlay: "funcOnPlay",
					onError:"funcOnError"
    						},
    				cuepoints: {
				          onMetaData: "funcOnMetaData"
     						}
					};

				function funcOnStop()
					{
						setTimeout(function(){
							jQuery("#player").hide();
							jQuery("#media_cont").html("<div id=\'unreg_msg\' style=\'width:650px;height:360px;background-color: black !important;border-color: black;color: Orange;margin-top: -20px;\' align=\'center\'><h1 style=\'color: orangered;padding-top: 20%;font-size:25px;\'>Please subscribe to view this Channel LIVE <br> <a style=\'color:rgb(85, 213,208);font-size:25px;\' href=\'../subscription\'>Click here to Subscribe</a></h1></div>");

},2000);
}

</script>';
		}//desktop

	}//not_subscribed	
	echo '
  <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
  <script src="'.site_url().'/qp/slick-1.6.0/slick/slick.js" type="text/javascript" charset="utf-8"></script>
  <script type="text/javascript">
    $(document).on("ready", function() {
      $(".regular").slick({
        dots: true,
        infinite: true,
        slidesToShow: 5,
        slidesToScroll: 3
      });
      
      $(".variable").slick({
        dots: true,
        infinite: true,
        variableWidth: true
      });
    });
  </script>
';
}//function dispvideo
?>
