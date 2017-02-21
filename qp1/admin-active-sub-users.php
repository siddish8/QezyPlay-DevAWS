<?php 
	include('header.php');
?>
<style>
.disabled{cursor:not-allowed !important;pointer-events:none;opacity:0.4}

</style>

<article class="content items-list-page">

    <?php

	$msg = ""; $action = "Add";

	if(isset($_REQUEST['delAsauc'])){

		$id = $_REQUEST['delAsaucid'];

             

       $sql1="DELETE FROM user_video_accesslist where id=".$id."";

		$stmt11 = $dbcon->prepare($sql1, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
		$stmt11->execute();
		$stmt11=null;

             $msg1="";
			$msg1.= "Deleted Successfully<br>";
			$msg = "<span id='msg' style='color:green'>".$msg1."</span>";
	
		
	}

    if(isset($_POST['get_uname'])){
        $usrid=$_POST['uid'];
         if($usrid==""){
             $msg1="";
			$msg1.= "Please enter User-id<br>";
			$msg = "<span id='msg' style='color:red'>".$msg1."</span>";
         
        }else{
             $usname=get_var("SELECT user_login from wp_users WHERE ID='".$usrid."'");
             if($usname==""){
                  $msg1="";
			$msg1.= "No User Found<br>";
			$msg = "<span id='msg' style='color:red'>".$msg1."</span>";
           
         }
        }
               
       
        
        $add=1;
    }

    if(isset($_POST['get_uid'])){

            $usname=$_POST['uname'];
             if($usname==""){
                  $msg1="";
			$msg1.= "Please enter User-name<br>";
			$msg = "<span id='msg' style='color:red'>".$msg1."</span>";
            
        }else{            	
            $usrid=get_var("SELECT ID from wp_users WHERE user_login='".$usname."'");
             if($usrid==""){
             $msg1="";
			$msg1.= "No User Found<br>";
			$msg = "<span id='msg' style='color:red'>".$msg1."</span>";
            }
        }
           
            $add=1;
            
    }


	if(isset($_POST['Add_Submit'])){
		
		$uname=$unam=trim($_POST['user_name']);
        $unam=strtolower(preg_replace('/\s+/', '', $unam));
		$uid=trim($_POST['user_id']);
		        
				
		$stmt21 = $dbcon->prepare('SELECT * FROM user_video_accesslist WHERE user_id = '.$uid.'  ', array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));	
		$stmt21->execute();
		$result21 = $stmt21->fetchAll(PDO::FETCH_ASSOC);
		$asaucexist1 = count($result21);	
		$stmt21=null;

        //$sql='SELECT * FROM promocodes_vs_shows WHERE LOWER(REPLACE(assigned_to," ","")) = "'.$assign.'" ';
        $sql='SELECT * FROM user_video_accesslist WHERE LOWER(REPLACE(user_name," ","")) = "'.$unam.'"  ';
       // echo $sql; exit;
		$stmt21 = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));	
		$stmt21->execute();
		$result21 = $stmt21->fetchAll(PDO::FETCH_ASSOC);
		$asaucexist2 = count($result21);	
		$stmt21=null;

		if((int)$asaucexist1 > 0){

			$msg1="";
			$msg1.= "This user id already exist <br>";
			$msg = "<span id='msg' style='color:red'>".$msg1."</span>";
			
		}elseif((int)$asaucexist2 > 0){

			$msg1="";
			$msg1.= "This user name already exist <br>";
			$msg = "<span id='msg' style='color:red'>".$msg1."</span>";

		}
		
		else{	
						
			
            //echo 'INSERT INTO user_video_accesslist(user_id,user_name) VALUES('.$uid.',"'.$uname.'")';
			$stmt22 = $dbcon->prepare('INSERT INTO user_video_accesslist(user_id,user_name) VALUES('.$uid.',"'.$uname.'")', array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));	
			$stmt22->execute();
			echo $asauc_id = $dbcon->lastInsertId();

			

			$msg = "<span style='color:green'>User granted access sucessfully</span>";
						
		
		}
	}


	


    if($x==1){
        $action = "Add";
        $asaucid1 = "";
        $name1 = $email1 = "";
        $password1 = $admin_level1 = "";


    }
