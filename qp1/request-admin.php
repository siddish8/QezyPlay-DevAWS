<?php 
include('header.php');
?>
<article class="content items-list-page">


<?php
if(isset($_REQUEST['check_tm']) OR (isset($_REQUEST['tm_id']) and isset($_REQUEST['tm_name']))){
//echo "hi";
//echo $_REQUEST['tm_id'];
//echo $_REQUEST['tm_name'];
$_SESSION['tm_id']=$_REQUEST['tm_id'];
$_SESSION['tm_name']=$_REQUEST['tm_name'];
$chk_tm=get_var("SELECT count(*) from team_requests where tm_id=".$_REQUEST['tm_id']." and tm_name='".$_REQUEST['tm_name']."'");
$chk_tmid=get_var("SELECT count(*) from team_requests where tm_id=".$_REQUEST['tm_id']." and tm_name<>'".$_REQUEST['tm_name']."'");
//exit;
if((int)$chk_tm == 0 and (int)$chk_tmid == 0){
	$msg2="Welcome Mate";
	$go=1;
	//insert
	execute("INSERT into team_requests(tm_id,tm_name) values('".$_REQUEST['tm_id']."','".$_REQUEST['tm_name']."')");

}elseif((int)$chk_tm >= 1 and (int)$chk_tmid == 0){

	$msg2="Welcome back Mate";
	$go=1;
		
}else{
	$msg2="Hey, check your id. Someone got here first with that";
	$go=0;
}


}else{
?>
<section class="section">
<span style="float:"></span><div class="msg" align="center" style="display:inline-block"><h4><?php echo $msg;?></h4></div>
                        <div class="row sameheight-container">
				 <div class="col-md-3">
				 </div>
				 <div class="col-md-6">
				  <div class="card card-primary">
				 <div class="card-header">
                                        <div class="header-block">
                                            <p class="title">  </p>
                                        </div>
                                    </div>
				<div class="card-block">
				 <form method="post">
					
				 <div class="form-group"> <label class="control-label">ID</label><input class="form-control underlined" required placeholder="emp id" type="text" name="tm_id" id="tm_id" /></div>
				<div class="form-group">  <label class="control-label">Name(use only lowercase)</label><input class="form-control underlined" required type="text" name="tm_name" id="tm_name" /></div>
				 <div class="form-group"> <input class="form-control underlined btn btn-primary" type="submit" name="check_tm" id="check_tm" value="In" /></div>

				 </form>
				 </div>
				 </div>
				 </div>
				 <div class="col-md-3">
				 </div>
				 </div>
				 </section>
<?php
}
?>


