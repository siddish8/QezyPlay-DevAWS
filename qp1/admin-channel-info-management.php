<?php 
	include('header.php');
?>
<style>


</style>

<article class="content items-list-page">

<?php

$msg = ""; $action = "Add";

if(isset($_GET['del'])){

	$id = $_GET['id'];

	$stmt11 = $dbcon->prepare("DELETE FROM channel_info WHERE id = ".$id."", array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt11->execute();
	
	$msg = "<span style='color:green'>Channel Info deleted Successfully</span>";
	
}


if(isset($_POST['Add_Submit'])){
		$channel_id=trim($_POST['channel_id']);		
		$channel_name=trim($_POST['channel_name']);
		$octo_url=trim($_POST['octo_url']);
		$octo_js=trim($_POST['octo_js']);
		
		
		$stmt21 = $dbcon->prepare('select id from channel_info where channel_id = "'.$channel_id.'" OR octo_url = "'.$octo_url.'" OR octo_js = "'.$octo_js.'"', array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));		
	$stmt21->execute();
	$result21 = $stmt21->fetch(PDO::FETCH_ASSOC);
	$userexit = $result21['id'];
		if((int)$userexist > 0){
			
			echo $msg = "<span style='color:red'>Channel Info already exist</span>";
			
		}else{			
			
			//insert query
			$stmt22 = $dbcon->prepare('INSERT INTO channel_info(channel_id,channel_name,octo_url,octo_js) VALUES("'.$channel_id.'","'.$channel_name.'","'.$octo_url.'","'.$octo_js.'")', array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));	
		$stmt22->execute();
						

			$msg = "<span style='color:green'>Channel Info added Successfully</span>";
						
		}
	}


if(isset($_POST['Edit_Submit'])){

		$id=trim($_POST['channelid']);
		
		
		$channel_id=trim($_POST['channel_id']);
		$channel_name=trim($_POST['channel_name']);
		$octo_url=trim($_POST['octo_url']);
		$octo_js=trim($_POST['octo_js']);
		
		$stmt21 = $dbcon->prepare('select id from channel_info where id != '.$id.' AND (channel_id = "'.$channel_id.'" OR octo_url = "'.$octo_url.'" OR octo_js = "'.$octo_js.'")', array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));	
	$stmt21->execute();
	$result21 = $stmt21->fetch(PDO::FETCH_ASSOC);	
	$userexit = $result21['id']; 
		 
		if((int)$userexit > 0){
			
			$msg = "<span style='color:red'>Channel info already exist</span>";
			
		}else{
			
			//update query

			$stmt22 = $dbcon->prepare('UPDATE channel_info SET channel_id = "'.$channel_id.'", channel_name = "'.$channel_name.'", octo_url = "'.$octo_url.'", octo_js = "'.$octo_js.'" WHERE id = '.$id, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));	 
		$stmt22->execute();
			
			
			$msg = "<span style='color:green'>Channel Info updated Successfully</span>";
			
									
		}		
		
	}	


if(isset($_GET['edit'])){

		$id = $_GET['id'];		

		$stmt1 = $dbcon->prepare("SELECT * FROM channel_info where id='".$id."'", array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt1->execute();
	$result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
	foreach($result1 as $row1){
			$channel_id1=$row1['channel_id'];
			$channel_name1=$row1['channel_name'];
			$octo_url1=$row1['octo_url'];
			$octo_js1=$row1['octo_js'];
			$octo_js1=stripslashes($octo_js1);
		}
	
		$action = "Edit";

	}	


	?>

<style>
/* define height and width of scrollable area. Add 16px to width for scrollbar          */
div.tableContainer {
    clear: both;
    border: 1px solid #963;

}

/* Reset overflow value to hidden for all non-IE browsers. */
html>body div.tableContainer {
    overflow: hidden;
    width: 756px
}

/* define width of table. IE browsers only                 */
div.tableContainer table {
    float: left;
    width: 740px
}

/* define width of table. Add 16px to width for scrollbar.           */
/* All other non-IE browsers.                                        */
html>body div.tableContainer table {
    width: 756px
}

thead.fixedHeader tr {
    position: relative
}
html>body thead.fixedHeader tr {
    display: block
}

thead.fixedHeader th {
    background: #C96;
    border-left: 1px solid #EB8;
    border-right: 1px solid #B74;
    border-top: 1px solid #EB8;
    font-weight: normal;
    padding: 4px 3px;
    text-align: left
}

html>body tbody {
    display: block;
    width: 100%;
}
    
html>body tbody.scrollContent {
    height: 262px;
    overflow: auto;
}

tbody.scrollContent td, tbody.scrollContent tr.normalRow td {
    background: #FFF;
    border-bottom: none;
    border-left: none;
    border-right: 1px solid #CCC;
    border-top: 1px solid #DDD;
    padding: 2px 3px 3px 4px
}

tbody.scrollContent tr.alternateRow td {
    background: #EEE;
    border-bottom: none;
    border-left: none;
    border-right: 1px solid #CCC;
    border-top: 1px solid #DDD;
    padding: 2px 3px 3px 4px
}

html>body thead.fixedHeader th {
    width: 200px
}

html>body thead.fixedHeader th + th {
    width: 240px
}

html>body thead.fixedHeader th + th + th {
    width: 316px
}
html>body tbody td {
    width: 200px
}

html>body tbody td + td {
    width: 240px
}

html>body tbody td + td + td {
    width: 300px
}


</style>

<style>
	#addchannel_submit{
		background-color: #0073aa !important;
		color: azure !important;
		padding: 5px;text-decoration: none;border:solid 1px #0073aa !important;
	}
	#addchannel_submit:hover{
		background-color: azure !important;color: #0073aa !important;
	}
	td{
		padding: 5px 20px;
	}
	
	input{
		width: 250px;
	}
	
	</style>
	<h2 style="text-align:center">Channel Management</h2>
