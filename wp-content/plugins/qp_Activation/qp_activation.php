<?php 
    /*
    Plugin Name: Activation Page- 412 content
    Plugin URI: 
    Description: This displays the content section of Account activation Page- Popup
    Author: IB
    Version: 1.0
    Author URI: ib
    */

add_shortcode('qezy_activation','qezy_activation_page');

function qezy_activation_page(){
    global $current_user, $wpdb;	
	get_currentuserinfo();
	//$user_id = get_current_user_id();
    //echo $user_id;

    //$current_user = wp_get_current_user(); 
   // echo "ID:".$id=$current_user->ID; 
   // echo $_SERVER['PHP_SELF'];
   // echo $_GET['act_link'];
    $user_id=$id=$wpdb->get_var('SELECT user_id FROM wp_usermeta where meta_key="xoouser_ultra_very_key" and meta_value="'.$_GET['act_link'].'" ');
    $loginusername=$wpdb->get_var('SELECT user_login from wp_users where ID='.$id.' ');
    //$alreadyactivated=get_option("activation_".$id);  
    $alreadyactivated1=$wpdb->get_var('SELECT meta_value FROM wp_usermeta where meta_key="usersultra_account_status" and user_id='.$user_id.' ');
    $delay=$wpdb->get_var('SELECT delay from pmpro_dates_chk1 where user_id='.$user_id.' order by id desc limit 1');
    /*if($alreadyactivated1=="active"){
        $alreadyactivated=1;

    }elseif($alreadyactivated1=="pending"){

         $alreadyactivated=0;

    }*/
   $activated=(int)get_option("activation_".$id); 
 
   if($activated==1){
        $alreadyactivated=1;

    }elseif($activated==0){

         $alreadyactivated=0;

    }

   
    wp_set_current_user($user_id, $loginusername); 
    wp_set_auth_cookie($user_id); 
    do_action('wp_login', $loginusername);

    $message="<p style=\'float:left\'>Dear $loginusername</p><p>You have successfully registered with Qezy®Play.<br>You have $delay days access to our Premium Bengali content which include Tara TV, Boishakhi .....</p><p>We hope you enjoy experience and select a low cost subscription plan.</p><p style=\'float:left\'>Qezy®Play team</p>";

    echo "<style>.sweet-alert p{text-align:left !important}</style>";
               
                
    if($alreadyactivated!=1) {
       
         
      update_option("activation_".$id,1);

                   
        echo "<script>
                    swal({
                    title: 'Account Activated',
                    text: '".$message."<a href=\"".site_url()."\" ><button style=\"height: 8px; width: 10px; padding: 6px 0px; position: absolute; top: -55px; right: -20px; background: none !important; background-color: black !important; border-radius: 0px !important; text-align: center; font-size: 14px; border: none !important;\" type=\'button\'>x</button></a>',
                    type: 'warning',
                    html: 'true',
                    showCancelButton: false,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: 'OK',
                    closeOnConfirm: true,
                    allowEscapeKey:false
                    },
                    function(){
                    window.location.href=\"".site_url('tara-tv')."\"; 
                    });
</script>"; } 
else { 
      
          
      echo "<script>
                    swal({
                    title: 'Account Already Activated',
                    text: 'Enjoy Viewing.<a href=\"".site_url()."\" ><button style=\"height: 8px; width: 10px; padding: 6px 0px; position: absolute; top: -55px; right: -20px; background: none !important; background-color: black !important; border-radius: 0px !important; text-align: center; font-size: 14px; border: none !important;\" type=\'button\'>x</button></a>',
                    type: 'warning',
                    html: 'true',
                    showCancelButton: false,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: 'OK',
                    closeOnConfirm: true,
                    allowEscapeKey:false
                    },
                    function(){
                    window.location.href=\"".site_url('tara-tv')."\"; 
                    });
</script>"; } 
}
?>
<?php