<?php
if($go==1){


$msg = ""; $action = "Add";

if(isset($_REQUEST['delAR'])){

	$id = $_REQUEST['delARid'];
	execute("DELETE FROM team_requests WHERE id = ".$id."");
	$msg = "<span id='msg' style='color:green'>Request info deleted Successfully</span>";
	
}


if(isset($_POST['Add_Submit'])){
	
	$tm_id=$_REQUEST['tm_id'];
	$tm_name=$_REQUEST['tm_name'];
	
	$rqname=trim($_POST['rqname']);
	$site=trim($_POST['site']);
	$rqdesc=trim($_POST['rqdesc']);

	$status="pending";	
	$date = gmdate("Y-m-d H:i:s");	
	
	$sql21='SELECT count(*) FROM team_requests WHERE site = "'.$site.'" AND rq_name = "'.$rqname.'" AND description = "'.$rqdesc.'"';	
	$arexist = get_var($sql21);
	//echo $userexit;	
//exit;
	if((int)$arexist > 0){
		$msg1="";		
		$msg1.= "<i class='fa fa-arrow-right' aria-hidden='true'></i> Request already made <br>";
		$msg = "<span id='msg' style='color:red'>".$msg1."</span>";
		
	}else{	
		//echo "NEW";
				
		execute("INSERT into team_requests(tm_id,tm_name,rq_name,site,description,status,created_datetime) values('".$tm_id."','".$tm_name."','".$rqname."','".$site."','".$rqdesc."','".$status."','".$date."')");	
		$msg = "<span style='color:green'>Request Sent Successfully</span>";			
					
	}
}


if(isset($_POST['Edit_Submit'])){

	$arid=trim($_POST['arid']);
	
	$tm_id=$_REQUEST['tm_id'];
	$tm_name=$_REQUEST['tm_name'];
	
	$rqname=trim($_POST['rqname']);
	$site=trim($_POST['site']);
	$rqdesc=trim($_POST['rqdesc']);

	$status="pending";	
	$date = gmdate("Y-m-d H:i:s");	
	
	$sql21='SELECT count(*) FROM team_requests WHERE id != '.$arid.' AND site = "'.$site.'" AND rq_name = "'.$rqname.'" AND description = "'.$rqdesc.'"';	
	$arexist = get_var($sql21);	
//echo $userexit;	
//exit;
	if((int)$arexist > 0){
		$msg1="";	
		$msg1.= "<i class='fa fa-arrow-right' aria-hidden='true'></i> Request info already exist <br>";
		$msg = "<span id='msg' style='color:red'>".$msg1."</span>";		
	}else{
		//update query
		execute('UPDATE team_requests SET site = "'.$site.'",rq_name = "'.$rqname.'",description = "'.$rqdesc.'",created_datetime = "'.$date.'" WHERE id = '.$arid);		
		$msg = "<span style='color:green'>Request info updated Successfully</span>";
		}

}
if(isset($_REQUEST['editAR'])){

	$id = $_REQUEST['editARid'];		

//echo $id;
//exit;	
	$result1 = get_all("SELECT * FROM team_requests where id='".$id."'");
	foreach($result1 as $row1){
		$arid1=$id;
		$rqname1=$row1['rq_name'];
		$site1=$row1['site'];
		$rqdesc1=$row1['description'];		
	}				
	$action = "Edit";

}	

?>

<style>
.xoouserultra-field-value, .xoouserultra-field-type{
	width: unset !important;
	padding: 5px;
}

form[name="f_timezone"] {
    display: none;
}

#search_ar > input[type="text"] {
    max-width: 250px;
}

.link_btn:hover{
    background: #000;
    color: #fff;
    border: solid 1px #000;
}

