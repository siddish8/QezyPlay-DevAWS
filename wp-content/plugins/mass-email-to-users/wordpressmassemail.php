<?php
  /* 
    Plugin Name: WordPress Mass Email to users
    Plugin URI:http://www.i13websolution.com/wordpress-bulk-email-pro-plugin.html
    Description:Plugin for send mass email to registered users
    Author:I Thirteen Web Solution
    Version:1.0
    Author URI:http://www.i13websolution.com/wordpress-bulk-email-pro-plugin.html
*/  
 
//error_reporting(0);
//add_action( 'admin_init', 'massemail_plugin_admin_init' );
set_time_limit(5000);

add_action('admin_menu',    'massemail_plugin_menu');  
 
  function massemail_plugin_menu(){
  
    $hook_suffix_mass_email_p=add_menu_page(__('Mass Email'), __("Mass Email"), 'administrator', 'Mass-Email','massEmail_func');
    add_action( 'load-' . $hook_suffix_mass_email_p , 'massemail_plugin_admin_init' );
  }

 
  function massemail_plugin_admin_init(){
  	 
  	$url = plugin_dir_url(__FILE__);
  	wp_enqueue_script('jquery');
  	wp_enqueue_script( 'jqueryValidate', $url.'js/jqueryValidate.js' );
  
  }
 
 function massEmail_func(){
   
 $selfpage=$_SERVER['PHP_SELF']; 
   
 $action='';
 if(isset($_REQUEST['action'])){
    $action=$_REQUEST['action'];
 } 
?> 
<!-- <table><tr><td><a href="https://twitter.com/FreeAdsPost" class="twitter-follow-button" data-show-count="false" data-size="large" data-show-screen-name="false">Follow @FreeAdsPost</a>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></td>
        <td>
        <a target="_blank" title="Donate" href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=nvgandhi123@gmail.com&item_name=Wp%20Mass%20email&item_number=mass%20email%20support&no_shipping=0&no_note=1&tax=0&currency_code=USD&lc=US&bn=PP%2dDonationsBF&charset=UTF%2d8">
        <img id="help us for free plugin" height="30" width="90" src="<?php echo plugins_url( 'images/paypaldonate.jpg', __FILE__ );?>" border="0" alt="help us for free plugin" title="help us for free plugin">
        </a>
        </td>
        </tr>
        </table>
<h3 style="color: blue;"><a target="_blank" href="http://www.i13websolution.com/wordpress-pro-plugins/wordpress-bulk-email-pro-plugin.html">Upgrade to WordPress Mass Email Pro</a></h3>-->
<?php         
 
 switch($action){
  
  case 'sendEmailSend':
  
    $retrieved_nonce = '';

    if(isset($_POST['mass_email_nonce']) and $_POST['mass_email_nonce']!=''){

        $retrieved_nonce=$_POST['mass_email_nonce'];

    }
    if (!wp_verify_nonce($retrieved_nonce, 'action_mass_email_nonce' ) ){


        wp_die('Security check fail'); 
    }  
    
    $emailTo= preg_replace('/\s\s+/', ' ', $_POST['emailTo']);
    $toSendEmail=explode(",",$emailTo);
    $flag=false;
    foreach($toSendEmail as $key=>$val){
        
        $val=trim($val);
        
        $subject=$_POST['email_subject'];
        $from_name=$_POST['email_From_name'];
        $from_email=$_POST['email_From'];
        $emailBody=$_POST['txtArea'];
        
        $userInfo=get_user_by('email',$val);
        $usernamerep="";
        if(is_object($userInfo)){
          $uerIdunsbs=base64_encode($userInfo->ID);
          $usernamerep=$userInfo->user_login;
        }
        $emailBody=stripslashes($emailBody);
        
        $emailBody=str_replace('[username]',$usernamerep,$emailBody); 
        
        $mailheaders='';
        $mailheaders .= "X-Priority: 1\n";
        $mailheaders .= "Content-Type: text/html; charset=\"UTF-8\"\n";
        $mailheaders .= "From: $from_name <$from_email>" . "\r\n";
        //$mailheaders .= "Bcc: $emailTo" . "\r\n";
$fromsupport = 'admin@qezyplay.com';
$mailheaders .= "Return-receipt-To: $fromsupport\r\n";
$mailheaders .= "X-Confirm-Reading-To: $fromsupport\r\n";
 //$mailheaders .= "X-Confirm-Return-To: $fromsupport\r\n";
$mailheaders .= "Disposition-Notification-To: $fromsupport\r\n";
        $message='<html><head></head><body>'.$emailBody.'</body></html>';
         
        $Rreturns=wp_mail($val, $subject, $message, $mailheaders);
        if($Rreturns)
           $flag=true;
        
    }  
     $adminUrl=get_admin_url();
     if($flag){
     
        update_option( 'mass_email_succ', 'Email sent successfully.' );
         if(isset($_POST['setPerPage']) and (int)$_POST['setPerPage']>0){
               
                $setPerPage=$_POST['setPerPage'];
           }else{
               
                $setPerPage=30;
           }
          
         if(isset($_POST['entrant']) and (int)$_POST['entrant']>0){
               
                $entrant=$_POST['entrant'];
           }else{
               
                $entrant=1;
           }
          
    
        
        echo "<script>location.href='". $adminUrl."admin.php?page=Mass-Email&entrant=$entrant&setPerPage=$setPerPage"."';</script>"; 
        exit;
     
     }
    else{
        
           
           if(isset($_POST['setPerPage']) and (int)$_POST['setPerPage']>0){
               
                $setPerPage=$_POST['setPerPage'];
           }else{
               
                $setPerPage=30;
           }
          if(isset($_POST['entrant']) and (int)$_POST['entrant']>0){
               
                $entrant=$_POST['entrant'];
           }else{
               
                $entrant=1;
           }
       
           update_option( 'mass_email_err', 'Unable to send email to users.' );
           echo "<script>location.href='". $adminUrl."admin.php?page=Mass-Email&entrant=$entrant&setPerPage=$setPerPage"."';</script>";
           exit;
    } 
   break;
       
  case 'sendEmailForm' :
   
   $retrieved_nonce = '';

    if(isset($_POST['mass_email_nonce']) and $_POST['mass_email_nonce']!=''){

        $retrieved_nonce=$_POST['mass_email_nonce'];

    }
    if (!wp_verify_nonce($retrieved_nonce, 'action_mass_email_nonce' ) ){


        wp_die('Security check fail'); 
    } 
    
   $lastaccessto=$_SERVER['QUERY_STRING'];
   parse_str($lastaccessto);
   
   $subscribersSelectedEmails=$_POST['ckboxs'];
   $convertToString=implode(",\n",$subscribersSelectedEmails); 
   
   if(!isset($entrant)){
       $entrant=1;
   }
   
   if(!isset($setPerPage)){
       $setPerPage=30;
   }
   
 ?>    
<h3>Send Email to Users</h3>  
<?php  $url = plugin_dir_url(__FILE__);
       $urlCss=$url."styles.css";
 ?>
 <div style="width: 100%;">  
 <div style="float:left;width:100%;" >
 <link rel='stylesheet' href='<?php echo $urlCss; ?>' type='text/css' media='all' />

<form name="frmSendEmailsToUserSend" id='frmSendEmailsToUserSend' method="post" action=""> 
<?php wp_nonce_field('action_mass_email_nonce','mass_email_nonce'); ?>    
<input type="hidden" value="sendEmailSend" name="action"> 
<input type="hidden" value="<?php echo $entrant; ?>" name="entrant"> 
<input type="hidden" value="<?php echo $setPerPage; ?>" name="setPerPage"> 
<table class="form-table" style="width:100%" >
<tbody>
  <tr valign="top" id="subject">
     <th scope="row" style="width:30%;text-align: right;">Subject *</th>
     <td>    
        <input type="text" id="email_subject" name="email_subject"  class="valid" size="70">
        <div style="clear: both;"></div><div></div>
      </td>
   </tr>
   <tr valign="top" id="subject">
     <th scope="row" style="width:30%;text-align: right">Email From Name*</th>
     <td>    
        <input type="text" id="email_From_name" name="email_From_name"  class="valid" size="70">
         <br/>(ex. admin)  
        <div style="clear: both;"></div><div></div>
       
      </td>
   </tr>
   <tr valign="top" id="subject">
     <th scope="row" style="width:30%;text-align: right">Email From *</th>
     <td>    
        <input type="text" id="email_From" name="email_From"  class="valid" size="70">
        <br/>(ex. admin@yoursite.com) 
        <div style="clear: both;"></div><div></div>
  
      </td>
   </tr>
   <tr valign="top" id="subject">
     <th scope="row" style="width:30%;text-align: right">Email To *</th>
     <td>    
        <textarea id='emailTo'  readonly="readonly"  name="emailTo" cols="58" rows="4"><?php echo $convertToString;?></textarea>
        <div style="clear: both;"></div><div></div>
      </td>
   </tr>
   <tr valign="top" id="subject">
     <th scope="row" style="width:30%;text-align: right">Email Body *</th>
     <td>    
       <div class="wrap">
       <textarea id="txtArea"  name="txtArea" class="ckeditor" cols="100" rows="10"></textarea>
       <div style="clear: both;"></div><div></div>                       
       </div>
        <input type="hidden" name="editor_val" id="editor_val" />  
        <div style="clear: both;"></div><div></div> 
        <b>you can use [username] place holder into email content</b>   
      </td>
   </tr>
   <tr valign="top" id="subject">
     <th scope="row" style="width:30%"></th>
     <td> 
       
       <?php wp_nonce_field('action_mass_email_nonce','mass_email_nonce'); ?>  
       <input type='submit'  value='Send Email' name='sendEmailsend' class='button-primary' id='sendEmailsend' >  
      </td>
   </tr>
   
</table>

<script type="text/javascript">


 jQuery(document).ready(function() {

 jQuery.validator.addMethod("chkCont", function(value, element) {
                      
        
         var editorcontent = CKEDITOR.instances['txtArea'].getData().replace(/<[^>]*>/gi, '');
        if (editorcontent.length){
          return true;
        }
        else{
           return false;
        }
     
                                    
   },
        "Please enter email content"
);

   jQuery("#frmSendEmailsToUserSend").validate({
                    errorClass: "error_admin_massemail",
                    rules: {
                                 email_subject: { 
                                        required: true
                                  },
                                  email_From_name: { 
                                        required: true
                                  },  
                                  email_From: { 
                                        required: true ,email:true
                                  }, 
                                  emailTo:{
                                      
                                     required: true 
                                  },
                                 txtArea:{
                                    required: true 
                                 }  
                            
                       }, 
      
                            errorPlacement: function(error, element) {
                            error.appendTo( element.next().next());
                      }
                      
                 });
                      

  });
 
 </script> 
 </div>
 
</div>           
 <?php 
  break;
  default: 
         $url=plugin_dir_url(__FILE__);
         $urlCss=$url."styles.css";
  ?>
  <div style="width: 100%;">  
   <div style="float:left;width:65%;" >
      <div class="wrap">                                                                 
  <link rel='stylesheet' href='<?php echo $urlCss; ?>' type='text/css' media='all' />   
  
  <?php       
    global $wpdb;
    
    $rows_per_page = 30;
    if(isset($_GET['setPerPage']) and $_GET['setPerPage']!=""){
        
       $rows_per_page=$_GET['setPerPage'];
    } 
    
    $current = (isset($_GET['entrant'])) ? ($_GET['entrant']) : 1;
    $wpcurrentdir=dirname(__FILE__);
    $wpcurrentdir=str_replace("\\","/",$wpcurrentdir);
    
    
    $unscbscribersQuery="SELECT GROUP_CONCAT( user_id ) AS  `unsbscribers` 
                            FROM  $wpdb->usermeta 
                            WHERE  `meta_key` =  'is_unsubscibed' and meta_value='1'" ;
                                   
    $resultUnsb=$wpdb->get_results($unscbscribersQuery,'ARRAY_A');
    
    $unsubscriber_users=$resultUnsb[0]['unsbscribers'];
    
    if($unsubscriber_users=="" or $unsubscriber_users==null)
     $unsubscriber_users=0;
    
    
    $query="SELECT ID,user_email from $wpdb->users where ID NOT IN ($unsubscriber_users)";
    
    
    
    $emails=$wpdb->get_results($query,'ARRAY_A');
    $totalRecordForQuery=sizeof($emails);
    $selfPage=$_SERVER['PHP_SELF'].'?page=Mass-Email'; 
   
    $pagination_args = array(
        'base' => @add_query_arg('entrant','%#%'),
        'format' => '',
        'total' => ceil(sizeof($emails)/$rows_per_page),
        'current' => $current,
        'show_all' => false,
        'type' => 'plain',
    );
        
     $start = ($current - 1) * $rows_per_page;
    $end = $start + $rows_per_page;
    $end = (sizeof($emails) < $end) ? sizeof($emails) : $end;
    
      $selfpage=$_SERVER['PHP_SELF'];
        
    if($totalRecordForQuery>0){
        
             
             
?>              
  <?php
                $SuccMsg=get_option('mass_email_succ');
                update_option( 'mass_email_succ', '' );
               
                $errMsg=get_option('mass_email_err');
                update_option( 'mass_email_err', '' );
                ?> 
                   
                <?php if($SuccMsg!=""){ echo "<div id='succMsg'>"; echo $SuccMsg; echo "</div>";$SuccMsg="";}?>
                 <?php if($errMsg!=""){ echo "<div id='errMsg' >"; _e($errMsg); echo "</div>";$errMsg="";}?>
              
                <h3>Send email to users</h3>
                  
               <form method="post" action="" id="sendemail" name="sendemail">
                
                <?php wp_nonce_field('action_mass_email_nonce','mass_email_nonce'); ?>   
                <input type="hidden" value="sendEmailForm" name="action" id="action">
                
                  <table class="widefat fixed" cellspacing="0" style="width:97% !important" >
                <thead>
                <tr>
                        <th scope="col" id="name" class="manage-column column-name" style=""><input onclick="chkAll(this)" type="checkbox" name="chkallHeader" id='chkallHeader'>&nbsp;<?php _e('Select All Emails');?></th>
                        <th scope="col" id="name" class="manage-column column-name" style=""><?php _e('Username');?></th>
                        
                </tr>
                </thead>

                <tfoot>
                <tr>
                        <th scope="col" id="name" class="manage-column column-name" style=""><input onclick="chkAll(this)" type="checkbox" name="chkallfooter" id='chkallfooter'>&nbsp;<?php _e('Select All Emails');?></th>
                        <th scope="col" id="name" class="manage-column column-name" style=""><?php _e('Username');?></th>
                        
                        
                </tr>
                </tfoot>

                <tbody id="the-list" class="list:cat">
               <?php                             
                    for($i=$start;$i < $end ;++$i)
                     {
                        
                        
                        if($emails[$i]!=""){ 
                       
                           $userId=$emails[$i]['ID'];
                           $user_info = get_userdata($userId); 
                           echo"<tr class='iedit alternate'>
                            <td  class='name column-name' style='border:1px solid #DBDBDB;padding-left:13px;'><input type='checkBox' name='ckboxs[]'  value='".$emails[$i]['user_email']."'>&nbsp;".$emails[$i]['user_email']."</td>";
                            echo "<td  class='name column-name' style='border:1px solid #DBDBDB;'> ".$user_info->user_login."</td>";
                            echo "</tr>";
                        }   
                           
                     }
                       
                   ?>  
                 </tbody>       
                </table>
                  <table>
                  <tr>
                    <td>
                      <?php
                       if(sizeof($emails)>0){
                         echo "<div class='pagination' style='padding-top:10px'>";
                         echo paginate_links($pagination_args);
                         echo "</div>";
                        }
                        
                       ?>
                
                    </td>
                    <td>
                      <b>&nbsp;&nbsp;Per Page : </b>
                      <?php
                        $setPerPageadmin='admin.php?page=Mass-Email';
                        /*if(isset($_GET['entrant']) and $_GET['entrant']!=""){
                            $setPerPageadmin.='&entrant='.(int)trim($_GET['entrant']);
                        }*/
                        $setPerPageadmin.='&setPerPage=';
                      ?>
                      <select name="setPerPage" onchange="document.location.href='<?php echo $setPerPageadmin;?>' + this.options[this.selectedIndex].value + ''">
                        <option <?php if($rows_per_page=="10"): ?>selected="selected"<?php endif;?>  value="10">10</option>
                        <option <?php if($rows_per_page=="20"): ?>selected="selected"<?php endif;?> value="20">20</option>
                        <option <?php if($rows_per_page=="30"): ?>selected="selected"<?php endif;?>value="30">30</option>
                        <option <?php if($rows_per_page=="40"): ?>selected="selected"<?php endif;?> value="40">40</option>
                        <option <?php if($rows_per_page=="50"): ?>selected="selected"<?php endif;?> value="50">50</option>
                       
                      </select>  
                    </td>
                  </tr>
                   <tr>
                    <td class='name column-name' style='padding-top:15px;padding-left:10px;'><input onclick="return validateSendEmailAndDeleteEmail(this)" type='submit' value='Send Email to Users' name='sendEmail' class='button-primary' id='sendEmail' ></td>
                    </tr>
                </table>
                </form>  
      
                  
     <?php
                   
      }
     else
      {
             echo '<center><div style="padding-bottom:50pxpadding-top:50px;"><h3>No Users Found</h3></div></center>';
             
      } 
    ?>
   </div>              
  </div>
   <div id="postbox-container-1" class="postbox-container" style="float:right;margin-top: 50px" > 

                <!--<div class="postbox"> 
                    <center><h3 class="hndle"><span></span>Access All Themes In One Price</h3> </center>
                    <div class="inside">
                        <center><a href="http://www.elegantthemes.com/affiliates/idevaffiliate.php?id=11715_0_1_10" target="_blank"><img border="0" src="<?php echo plugins_url( 'images/300x250.gif', __FILE__ ) ;?>" width="250" height="250"></a></center>

                        <div style="margin:10px 5px">

                        </div>
                    </div></div>
                <div class="postbox"> 
                    <center><h3 class="hndle"><span></span>Best WordPress Themes</h3> </center>
                    <div class="inside">
                        <center><a target="_blank" href="https://mythemeshop.com/?ref=nik_gandhi007"><img src="<?php echo plugins_url( 'images/300x250.png', __FILE__ ) ;?>" width="250" height="250" border="0"></a></center>
                        <div style="margin:10px 5px">
                        </div>
                    </div></div>-->

            </div>
</div>               
    <?php
     break;
     
  } 
 
?>
 <script type="text/javascript" >
 
  function chkAll(id){
  
  if(id.name=='chkallfooter'){
  
    var chlOrnot=id.checked;
    document.getElementById('chkallHeader').checked= chlOrnot;
   
  }
 else if(id.name=='chkallHeader'){ 
  
      var chlOrnot=id.checked;
     document.getElementById('chkallfooter').checked= chlOrnot;
  
   }
 
     if(id.checked){
     
          var objs=document.getElementsByName("ckboxs[]");
           
           for(var i=0; i < objs.length; i++)
          {
             objs[i].checked=true;
           
            }

     
     } 
    else {

          var objs=document.getElementsByName("ckboxs[]");
           
           for(var i=0; i < objs.length; i++)
          {
             objs[i].checked=false;
           
            }  
      } 
  } 
  
  function validateSendEmailAndDeleteEmail(idobj){
  
       var objs=document.getElementsByName("ckboxs[]");
       var ischkBoxChecked=false;
       for(var i=0; i < objs.length; i++){
         if(objs[i].checked==true){
         
             ischkBoxChecked=true;
             break;
           }
       
        }  
      
      if(ischkBoxChecked==false)
      {
         if(idobj.name=='sendEmail'){
         alert('Please select atleast one email to send email.')  ;
         return false;
        
         }
        else if(idobj.name=='deleteSubscriber') 
         {
            alert('Please select atleast one email to delete.')  
             return false;  
         }
      }
     else
       return true; 
        
  } 
     
  </script>

<?php  

}
  
  ?>