<?php		if($_SESSION['adminlevel']<1)
{ 

if ($action=="Edit"){ echo "<style>#add_chan_btn{display:none} #chan-form-section{display:block !important;}</style>";}
?>	
<section class="section">
<span style="float:"></span><div class="msg" align="center" style="display:inline-block"><h4><?php echo $msg;?></h4></div>
                        <div class="row sameheight-containerchanid">
				 <div class="col-md-3">
                             
				<button id="add_chan_btn" class="btn btn-primary" onclick="return chan_form()">Add New Channel</button>

                            </div>
                            <div class="col-md-6">
                                <div id="chan-form-section" class="card card-block sameheight-item" style="display:none;height:auto !important;/*height: 721px;*/">
                                   <div class="card card-primary">
					<div class="card-header">
                                        <div class="header-block">
                                            <p class="title"> <?php echo $action; ?> Channel </p>
                                        </div>
                                    </div>
				     <div class="xoouserultra-field-value" style="">
						<div id='error' style='color:red;'></div>
					</div>
					<div class="card-block">
                                    <form role="form" method='post' enctype="multipart/form-data">

					<div class="form-group"> <label class="control-label">Channel Name</label>
					<select <?php if($action == 'Edit'){ echo "disabled"; } ?> onchange=updateChanName(this.value,this.options[this.selectedIndex].innerHTML) onclick="clearError()" class="form-control underlined" id="chanid" name="chanid">
					<option value="">SELECT Channel</option>
					<?php 
					$sql5="select ID,post_title from wp_posts where post_type='post' ";
					$chans=get_all($sql5);
					foreach($chans as $chan){
						$chanselected = ($channelid1 == $chan['ID']) ? 'selected="selected" ' : "";
						?>

						<option <?php echo $chanselected ?> value="<?php echo $chan['ID'] ?>"><?php echo $chan['post_title']?></option>
						<?php
					}

					?>
                     </div>

					 <div class="form-group">
					 <input type="hidden" id="channelid" name="channelid" value="<?php echo $id; ?>">
					 <input type="hidden" id="channelname" name="channelname" value="">
					 </div>   
					        
					
					<div class="form-group">
							<label class="control-label">Url</label>
							<input id="octo_url" class="form-control underlined" onclick="clearError()" type="text" alt="" value="<?php echo @$url1;?>" id="url" name="url" />	<input type="button" onclick="get_octo()" value="Get Full URL"/><span id="octo_url_full"></span>
					</div>
					<div class="form-group">
							<label class="control-label">Octo js</label>
							<textarea class="form-control underlined" rows="4" cols="50"  onclick="clearError()" type="text" alt=""  value="<?php echo @$octo_js1;?>" id="octo_js" name="octo_js"></textarea>*Click on "Get Full URL", copy the code and click "Go For JS" and use it there to get js
					</div>

					         
                                        
					<div class="xoouserultra-field-value" style="padding-left: 10px;">
								<?php if($action=="Edit"){?>
								<input type="hidden" name="editChannel"  value="true" />
								<input type="hidden" name="editChannelid"  value="<?php echo @$chanid1;?>" />
								<?php } ?>
								<input class="btn btn-primary" type="submit" onclick="return callsubmit();" name="<?php echo $action;?>_Submit"  value="Submit" />
								<?php if($action=="Edit"){?>
								<a class="btn btn-primary" href="<?php echo SITE_URL.'/qp1/admin-channel-management.php'?>">Back</a>
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

		<section class="section">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-block">
                                        <div class="card-title-block">
                                            <h3 class="title">
							Channels
						</h3> </div>
                                        <section class="example">		
		<form id="frm2" method="post">
		 <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover">
		
			<thead>
				<tr>					
					<th>Channel Id</th>
					<th>Channel Name</th>
					<th>Octo URL</th>
					<th>Octo JS</th>
									
					
					<?php		if($_SESSION['adminlevel']<1)
{ ?> <th>Action</th> <?php } ?>
				</tr>
			</thead>
			<tbody id="chan_list" class="ui-sortable">
			<?php
			$sql4 = "SELECT * FROM channel_info";	
			$result4 = get_all($sql4);
			foreach($result4 as $row){

				$id=$row['id'];
				$channel_id=$row['channel_id'];
				$channel_name=$row['channel_name'];
				$octo_url=$row['octo_url'];
				$octo_js=$row['octo_js'];
				$octo_js=stripslashes( $octo_js );
						
				if($row['is_admin'] != 1){
			?>
				<tr style="" class="ui-sortable-handle">							
				<td style="width: 1px;" class="level_name"><?php echo $channel_id;?></td>
				<td style="width: 332px;"><?php echo $channel_name;?></td>
				<td style="width: 392px;"><?php echo $octo_url?></td>
				<td style="width: 350px;"><?php echo $octo_js;?></td>
				
				
<?php		if($_SESSION['adminlevel']<1)
{ ?>

				
				<td style="width: 332px;">
				<!-- 
					<a style="cursor: pointer;" id="editChannel" href="channel_info_management.php?edit=true&id=<?php echo $id;?>" title="edit" name="Edit-<?php echo $id ?>" class="button-primary">Edit</a>&nbsp;
				<a style="cursor: pointer;" title="delete" name="removeChannel-<?php echo $id;?>" id="removeChannel-<?php echo $id;?>" onclick="callConfirmation('channel_info_management.php?del=true&id=<?php echo $id;?>');" class="button-secondary">Delete</a>
				-->


<a style="cursor:pointer;color:blue;" id="editchannel" name="editchannel" onclick="return confirmEditChannel(<?php echo $id;?>)">Edit</a>
&nbsp;
<a style="cursor:pointer;color:blue;" id="removechannel" name="removechannel" onclick="return confirmDelChannel(<?php echo $id;?>)">Remove</a>	


</td> <?php } ?>
				</tr>
			<?php } }?>
			</tbody>
		</table></div></form>
 </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
<!--
<div class="msg" align="center" style="display:block"><h4><?php echo $msg;?></h4></div> 	
	<br />

	<div class="clear"></div>
	<div align="center" id="<?php echo $action;?>Channel">
		<form method="post" >
			<table>
				<tr><td colspan="2"><center><span style="font-weight:bold;font-size:18px;"><?php echo $action;?> Channel</span></center><br>
				<input type="hidden" id="channelid" name="channelid" value="<?php echo $id; ?>"/></td></tr>
				<tr><td>Channel Id</td><td><input type="text" value="<?php echo @$channel_id1;?>" id="channel_id" name="channel_id" required/></td></tr>
				<tr><td>Channel Name</td><td><input type="text" value="<?php echo @$channel_name1;?>" id="channel_name" name="channel_name" required/></td></tr>
				
				<tr><td>Octo Url</td><td><input type="textarea" value="<?php echo @$octo_url1;?>" required id="octo_url" name="octo_url" /></td></tr>
				<tr><td>Octo JS</td><td><input type="textarea" value='<?php echo @$octo_js1;?>' required id="octo_js" name="octo_js" /></td></tr>
				<tr><td></td><td><input type="submit" name="<?php echo $action;?>_Submit"  value="Submit" style="cursor: pointer;background-color: #0073aa !important;
				color: azure !important;
				padding: 5px;text-decoration: none;border:solid 1px #0073aa !important;" /></td></tr>
			</table>
		</form>
		<?php if($action=="Edit") { ?> <a href='http://ideabytestraining.com/newqezyplay/qp/channel_info_management.php?'><button>Back</button></a> <?php } ?>
	</div>

	<div class="clear"></div>

	<br />

	<div id="ChannelList" align="center" style="margin:0 auto"><h2>Channels List Info</h2> 
		<div id="tableContainer" class="tableContainer">
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="scrollTable widefat membership-levels">

			<tbody class="ui-sortable  scrollContent">
			<?php
			$stmt4 = $dbcon->prepare("SELECT * FROM channel_info", array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));	
			$stmt4->execute();
			$result4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);

			foreach($result4 as $row){

				$id=$row['id'];
				$channel_id=$row['channel_id'];
				$channel_name=$row['channel_name'];
				$octo_url=$row['octo_url'];
				$octo_js=$row['octo_js'];
				$octo_js=stripslashes( $octo_js );

				
			?>
				<tr style="" class="ui-sortable-handle">
				
				<td style="width: 332px;"></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div></div>
	<div class="clear"></div><br /><br />
-->

	<script>
	function updateChanName(chanid,channame){

		jQuery('#channelname').val(channame);
}

	function get_octo()
{
var octo=jQuery("#octo_url").val();
octo="var streamURL='octoshape://streams.octoshape.net/ideabytes/live/ib-"+octo+"'";
octo=octo+"<br><a target='_blank' href='https://javascriptobfuscator.com/Javascript-Obfuscator.aspx'>Go for JS</a>"
jQuery("#octo_url_full").html(octo);
}

function chan_form(){

var s=document.getElementById("chan-form-section");

if(s.style.display=="none")
{
jQuery("#chan-form-section").show();
jQuery("#chan-form-section").css("height","auto");

}
else
{
jQuery("#chan-form-section").hide();
}
}

jQuery("#chan-form-section").css("height","auto");

	function callConfirmation(url){

		var ans = confirm("Sure, do you want to delete this channel info?");
		if(ans){
			window.location.href = url;
		}
	}
	</script>

<?php

include('footer.php');
?><?php include("footer-admin.php"); ?>