.link_btn:visited{color:white !important}
.link_btn{
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
    text-decoration:none;
	border-radius:5px;
}
</style>
<h2 style="text-align:center">Request Admin</h2>
<?php		if($_SESSION['adminlevel']<1)
{ 


if ($action=="Edit"){ echo "<style>#add_AR_btn{display:none} #AR-form-section{display:block !important;}</style>";}
?>	
<section class="section">
<h4><?php echo $msg2;?></h4>
<span style="float:"></span><div class="msg" align="center" style="display:inline-block"><h4><?php echo $msg;?></h4></div>
                        <div class="row sameheight-container">
				 <div class="col-md-3">
                             
				<button id="add_AR_btn" class="btn btn-primary" onclick="return AR_form()">Add New Request</button>

                            </div>
                            <div class="col-md-6">
                                <div id="AR-form-section" class="card card-block sameheight-item" style="display:none;height:auto;/*height: 721px;*/">
                                   <div class="card card-primary">
					<div class="card-header">
                                        <div class="header-block">
                                            <p class="title"> <?php echo $action; ?> Request </p>
                                        </div>
                                    </div>
				     <div class="xoouserultra-field-value" style="">
						<div id='error' style='color:red;'></div>
					</div>
					<div class="card-block">
                                    <form role="form" method='post' enctype="multipart/form-data">
					<input type="hidden" id="ARid" name="ARid" value="<?php echo $id; ?>"/>
                                       <!-- <div class="form-group"> <label class="control-label">Channel Name</label> <input onclick="clearError()" type="text" value="<?php echo @$channel1;?>" id="channel" name="channel" class="form-control underlined"> </div> -->

					<div class="form-group"> <label class="control-label">Request Name</label> <input required onclick="clearError()" type="text" value="<?php echo @$rqname1;?>" id="rqname" name="rqname" class="form-control underlined"> </div>
								                           
                   <div class="form-group"> <label class="control-label">Site</label> <input onclick="clearError()" type="text" value="<?php echo @$site1;?>" id="site" name="site" class="form-control underlined" > </div>
				   <div class="form-group"> <label class="control-label">Request Description</label> <textarea cols="20" rows="5" onclick="clearError()" id="rqdesc" name="rqdesc" class="form-control underlined"><?php echo @$rqdesc1;?></textarea> </div>
                                     
                    <input type="hidden" name="tm_id" id="tm_id" value="<?php echo $_SESSION['tm_id'] ?>" />
				 	<input type="hidden" name="tm_name" id="tm_name" value="<?php echo $_SESSION['tm_name'] ?>" /> 

					<div class="xoouserultra-field-value" style="padding-left: 10px;">
								<?php if($action=="Edit"){?>
								<input type="hidden" name="editAR"  value="true" />
								<input type="hidden" name="editARid"  value="<?php echo @$arid1;?>" />
								<?php } ?>
								<input class="btn btn-primary" type="submit" onclick="return callsubmit();" name="<?php echo $action;?>_Submit"  value="Submit" />
								<?php if($action=="Edit"){?>
								<a class="btn btn-primary" href="<?php echo SITE_URL.'/qp1/request-admin.php'?>">Back</a>
   								<?php } ?>
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
<?php }

?>

<!-- <section class="section">
 <div class="col-md-3">
                             
                            </div>
<div id="search_AR" align="center" style="margin:15px auto;" class="col-md-6">
		Search request List using any criteria: <br /> 
		<div class="form-group"> 
		<input placeholder="Enter agent-name" id="searchAN" type="text" name="searchAN" class="form-control boxed"><span class="_or"> </span> 
	</div>
	<div class="form-group">   
		<input placeholder="Enter agent-phone" id="searchPH" type="text" name="searchPH" class="form-control boxed" /> <span class="_or"> </span>
	</div>
	<div class="form-group"> 
		<input placeholder="Enter agent-email" id="searchEM" type="text" name="searchEM" class="form-control boxed" /> 
			</div>	
		</div>
 <div class="col-md-3">
                             
                            </div>
   </section>
-->
<section class="section">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-block">
                                        <div class="card-title-block">
                                            <h3 class="title">
							Requested to Admin
						</h3> </div>
                                        <section class="example">		
		<form id="frm2" method="post">
		 <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover">
		
			<thead>
				<tr>	
					<th>Request Name</th>
					<th>Site</th>
					<th>Description</th>
					<th>Status</th>					
					<th> Action  <i class="fa fa-cog"></i></th>
				</tr>
			</thead>
			<tbody id="AR_list" class="ui-sortable">
			<?php

			$sql22="SELECT * FROM team_requests where tm_id=".$_SESSION['tm_id']." and tm_name='".$_SESSION['tm_name']."' and rq_name<>'' ";
			$result4 = get_all($sql22);
			
			if(count($result4)>0){

				foreach($result4 as $row){

				$id=$row['id'];
				$rqname = $row['rq_name'];
				$site=$row['site'];
				$rqdesc=$row['description'];
				$status = $row['status'];			
				
			?>
				<tr style="" class="ui-sortable-handle">	
				<td style="width: 200px;" class="level_name"><?php echo $rqname;?></td>						
				<td style="width: 200px;" class="level_name"><?php echo $site;?></td>				
				<td style="width: 300px;"><?php echo $rqdesc?></td>
				<td style="width: 185px;"><?php echo $status;?></td>
				
				<td style="width: 100px;">
				<a style="cursor:pointer;color:blue;" id="editAR" name="editAR" onclick="return confirmEditAR(<?php echo $id;?>)"><em title="Edit" class="fa fa-pencil"></em></a>
				&nbsp;
				<a style="cursor:pointer;color:blue;" id="removeAR" name="removeAR" onclick="return confirmDelAR(<?php echo $id;?>)"><i title="Remove" class="fa fa-trash-o "></i></a>				
				</td>
			</tr>
			<?php } ?>
				
			<?php
			}else{
				?>
				<tr style="text-align:center" class="ui-sortable-handle">	
				<td colspan="5" style="width: 200px;" class="level_name">No Requests</td>	
				</tr>

			<?php
			}
			 ?>
		
			</tbody>
			<tr id="no_res_div" align="center" style="margin: 5px auto;
    border-bottom: 1px solid #999;
    max-width: 80%;
    font-size: 15px;"><td colspan="6" id="no_res" style="margin:0 auto;text-align:center"></td></tr>
		</table></div></form>
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