?>

        <style>
            .xoouserultra-field-value,
            .xoouserultra-field-type {
                width: unset !important;
                padding: 5px;
            }
            
            form[name="f_timezone"] {
                display: none;
            }
            
            #search_shpc>input[type="text"] {
                max-width: 250px;
            }
            
            .link_btn:hover {
                background: #000;
                color: #fff;
                border: solid 1px #000;
            }
            
            .link_btn:visited {
                color: white !important
            }
            
            .link_btn {
                border-radius: 3px;
                line-height: 2.75;
                text-align: center;
                margin: 5px;
                padding: 6.5px 25px;
                outline: none;
                background: #4141a0;
                border: solid 1px #4141a0;
                color: #fff;
                transition: all .2s ease;
                text-decoration: none;
                border-radius: 5px;
            }
        </style>

        <h2 style="text-align:center"></h2>

        <?php		

	//if($_SESSION['adminlevel']<=1){
		if ($action=="Edit"){ 
			echo "<style>#add_asauc_btn{display:none} #asauc-form-section{display:block !important;}</style>";
		}
        

?>
            <section class="section"><h2></h2>
                <span style="float:"></span>
                <div class="msg" align="center" style="display:inline-block">
                    <h4>
                        <?php echo $msg;?>
                    </h4>
                </div>
                <div class="row sameheight-container">
                    <div class="col-md-3">
                      <!--  <button id="add_asauc_btn" class="btn btn-primary" onclick="return asauc_form()">Add User</button> -->
                    </div>
                    <div class="col-md-6">
                        <div id="asauc-form-section" class="card card-block sameheight-item" style="display:none;height:auto;/*height: 721px;*/">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <div class="header-block">
                                        <p class="title">
                                            <?php echo $action; ?> User </p>
                                    </div>
                                </div>
                                <div class="xoouserultra-field-value" style="">
                                    <div id='error' style='color:red;'></div>
					</div>
					<div class="card-block ">
                                    <div id="content">
										<section class="last">
											<h2>First Get User Info </h2>

											<p>
                                                <form method="post">
                                                Enter Username : 
                                                <input type="text" name="uname" id="uname" /> 
                                                <input type="submit" name="get_uid" value="Get UserId" />  
                                                
                                                <br>or<br>

                                                Enter UserId: <input type="text" name="uid" id="uid" /> 
                                                <input type="submit" name="get_uname" value="Get Username" />  
                                                
                                              
                                                </form>

 										</p>

											<!-- a href="#" class="button icon fa-arrow-circle-right">Continue Reading</a -->
										</section>
									</div>

                                    <form role="form" method='post' enctype="multipart/form-data">
				
                                        <div class="form-group"> <label class="control-label">UserId</label> <input readonly style="" onclick="clearError()" onkeypress="return event.charCode !=32" type="text" value="<?php echo @$usrid;?>" id="user_id" name="user_id" class="form-control underlined"> </div>
                                        <div class="form-group"> <label class="control-label">UserName</label> <input readonly style="" onclick="clearError()" onkeypress="return event.charCode !=32" type="text" value="<?php echo @$usname;?>" id="user_name" name="user_name" class="form-control underlined"> </div>
                                        																		
                                       
                                        <div class="xoouserultra-field-value" style="padding-left: 10px;">
                                         									
                                            <input class="btn btn-primary" type="submit" onclick="return callsubmit();" name="<?php echo $action;?>_Submit" value="Check and Submit" />
                                           									
                                        </div>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">

                        </div>
                    </div>
            </section>
            <?php //}

if($_SESSION['adminlevel']<=1){
?>


          <!--  <section class="section" style="margin:100px auto">
 <div class="col-md-3">
                             
                            </div>
<div id="search_sub_list" align="center" style="margin:15px auto;" class="col-md-6">

        Search using any criteria: <br />
	<div class="form-group"> 
		<input placeholder="Enter PromoCode" id="searchPC" type="text" name="searchPC" class="form-control boxed"><span class="_or"> </span> 
	</div>	
	<div class="form-group"> 
		<input placeholder="Enter Creator" id="searchCr" type="text" name="searchCr" class="form-control boxed"><span class="_or"> </span> 
	</div>	
	<div class="form-group"> 
		<input placeholder="Enter Assigned group" id="searchAs" type="text" name="searchAs" class="form-control boxed"><span class="_or"> </span> 
	</div>	
	<div class="form-group"> 
		<input placeholder="Enter Promocode Status-active/deactivated" id="searchSt" type="text" name="searchSt" class="form-control boxed"><span class="_or"> </span> 
	</div>	
	

	</div>
 <div class="col-md-3">
                             
                            </div>
   </section> -->

<?php

}