function validatePhone(phone) {
	var re = /^([0|\+[0-9]{1,5})?([1-9][0-9]{9})$/;
	return re.test(phone);
}

function callsubmit(){	
	
	$("#AR-form-section").css("height","auto");
	
	var genre = $("#genre").val();
	var channel = $("#channel").val();
	var progname = $("#programname").val();
	//var timing = $("#timing").val();
	var logo = jQuery("#logofile").val();


	if(channel == ""){
		$("#error").html("Please enter channel name");
		return false;		
	}
			
	if(progname == ""){
		$("#error").html("Please enter program name");
		return false;		
	}


	 if(genre == ""){
		$("#error").html("Please enter any genre");	
		return false;	
	}

	//if(timing == ""){
	//	$("#error").html("Please enter program timing information");	
	//	return false;		
	//}

	if(channel != "" && progname  != "" && genre != ""){
		
				return true;
			
			
	}
	return false;

}



function clearError()
{

		$("#error").html("");
		$(".msg h4").html("");		
	
}


function findRows(table,searchText1,col1,searchText2,col2,searchText3,col3) {

//var table=document.querySelector("#sub_list > tr:visible");
//var table=$('#sub_list tr:visible');
    var rows = table.rows,
        r = 0,
        found = false,
        anyFound = false;
       // var found1,found2,found3;
        //alert(rows.length);
        //alert(searchText1+"in"+col1);
       // alert(searchText2+"in"+col2);
       // alert(searchText3+"in"+col3);
       //  alert(searchText4+"in"+col4);
       // alert(searchText5+"in"+col5);
        //alert(searchText1+"in"+col1);

//alert($('#sub_list tr:visible').length);
	
  var found1=false,found2=false,found3=false;
  
    for (; r < rows.length; r += 1) {
        row = rows.item(r);
          
     // var i=column;
       // alert(searchText1+"in col:"+col1+"  row::"+r);
        
        if(col1!=99)
        found1 = (row.cells.item(col1).textContent.toLowerCase().indexOf(searchText1.toLowerCase().trim()) !== -1);
        else
        found1=true;
         if(col2!=99)
          found2 = (row.cells.item(col2).textContent.toLowerCase().indexOf(searchText2.toLowerCase().trim()) !== -1);else
        found2=true;
          if(col3!=99)
            found3 = (row.cells.item(col3).textContent.toLowerCase().indexOf(searchText3.toLowerCase().trim()) !== -1);else
        found3=true;
          
            
            found=found1 && found2 && found3;
        anyFound = anyFound || found;
//alert(found);
			//if(row.style.display=="none")
      	//	found=false;
        row.style.display = found ? "table-row" : "none";
       }
        
	   
	if(col1==99 && col2==99 && col3==99)
	{
		for (; r < rows.length; r += 1) {
			row = rows.item(r);
			 row.style.display = "table-row" ;}
	}
    //document.getElementById('no_res').style.display = anyFound ? "none" : "block";
var x = document.getElementById("AR_list").rows.length;
//alert("x"+x);
var cnt=0;

for(i=0;i<x;i=i+1)
{
 var y=document.getElementById("AR_list").rows[i].style.display;

if(y=="none")
cnt=cnt+1;
}

//alert("cnt:"+cnt);
if(x==(cnt))
{
document.getElementById("no_res").innerHTML="NO SEARCH RESULTS";
$("#no_res").html("NO SEARCH RESULTS");
$("#no_res_div").show();
}
else
{
$("#no_res").html("");
$("#no_res_div").hide();
}

}

function performSearch() {
    var searchText1 = document.getElementById('searchAN').value,
        searchText3 = document.getElementById('searchEM').value,
        searchText2= document.getElementById('searchPH').value,
        targetTable = document.getElementById('AR_list');
	var searchText=[],col;
	
	if(searchText1!="")
	{
	searchText[0]=searchText1;
	col1=0;
	}
  else{col1=99;}
  
  
	if(searchText2!="")
	{
	searchText[1]=searchText2;
	col2=1;
	}
  else{col2=99;}
  
  
 if(searchText3!="")
	{
	searchText[2]=searchText3;
	col3=3;
	}
  else{col3=99;
}

  	

	//alert(searchText);
    findRows(targetTable,searchText1,col1,searchText2,col2,searchText3,col3);

}

//document.getElementById("search").onclick = performSearch;
//document.getElementById("searchAN").onkeyup = performSearch;
//document.getElementById("searchEM").onkeyup = performSearch;
//document.getElementById("searchPH").onkeyup = performSearch;


function confirmDelAR(Delid)
{

 swal({
 		title:' ', 
  text: 'Do you really want to remove this request?',
  type: 'warning',
  
  showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Remove",   cancelButtonText: "Cancel",  closeOnCancel: true
},function(){ 

var input1 = $("<input>")
               .attr("type", "hidden")
               .attr("name", "delARid").val(Delid);
var input2 = $("<input>")
               .attr("type", "hidden")
               .attr("name", "delAR").val(true);
var input3 = $("<input>")
               .attr("type", "hidden")
               .attr("name", "tm_id").val("<?php echo $_SESSION['tm_id'] ?>");
var input4 = $("<input>")
               .attr("type", "hidden")
               .attr("name", "tm_name").val("<?php echo $_SESSION['tm_name'] ?>");
$('#frm2').append($(input1));
$('#frm2').append($(input2));
$('#frm2').append($(input3));
$('#frm2').append($(input4));
 $("#frm2").submit();

}); 

}

function confirmEditAR(Editid)
{

 swal({
 		title:' ', 
  text: 'Do you want to edit this Request info?',
  type: 'warning',
  
  showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Edit",   cancelButtonText: "Cancel",  closeOnCancel: true
},function(){ 

var input1 = $("<input>")
               .attr("type", "hidden")
               .attr("name", "editARid").val(Editid);
var input2 = $("<input>")
               .attr("type", "hidden")
               .attr("name", "editAR").val(true);
var input3 = $("<input>")
               .attr("type", "hidden")
               .attr("name", "tm_id").val("<?php echo $_SESSION['tm_id'] ?>");
var input4 = $("<input>")
               .attr("type", "hidden")
               .attr("name", "tm_name").val("<?php echo $_SESSION['tm_name'] ?>");
$('#frm2').append($(input1));
$('#frm2').append($(input2));
$('#frm2').append($(input3));
$('#frm2').append($(input4));
 $("#frm2").submit();

}); 

}






$("#AR-form-section").css("height","auto");

function AR_form(){

var s=document.getElementById("AR-form-section");

if(s.style.display=="none")
{
jQuery("#AR-form-section").show();
}
else
{
jQuery("#AR-form-section").hide();
}
}


if($("tr#no_res_div td").html()=="")
	$("tr#no_res_div").hide();
</script>
<?php
}
?>
</article>
<?php
include('footer.php');
?>