?>

            <section class="section">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-block">
                                <div class="card-title-block">
                                    <h3 class="title">
                                        QP active / subscribed USERS
                                    <br>
                                   
                                    <?php 
                                    $users=get_all("SELECT user_id from user_video_accesslist where user_id not in (SELECT ID from wp_users)");
                                    if(count($users)>0){
                                        echo " You can delete following users: <br>";
                                        foreach($users as $user){
                                        echo $user['user_id']." | ";
                                        }

                                    }
                                    ?>
                                    </h3>
                                </div>
                                <section class="example">
                                    <form id="frm2" method="post">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover">

                                                <thead>
                                                 <?php //}

if($_SESSION['adminlevel']<=1){
?>
                                                  <!--  <tr>
                                                        <th><input placeholder="Search PromoCode" id="searchPC" type="text" name="searchPC" class="form-control boxed"><span class="_or"> </span></th>
                                                        <th><input placeholder="Search Creator" id="searchCr" type="text" name="searchCr" class="form-control boxed"><span class="_or"> </span></th>
                                                        <th><input placeholder="Search Assigned group" id="searchAs" type="text" name="searchAs" class="form-control boxed"><span class="_or"> </span></th>
                                                        <th><input placeholder="Search Status-active/deactivated" id="searchSt" type="text" name="searchSt" class="form-control boxed"><span class="_or"> </span></th>
                                                        <th colspan='3' style='text-align:center;font-size:large'><i class='fa fa-arrow-left' aria-hidden='true'></i> Search</th>
                                                    </tr> -->
<?php
}
?>
                                                    <tr>
                                                    <th>S.No</th>
                                                     <th>Plan</th>
                                                        <th><i>User Id</i></th>
                                                         <th>User Name</th>
                                                        
                                                         <th>Location</th>
                                                         <th>Valid till</th>
                                                      <!--  <th> Action <i class="fa fa-cog"></i></th> -->
                                                        <?php		
					
						if($_SESSION['adminlevel']<=0){ 
							
					?>

                                                            

                                                            <?php 
                                                           $sql = "SELECT a.ID,a.user_login,a.user_email,a.phone,a.user_url,b.membership_id as plan,b.billing_amount as amt,b.startdate as my_date,b.enddate as endD FROM wp_users a inner join wp_pmpro_memberships_users b on a.id=b.user_id where (b.status='active') UNION SELECT a.ID,a.user_login,a.user_email,a.phone,a.user_url,c.plan_id as plan,c.amount as amt,c.credited_datetime as my_date,c.subscription_end_on as endD FROM wp_users a inner join agent_vs_subscription_credit_info c on a.id=c.subscriber_id where (c.subscription_end_on <= CURDATE()) order by my_date desc";
					
						} else
                        {
                                   $sql = "SELECT a.ID,a.user_login,a.user_email,a.phone,a.user_url,b.membership_id as plan,b.billing_amount as amt,b.startdate as my_date,b.enddate as endD FROM wp_users a inner join wp_pmpro_memberships_users b on a.id=b.user_id where (b.status='active') UNION SELECT a.ID,a.user_login,a.user_email,a.phone,a.user_url,c.plan_id as plan,c.amount as amt,c.credited_datetime as my_date,c.subscription_end_on as endD FROM wp_users a inner join agent_vs_subscription_credit_info c on a.id=c.subscriber_id where (c.subscription_end_on <= CURDATE()) order by my_date desc";
                        }
					?>
                                                    </tr>
                                                </thead>
                                                <tbody id="asauc_list" class="ui-sortable">
                                                    <?php

				$stmt4 = $dbcon->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));	
				$stmt4->execute();
				
				$result4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);
				$stmt4=null;
               if(count($result4)>0){

               $id=1;
               $intC=$ft=$ftI=$q=$qI=$h=$hI=$y=$yI=0;
				foreach($result4 as $row){

					$user_id=$row['ID'];

                    $internal=get_var("Select count(*) from user_qezy_testlist where user_id=".$user_id."");
				if($internal > 0){
					$int='<img style="max-width:30px;float:right" src="'.UPLOAD_FOLDER1.'/2016/06/QP_favicon.png" alt="internal_user"/>';
                    $intC=$intC+1;
				}
				else{
					$int="";
				}

					$user_name=$row['user_login'];
					$user_email=$row['user_email'];
                    $sub_plan=$row['plan'];

                    if($row['endD']!="0000-00-00 00:00:00"){
                         $end_date=date("d-m-Y",strtotime($row['endD']));

                    }else{
                        $end_date="-";
                    }
                   
                    if($sub_plan==4)
                    {
                        $ft=$ft+1;
                        if($internal>0){
                            $ftI=$ftI+1;
                            }
                    }elseif($sub_plan==3)
                    {
                        $q=$q+1;
                        if($internal>0){
                            $qI=$qI+1;
                            }
                    }elseif($sub_plan==6)
                    {
                        $h=$h+1;
                        if($internal>0){
                            $hI=$hI+1;
                            }
                    }elseif($sub_plan==7)
                    {
                        $y=$y+1;
                        if($internal>0){
                            $yI=$yI+1;
                            }
                    }

                    $plan_name=get_var("SELECT name from wp_pmpro_membership_levels where id=$sub_plan ");
                    $code=get_var("SELECT code_id from wp_pmpro_memberships_users where user_id=$user_id and status='active' order by id desc ");
				
                    //$paid_amnt=$row['billing_amount'];
				    $paid_amnt=$row['amt'];

                    $planInfo = "<strong>Name: </strong>".$plan_name;
                    $planInfo .= "<br><strong>ID: </strong>".$sub_plan;
                    $planInfo .= "<br><strong>Amount Paid: </strong>".$paid_amnt;

                    if($code!="")
                        $planInfo .= "<br><strong>Coupon/Promo </strong>".$code;

                    //$code=$row['code_id'];
                    
                    $user_ip=get_var('SELECT meta_value FROM wp_usermeta where meta_key="uultra_user_registered_ip" and user_id='.$user_id.' ');
                    if($user_ip==""){
                        //echo 'SELECT ip_address FROM visitors_info where user_id='.$user_id.' and ip_address<>"" and country_code<>"" order by id asc limit 1';
                        $user_ip=get_var('SELECT ip_address FROM visitors_info where user_id='.$user_id.' and ip_address<>"" and country_code<>"" order by id asc limit 1');
                    }
				//$user_ip = $user_ip_arr['meta_value'];

				$user_city=get_var('SELECT city FROM visitors_info where ip_address="'.$user_ip.'" and city<>""');
				//$user_city=$user_city_arr['city'];
				$user_state=get_var('SELECT state FROM visitors_info where ip_address="'.$user_ip.'" and state<>""');
				//$user_state=$user_state_arr['state'];
				$user_country=get_var('SELECT country FROM visitors_info where ip_address="'.$user_ip.'" and country<>""');
				//$user_country=$user_country_arr['country'];

						$geoInfo = "<strong>IP: </strong>".$user_ip;
						$geoInfo .= "<br><strong>Country: </strong>".$user_country;
						$geoInfo .= "<br><strong>State: </strong>".$user_state;
						$geoInfo .= "<br><strong>City: </strong>".$user_city;
					
            ?>
                                                        <tr style="" class="ui-sortable-handle">
                                                        <td style="" class="level_name">
                                                                <?php echo $id;?>
                                                                
                                                            </td>
                                                        <td style="width:192px"><?php echo $plan_name ?> <a href="javascript:void(0)" class="tooltip"> <i class="fa fa-info-circle" aria-hidden="true"></i> <span><?php echo $planInfo ?>'</span></a></td>
                                                            <td class="level_name">
                                                                <?php echo $int.$user_id;?>
                                                            </td>
                                                            <td style="" class="level_name">
                                                                <?php echo $user_name;?>
                                                                
                                                            </td>
                                                            <!--<td style="" class="level_name">
                                                                <?php echo $sub_plan;  
                                                                        if($code!=""){ 

                                                                        echo "<br>".$code;
                                                                 } ?>
                                                                 
                                                            </td>-->
                                                            

                                                            <td style="width:192px"><?php echo $user_country ?> <a href="javascript:void(0)" class="tooltip"> <i class="fa fa-info-circle" aria-hidden="true"></i> <span><?php echo $geoInfo ?>'</span></a></td>
                                                                                                                       
                                                          <!-- <td style="width: 200px;">
                                                                <a style="cursor:pointer;" id="removeAsauc" name="removeAsauc" onclick="return confirmDelAsauc(<?php echo $id;?>)"><i class="fa fa-trash" aria-hidden="true">Delete</i></a>
                                                                </td> -->
                                                                <td><?php echo $end_date ?></td>


                                                        </tr>
                                                        <?php 
                                                        $id=$id+1;
	} 
    }//if
    else{
        echo "<tr style='text-align:center'><td colspan='4'>No Results</td></tr>";
    }
?>
<tr style="text-align:center;"><td colspan="2">FT:<?php echo $ft ?></td><td colspan="2">Internal:<?php echo $ftI ?></td><td colspan="2">Countable: <?php echo $ft-$ftI ?></td></tr>
<tr style="text-align:center;"><td colspan="2">Q:<?php echo $q ?></td><td colspan="2">Internal:<?php echo $qI ?></td><td colspan="2">Countable: <?php echo $q-$qI ?></td></tr>
<tr style="text-align:center;"><td colspan="2">H:<?php echo $h ?></td><td colspan="2">Internal:<?php echo $hI ?></td><td colspan="2">Countable: <?php echo $h-$hI ?></td></tr>
<tr style="text-align:center;"><td colspan="2">Y:<?php echo $y ?></td><td colspan="2">Internal:<?php echo $yI ?></td><td colspan="2">Countable: <?php echo $y-$yI ?></td></tr>
<tr style="text-align:center;font-weight:bolder;"><td colspan="2">Total:<?php echo count($result4) ?></td><td colspan="2">Internal:<?php echo $intC ?></td><td colspan="2">Countable: <?php echo count($result4)-$intC ?></td></tr>
                                                </tbody>
                                                <tr id="no_res_div" align="center" style="margin: 5px auto; border-bottom: 1px solid #999;  max-width: 80%;
    font-size: 15px;">
                                                    <td colspan="4" id="no_res" style="margin:0 auto;text-align:center"></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </form>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            

            <script>

                
               
                 function validateEmail(email) {
                    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                    return re.test(email);
                }

               
                
                function callsubmit() {

                    $("#asauc-form-section").css("height", "auto");


                    //var x=document.getElementById('user_id').value;
                  //  alert(x);
                    var username = $("#user_name").val();
                    var userid = $("#user_id").val();
                                       

                    if (userid == "") {
                        $("#error").html("Please get user id");
                        return false;
                    }
                    if (username == "") {
                        $("#error").html("Please get a username");
                        return false;
                    }

                                     



                    if (userid != "" && username != "" ) {
                        return true;
                    }

                    return false;

                }


                
                function clearError() {

                    $("#error").html("");
                    $(".msg h4").html("");
                }


                function confirmDelAsauc(Delid) {

                    swal({
                        title: ' ',
                        text: 'Do you really want to delete this user-access ?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Delete",
                        cancelButtonText: "Cancel",
                        closeOnCancel: true
                    }, function() {
                        var input1 = $("<input>")
                            .attr("type", "hidden")
                            .attr("name", "delAsaucid").val(Delid);
                        var input2 = $("<input>")
                            .attr("type", "hidden")
                            .attr("name", "delAsauc").val(true);
                        $('#frm2').append($(input1));
                        $('#frm2').append($(input2));
                        $("#frm2").submit();

                    });

                }

                function confirmEditAuc(Editid) {

                    swal({
                        title: ' ',
                        text: 'Do you want to edit this info?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Edit",
                        cancelButtonText: "Cancel",
                        closeOnCancel: true
                    }, function() {
                        var input1 = $("<input>")
                            .attr("type", "hidden")
                            .attr("name", "editAsaucid").val(Editid);
                        var input2 = $("<input>")
                            .attr("type", "hidden")
                            .attr("name", "editAsauc").val(true);
                        $('#frm2').append($(input1));
                        $('#frm2').append($(input2));
                        $("#frm2").submit();

                    });

                }

        

                $("#asauc-form-section").css("height", "auto");

                function asauc_form() {

                  //  $("#name").val("");
                 //   $("#email").val("");
                   // $("#password").val("");
                     // $("#admin_level").val("");
//
                    var s = document.getElementById("asauc-form-section");

                    if (s.style.display == "none") {
                        jQuery("#asauc-form-section").show();
                    } else {
                        jQuery("#asauc-form-section").hide();
                    }
                }


                if ($("tr#no_res_div td").html() == "") {
                    $("tr#no_res_div").hide();
                }

                <?php

                    if($add==1){

                            ?>
                            asauc_form();
                        <?php
                    }

                ?>

            </script>

</article>

<?php

include('footer.php');
?>