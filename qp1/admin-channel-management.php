<?php 
	include('header.php');
?>
<style>


</style>

<article class="content items-list-page">
<h4>*Edit Channels (mainly images) doesnt work for now</h4>
    <?php


if($_SESSION['adminlevel']>0)
{
//header("Location:".SITE_URL."/qp/admin-main.php");
//exit;
}


$msg = ""; $action = "Add";


if(isset($_REQUEST['delChannel'])){

	$id = $_REQUEST['delChannelid'];
//echo $id;
//exit;

	$stmt11 = $dbcon->prepare("DELETE FROM channels WHERE id = ".$id."", array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt11->execute();
	
	$msg = "<span style='color:green'>Channel deleted Successfully</span>";
	
}


if(isset($_POST['Add_Submit'])){

	$channelid=trim($_POST['chanid']);
	$channelname=$channelname2=trim($_POST['channelname']);
	$channelname=strtolower(preg_replace('/\s+/', '', $channelname));	
	$metadata=trim($_POST['metadata']);
	$metadesc=trim($_POST['metadesc']);	
	$status=trim($_POST['status']);
	$bouquetid=trim($_POST['boqid']);

	$url=trim($_POST['url']);
	$octo_js=trim($_POST['octo_js']);
	$vodurl=trim($_POST['vod_url']);
	$vod_octo_js=trim($_POST['vod_octo_js']);
	$short_vodurl=trim($_POST['short_vod_url']);
	$short_vod_octo_js=trim($_POST['short_vod_octo_js']);

	$category=trim($_POST['category']);
	
	$date = gmdate("Y-m-d H:i:s");
	$download_url=UPLOAD_FOLDER1;
	$userexit=0;

	echo $channelid.$channelname.$metadata.$metadesc.$status.$url.$octo_js.$bouquetid.$category;
exit;
	
	$stmt21 = $dbcon->prepare('SELECT * FROM channels WHERE LOWER(REPLACE(name," ","")) = "'.$channelname.'" OR url = "'.$url.'" OR octo_js = "'.$octo_js.'"', array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));	
	$stmt21->execute();
	$result21 = $stmt21->fetchAll(PDO::FETCH_ASSOC);
	$userexit = count($result21);


echo "yes:".$userexit;
//exit;
	if((int)$userexit > 0){
		
		$msg1="";

		$stmt212 = $dbcon->prepare('SELECT * FROM channels WHERE LOWER(REPLACE(name," ","")) = "'.$channelname.'"', array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));	
		$stmt212->execute();
		$result212 = $stmt212->fetchAll(PDO::FETCH_ASSOC);
		$channameexist = count($result212);

		//echo "cust exist:".$custnameexist;
		if((int)$channameexist > 0){	
			$msg1.= "<i class='fa fa-arrow-right' aria-hidden='true'></i> Channel Name already exist <br>";}

		$stmt211 = $dbcon->prepare('SELECT * FROM channels WHERE url = "'.$url.'"', array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));	
		$stmt211->execute();
		$result211 = $stmt211->fetchAll(PDO::FETCH_ASSOC);
		$urlexist = count($result211);	
//echo $userexit;	
//exit;
		//echo "channel exist:".$chanexist;
		if((int)$urlexist > 0){	
			$msg1.= "<i class='fa fa-arrow-right' aria-hidden='true'></i> Channel URL already exist <br>";}

		$stmt213 = $dbcon->prepare('SELECT * FROM channels WHERE octo_js = "'.$octo_js.'"', array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));	
		$stmt213->execute();
		$result213 = $stmt213->fetchAll(PDO::FETCH_ASSOC);
		$octo_jsexist = count($result213);	
//echo $userexit;	
//exit;
		//echo "channel exist:".$chanexist;
		if((int)$octo_jsexist > 0){	
			$msg1.= "<i class='fa fa-arrow-right' aria-hidden='true'></i> Channel Octo js already exist <br>";}


		$msg = "<span id='msg' style='color:red'>".$msg1."</span>";
		//echo $msg;
		
	}else{	
		//echo "NEW";
		if ($_FILES["logofile"]["error"] > 0){
			$msg = "<span style='color:red'>Problem with Channel logo. Please try again.</span>";
		}else{
			/*$present_time = date("dmYHis");
			$image_extention = explode("/",$_FILES["logofile"]["type"]);
			$sNewFileName = $present_time.".".$image_extention[1];		
											
			if(move_uploaded_file($_FILES["logofile"]["tmp_name"],"channel_logo/".$sNewFileName)){*/
			$present_time = date("dmYHis");
			$file_name = $_FILES["logofile"]["name"];
			//$image_extention = explode("/",$_FILES["logofile"]["type"]);
			//$sNewFileName = $present_time.".".$image_extention[1];
			$sNewFileName = $file_name;				
			$imageUrl = $imageXurl = DATED_PATH."/".$sNewFileName;
				
			if(move_uploaded_file($_FILES["logofile"]["tmp_name"],MEDIA_FOLDER."/".$sNewFileName)){

				//iOS
				$file_name_x = $_FILES["xurl_logofile"]["name"];
				$file_name_2x = $_FILES["2xurl_logofile"]["name"];
				$file_name_3x = $_FILES["3xurl_logofile"]["name"];				

				$sNewFileName_x = $file_name_x;		
				$sNewFileName_2x = $file_name_2x;	
				$sNewFileName_3x = $file_name_3x;	

				$imageXurl = DATED_PATH."/".$sNewFileName_x;
				$image2Xurl = DATED_PATH."/".$sNewFileName_2x;
				$image3Xurl = DATED_PATH."/".$sNewFileName_3x;

				
				if(move_uploaded_file($_FILES["xurl_logofile"]["tmp_name"],MEDIA_FOLDER."/".$sNewFileName_x)){	}													
				if(move_uploaded_file($_FILES["2xurl_logofile"]["tmp_name"],MEDIA_FOLDER."/".$sNewFileName_2x)){	}
				if(move_uploaded_file($_FILES["3xurl_logofile"]["tmp_name"],MEDIA_FOLDER."/".$sNewFileName_3x)){	}	

				
				//Android	

				$file_name_ldpi = $_FILES["ldpi_logofile"]["name"];
				$file_name_mdpi = $_FILES["mdpi_logofile"]["name"];
				$file_name_hdpi = $_FILES["hdpi_logofile"]["name"];
				$file_name_xhdpi = $_FILES["xhdpi_logofile"]["name"];
				$file_name_xxhdpi = $_FILES["xxhdpi_logofile"]["name"];
				$file_name_xxxhdpi = $_FILES["xxxhdpi_logofile"]["name"];			

				$sNewFileName_ldpi = $file_name_ldpi;		
				$sNewFileName_mdpi = $file_name_mdpi;	
				$sNewFileName_hdpi = $file_name_hdpi;
				$sNewFileName_xhdpi = $file_name_xhdpi;		
				$sNewFileName_xxhdpi = $file_name_xxhdpi;	
				$sNewFileName_xxxhdpi = $file_name_xxxhdpi;	

				$imageLDPIurl = DATED_PATH."/".$sNewFileName_ldpi;
				$imageMDPIurl = DATED_PATH."/".$sNewFileName_mdpi;
				$imageHDPIurl = DATED_PATH."/".$sNewFileName_hdpi;
				$imageXHDPIurl = DATED_PATH."/".$sNewFileName_xhdpi;
				$imageXXHDPIurl = DATED_PATH."/".$sNewFileName_xxhdpi;
				$imageXXXHDPIurl = DATED_PATH."/".$sNewFileName_xxxhdpi;

				
				if(move_uploaded_file($_FILES["ldpi_logofile"]["tmp_name"],MEDIA_FOLDER."/".$sNewFileName_ldpi)){	}													
				if(move_uploaded_file($_FILES["mdpi_logofile"]["tmp_name"],MEDIA_FOLDER."/".$sNewFileName_mdpi)){	}
				if(move_uploaded_file($_FILES["hdpi_logofile"]["tmp_name"],MEDIA_FOLDER."/".$sNewFileName_hdpi)){	}
				if(move_uploaded_file($_FILES["xhdpi_logofile"]["tmp_name"],MEDIA_FOLDER."/".$sNewFileName_xhdpi)){	}													
				if(move_uploaded_file($_FILES["xxhdpi_logofile"]["tmp_name"],MEDIA_FOLDER."/".$sNewFileName_xxhdpi)){	}
				if(move_uploaded_file($_FILES["xxxhdpi_logofile"]["tmp_name"],MEDIA_FOLDER."/".$sNewFileName_xxxhdpi)){	}		
				
				//insert query
				$sql22='INSERT INTO channels(id,name,url,octo_js,vodurl,vod_octo_js,short_vodurl,short_vod_octo_js,imageurl,meta_data,meta_description,status,created_datetime,image2xurl,image3xurl,imagehdpiurl,imageldpiurl,imagemdpiurl,imagexhdpiurl,imagexxhdpiurl,imagexxxhdpiurl,downloadurl,category,imagexurl) VALUES('.$channelid.',"'.$channelname2.'","'.$imageUrl.'","'.$metadata.'","'.$metadesc.'","'.$is_free.'","'.$status.'","'.$date.'","'.$image2Xurl.'","'.$image3Xurl.'","'.$imageHDPIurl.'","'.$imageLDPIurl.'","'.$imageMDPIurl.'","'.$imageXHDPIurl.'","'.$imageXXHDPIurl.'","'.$imageXXXHDPIurl.'","'.$download_url.'","'.$category.'","'.$imageXurl.'")';	
				$stmt22 = $dbcon->prepare($sql22, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));	
				$res22=$stmt22->execute();
				$stmt22=null;

				$sql23='INSERT INTO bouquet_vs_channels(channel_id,bouquet_id,created_datetime) VALUES('.$channelid.','.$bouquetid.')';	
				$stmt23 = $dbcon->prepare($sql23, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));	
				$res23=$stmt23->execute();
				$stmt23=null;
	if($res22)
	{
	echo "Success...<br>";
	echo "Inserted:".$dbcon->lastInsertId();
		
	
	}
	else
	{
	echo "Failed";
	print_r($stmt22->errorInfo(),true);
	}

				
				$msg = "<span style='color:green'>Channel added Successfully</span>";				
	
			} else{					
				$msg = "<span style='color:red'>Problem with Channel logo. Please try again.</span>";
			}
			
		}			
	}
}


if(isset($_POST['Edit_Submit'])){

	$channelid=trim($_POST['channelid']);
	
	
	$channelname=trim($_POST['channelname']);

	$url=trim($_POST['octo_url_full']);
	$octo_js=trim($_POST['octo_js']);	

	$metadate=trim($_POST['metadata']);
	$metadesc=trim($_POST['metadesc']);	
	$status=trim($_POST['status']);
	$date = gmdate("Y-m-d H:i:s");
	
	//$stmt21 = $dbcon->prepare('SELECT id FROM customer_info WHERE id != '.$customerid.' AND (mobile = "'.$phone.'" OR customername = "'.$customername.'" OR email = "'.$email.'" OR channel_id = "'.$channel.'")', array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));	
	$stmt21 = $dbcon->prepare('SELECT * FROM channels WHERE id != '.$channelid.' AND (name = "'.$channelname.'" OR url = "'.$url.'" OR octo_js = "'.$octo_js.'")', array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt21->execute();
	$result21 = $stmt21->fetchAll(PDO::FETCH_ASSOC);	
	//$userexit = $result21['id']; 
	$userexit = count($result21);
	if((int)$userexit > 0){
		
		$msg1="";

		$stmt212 = $dbcon->prepare('SELECT * FROM channels WHERE id != '.$channelid.' AND (name = "'.$channelname.'")', array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));	
		$stmt212->execute();
		$result212 = $stmt212->fetchAll(PDO::FETCH_ASSOC);
		$channameexist = count($result212);

		if((int)$channameexist > 0){	
			$msg1.= "<i class='fa fa-arrow-right' aria-hidden='true'></i> Channel Name already exist <br>";}

		$stmt211 = $dbcon->prepare('SELECT * FROM channels WHERE id != '.$channelid.' AND url = "'.$url.'"', array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));	
		$stmt211->execute();
		$result211 = $stmt211->fetchAll(PDO::FETCH_ASSOC);
		$urlexist = count($result211);	
//echo $userexit;	
//exit;
		//echo "channel exist:".$chanexist;
		if((int)$urlexist > 0){	
			$msg1.= "<i class='fa fa-arrow-right' aria-hidden='true'></i> Channel URL already exist <br>";}

		$stmt213 = $dbcon->prepare('SELECT * FROM channels WHERE octo_js = "'.$octo_js.'"', array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));	
		$stmt213->execute();
		$result213 = $stmt213->fetchAll(PDO::FETCH_ASSOC);
		$octo_jsexist = count($result213);	
//echo $userexit;	
//exit;
		//echo "channel exist:".$chanexist;
		if((int)$octo_jsexist > 0){	
			$msg1.= "<i class='fa fa-arrow-right' aria-hidden='true'></i> Channel Octo js already exist <br>";}


		$msg = "<span id='msg' style='color:red'>".$msg1."</span>";
		
	}else{
		
		if ($_FILES["logofile"]["error"] > 0 && $_FILES["logofile"]["error"] != "4"){
			$msg = "<span style='color:red'>Problem with Channel Logo. Please try again.</span>";
		}else{	

			if($_FILES["logofile"]["name"] !=""){

				$select_q_content = "SELECT * FROM channels WHERE `id` = :id";
				$select_query = $dbcon->prepare($select_q_content);
				$select_query->bindParam(":id",$channelid);
				$select_query->execute();
				if($select_query->rowCount() > 0){
					$cData = $select_query->fetch(PDO::FETCH_ASSOC);

					if($cData["image"]!=""){
						$req_image_path = "channel_logo/".$cData["image"];
						if (file_exists($req_image_path)){
							unlink($req_image_path);
						}
					}		
				}
				
				$present_time = date("dmYHis");
				$image_extention = explode("/",$_FILES["logofile"]["type"]);
				$sNewFileName = $present_time.".".$image_extention[1];

				if(move_uploaded_file($_FILES["logofile"]["tmp_name"],"channel_logo/".$sNewFileName)){

					//update query
					$stmt22 = $dbcon->prepare('UPDATE channels SET name = "'.$channelname.'", url = "'.$url.'",octo_js = "'.$octo_js.'",meta_data = "'.$metadata.'", meta_description = "'.$meta_desc.'", image = "'.$sNewFileName.'", status = "'.$status.'",updated_datetime = "'.$date.'" WHERE id = '.$channelid, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));	 
					$stmt22->execute();

					$msg = "<span style='color:green'>Channel updated Successfully</span>";

				} else{					
					$msg = "<span style='color:red'>Problem with channel logo. Please try again.</span>";
				}

			}else{

				//update querybouquetid
				$stmt22 = $dbcon->prepare('UPDATE channels SET name = "'.$channelname.'", url = "'.$url.'",octo_js = "'.$octo_js.'", meta_data = "'.$metadata.'", meta_description = "'.$meta_desc.'", status = "'.$status.'",updated_datetime = "'.$date.'" WHERE id = '.$channelid, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));	 
				$stmt22->execute();

				$msg = "<span style='color:green'>Channel updated Successfully</span>";

			}								
			
		}								
	}		
}	


if(isset($_REQUEST['editChannel'])){

	$id = $_REQUEST['editChannelid'];		

//echo $id;
//exit;		

	$stmt1 = $dbcon->prepare("SELECT * FROM channels where id='".$id."'", array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt1->execute();
	$result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
	foreach($result1 as $row1){
		$channelid1=$row1['id'];
		$channelname1=$row1['name'];

		$url=trim($_POST['url']);
	$octo_js=trim($_POST['octo_js']);

		$metadata1=$row1['meta_data'];
		$metadesc1=$row1['meta_description'];
		$logo1=$row1['image'];
		$status1=$row1['status'];
	}

		
	$action = "Edit";
	//echo $action;

}	
chanid

?>


<style>
.xoouserultra-field-value, .xoouserultra-field-type{
	width: unset !important;
	padding: 5px;
}
.xoouserultra-field-value input[type="file"]{
	display:block;
}

form[name="f_timezone"] {
    display: none;
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
					 <label class="control-label">Bouquet</label>
					<select <?php if($action == 'Edit'){ echo "disabled"; } ?> onchange=updateChanName(this.value,this.options[this.selectedIndex].innerHTML) onclick="clearError()" class="form-control underlined" id="boqid" name="boqid">
					<option value="">SELECT Bouquet</option>
					<?php 
					$sql5="select ID,name from bouquets";
					$boqs=get_all($sql5);
					foreach($boqs as $boq){
						$boqselected = ($boqid1 == $boq['id']) ? 'selected="selected" ' : "";
					?>
						<option <?php echo $boqselected ?> value="<?php echo $boq['id'] ?>"><?php echo $boq['name'] ?></option>
					<?php
					}
					?>
					</select>
                     </div>         
					
					<div class="form-group">
							<label class="control-label">Url</label>
							<input id="octo_url" class="form-control underlined" onclick="clearError()" type="text" alt="" value="<?php echo @$url1;?>" id="url" name="url" />	<input type="button" onclick="get_octo()" value="Get Full URL"/><span id="octo_url_full"></span>
					</div>
					<div class="form-group">
							<label class="control-label">Octo js</label>
							<textarea class="form-control underlined" rows="4" cols="50"  onclick="clearError()" type="text" alt=""  value="<?php echo @$octo_js1;?>" id="octo_js" name="octo_js"></textarea>*Click on "Get Full URL", copy the code and click "Go For JS" and use it there to get js
					</div>

					<div class="form-group">
							<label class="control-label">Vod Url</label>
							<input id="octo_url" class="form-control underlined" onclick="clearError()" type="text" alt="" value="<?php echo @$vodurl1;?>" id="vodurl" name="vodurl" />	<input type="button" onclick="get_octo()" value="Get Full URL"/><span id="vodocto_url_full"></span>
					</div>
					<div class="form-group">
							<label class="control-label">Vod Octo js</label>
							<textarea class="form-control underlined" rows="4" cols="50"  onclick="clearError()" type="text" alt=""  value="<?php echo @$vodocto_js1;?>" id="vodocto_js" name="vodocto_js"></textarea>*Click on "Get Full URL", copy the code and click "Go For JS" and use it there to get js
					</div>


					<div class="form-group">
							<label class="control-label">Short Vod Url</label>
							<input id="octo_url" class="form-control underlined" onclick="clearError()" type="text" alt="" value="<?php echo @$short_vodurl1;?>" id="short_vodurl" name="short_vodurl" />	<input type="button" onclick="get_octo()" value="Get Full URL"/><span id="shortvodocto_url_full"></span>
					</div>
					<div class="form-group">
							<label class="control-label">Short Vod Octo js</label>
							<textarea class="form-control underlined" rows="4" cols="50"  onclick="clearError()" type="text" alt=""  value="<?php echo @$short_vodocto_js1;?>" id="short_vodocto_js" name="short_vodocto_js"></textarea>*Click on "Get Full URL", copy the code and click "Go For JS" and use it there to get js
					</div>
							
							
					<div class="form-group"> <label class="control-label">Logo (path)</label> 

					<?php
						 if($logo1 !="" ) { echo '<img src="'.@UPLOAD_FOLDER1.$logo1.'" style="max-height:100px;max-width:200px;">'; } ?>
					<input onclick="clearError()" type="file" accept="image/*" id="logofile" name="logofile" class="form-control underlined"> </div>

					<div class="form-group"> <label class="control-label">Meta Data</label> <input onclick="clearError()" type="text" value="<?php echo @$metadata1;?>" id="metadata" name="metadata" class="form-control underlined" > </div>
										
					<div class="form-group"> <label class="control-label">Meta Description</label> <textarea rows="4" cols="50" onclick="clearError()" alt="" placeholder="Ex:Bengali Bouquet consists of channels from both WestBengal and Bangladesh" value="<?php echo @$metadesc1;?>"  id="metadesc" name="metadesc" class="form-control underlined"><?php echo @$metadesc1;?></textarea></div>

					<div class="form-group"> <label class="control-label">Channel Status</label> 
					
									<select name="status" alt="" id="status" onclick="clearError()" class="form-control underlined">
									<option value="">-Set Channel Status-</option>
									<?php
									//$selected = ($row['status'] == $status1) ? "selected='selected'" : "";									
									for($i=0;$i<=1;$i++)
									{
										$selected = ($i == $status1) ? "selected='selected'" : "";
										$ival = ($i == 1) ? "Active" : "Inactive";
										echo "<option value='".$i."'".$selected.">".$ival."</option>";
									}
									
									?>
								</select>
									</div>	
						

					<?php //if($action=="Add") { ?>
					<div ><h4>Android Images</h4>
					<div class="form-group"> <label class="control-label">LDPI Logo (path)</label> 
					<?php if($ldpi_logo1 !="" ) { echo '<img src="'.@UPLOAD_FOLDER1.$ldpi_logo1.'" style="max-height:100px;max-width:200px;">'; } ?>
					<input onclick="clearError()" type="file" accept="image/*" id="ldpi_logofile" name="ldpi_logofile" class="form-control underlined"> 
					 <label class="control-label">MDPI Logo (path)</label> 
					<?php if($mdpi_logo1 !="" ) { echo '<img src="'.@UPLOAD_FOLDER1.$mdpi_logo1.'" style="max-height:100px;max-width:200px;">'; } ?>
					<input onclick="clearError()" type="file" accept="image/*" id="mdpi_logofile" name="mdpi_logofile" class="form-control underlined"> 
					<label class="control-label">HDPI Logo (path)</label> 
					<?php if($hdpi_logo1 !="" ) { echo '<img src="'.@UPLOAD_FOLDER1.$hdpi_logo1.'" style="max-height:100px;max-width:200px;">'; } ?>
					<input onclick="clearError()" type="file" accept="image/*" id="hdpi_logofile" name="hdpi_logofile" class="form-control underlined"> 
					 <label class="control-label">XHDPI Logo (path)</label> 
					<?php if($xhdpi_logo1 !="" ) { echo '<img src="'.@UPLOAD_FOLDER1.$xhdpi_logo1.'" style="max-height:100px;max-width:200px;">'; } ?>
					<input onclick="clearError()" type="file" accept="image/*" id="xhdpi_logofile" name="xhdpi_logofile" class="form-control underlined"> 
					<label class="control-label">XXHDPI Logo (path)</label> 
					<?php if($xxhdpi_logo1 !="" ) { echo '<img src="'.@UPLOAD_FOLDER1.$xxhdpi_logo1.'" style="max-height:100px;max-width:200px;">'; } ?>
					<input onclick="clearError()" type="file" accept="image/*" id="xxhdpi_logofile" name="xxhdpi_logofile" class="form-control underlined"> 
					<label class="control-label">XXXHDPI Logo (path)</label> 
					<?php if($xxxhdpi_logo1 !="" ) { echo '<img src="'.@UPLOAD_FOLDER1.$xxxhdpi_logo1.'" style="max-height:100px;max-width:200px;">'; } ?>
					<input onclick="clearError()" type="file" accept="image/*" id="xxxhdpi_logofile" name="xxxhdpi_logofile" class="form-control underlined"> </div>
                    </div>
					

					<div><h4>iOS Images</h4>
					<div class="form-group"> <label class="control-label">XURL Logo (path)</label> 
					<?php if($xurl_logo1 !="" ) { echo '<img src="'.@UPLOAD_FOLDER1.$xurl_logo1.'" style="max-height:100px;max-width:200px;">'; } ?>
					<input onclick="clearError()" type="file" accept="image/*" id="xurl_logofile" name="xurl_logofile" class="form-control underlined"> 
					<label class="control-label">2XURL Logo (path)</label> 
					<?php if($xurl2_logo1 !="" ) { echo '<img src="'.@UPLOAD_FOLDER1.$xurl2_logo1.'" style="max-height:100px;max-width:200px;">'; } ?>
					<input onclick="clearError()" type="file" accept="image/*" id="2xurl_logofile" name="2xurl_logofile" class="form-control underlined"> 
					 <label class="control-label">3XURL Logo (path)</label> 
					<?php if($xurl3_logo1 !="" ) { echo '<img src="'.@UPLOAD_FOLDER1.$xurl3_logo1.'" style="max-height:100px;max-width:200px;">'; } ?>
					<input onclick="clearError()" type="file" accept="image/*" id="3xurl_logofile" name="3xurl_logofile" class="form-control underlined"> </div>
                    </div>
					<?php //} ?>        
                                        
                                     
                                        
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
					<th>Channel Name</th>
					<th>URL Details</th>
					<th>Logo</th>
					<th>Meta Data</th>
					<th>Meta Description</th>					
					<th>Status</th>
					<th>Category</th>
					
					
					<?php		if($_SESSION['adminlevel']<1)
{ ?> <th>Action</th> <?php } ?>
				</tr>
			</thead>
			<tbody id="chan_list" class="ui-sortable">
			<?php
			$sql4 = "SELECT * FROM channels";	
			$result4 = get_all($sql4);
						
			foreach($result4 as $row){

				$id=$row['id'];
				$channelname=$row['name'];
				$metadata=$row['meta_data'];
				$metadesc=$row['meta_description'];


				$deviceInfo = "<strong>OS Name: </strong>".$analytics["os_name"];
						$deviceInfo .= "<br><strong>OS Version: </strong>".$analytics["os_version"];
						$deviceInfo .= "<br><strong>Browser Name: </strong>".$analytics["browser_name"];
						$deviceInfo .= "<br><strong>Browser Version: </strong>".$analytics["browser_version"];

				$url_details="<strong>URL :</strong> ".$row['url'];
				$url_details.="<br><strong>VOD-URL :</strong> ".$row['vodurl'];
				$url_details.="<br><strong>Short-VOD-URL :</strong> ".$row['short_vodurl'];
				$url_details.="<br><strong>JS :</strong> ".$row['octo_js'];
				$url_details.="<br><strong>VOD-JS :</strong> ".$row['vod_octo_js'];
				$url_details.="<br><strong>Short-VOD-JS : </strong>".$row['short_vod_octo_js'];

				
				$logo = $row['imageurl'];
				$stat = $row['status'];
				if($stat==1)
				{$status="Active";}
				if($stat==0)
				{$status="Inactive";}

				$category = $row['category'];

				if($row['is_admin'] != 1){
			?>
				<tr style="" class="ui-sortable-handle">							
				<td style="width: 342px;color:blue;" class="level_name"><a style="color:blue;"><?php echo $channelname;?></a></td>
				<td style='width:150px'><?php echo $row['url'] ?><a href='javascript:void(0)' class='tooltip'>  <i class='fa fa-info-circle' aria-hidden='true'></i> <span style="width: 100%;"><?php echo $url_details ?></span></a></td>
				<td style="width: 192px;"><img height="50px" width="150px" src="<?php echo UPLOAD_FOLDER1.$logo;?>"></td>
							
				<td style="width: 184px;"><?php echo $metadata;?></td>				
				<td style="width: 192px;"><?php echo $metadesc;?></td>
				<td style="width: 192px;"><?php echo $status;?></td>
				<td style="width: 192px;"><?php echo $category;?></td>	
				
				
<?php		if($_SESSION['adminlevel']<1)
{ ?>

				
				<td style="width: 332px;">


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
		

<script>
function updateChanName(chanid,channame){

		jQuery('#channelname').val(channame);
}


function validateEmail(email) {
	var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test(email);
}

function validatePhone(phone) {
	var re = /^([0|\+[0-9]{1,5})?([1-9][0-9]{9})$/;
	return re.test(phone);
}

function callsubmit(){	
	return true;
	var customerid = jQuery("#customerid").val();
	var email = jQuery("#email").val();
	var customername = jQuery("#customername").val();
	var phone = jQuery("#phone").val();
	var logo = jQuery("#logofile").val();
	var channel = jQuery("#channel").val();


	if(customername == ""){
		jQuery("#error").html("Please enter Broadcaster name");return false;		
	}
	
			
	if(phone == ""){
		jQuery("#error").html("Please enter phone no");
		return false;		
	}else if (!validatePhone(phone)) {

		jQuery("#error").html("Please enter valid phone no");
		return false;
			
			}


	 if(email == ""){
		jQuery("#error").html("Please enter email address");	
		return false;	
	}else if (!validateEmail(email)) {
		jQuery("#error").html("Please enter valid email address");
		return false;	
	}

	 if(logo == "" && customerid == ""){
		jQuery("#error").html("Please select logo file");	return false;		
	}

	 if(channel == ""){
		jQuery("#error").html("Please choose channel");		return false;	
	}

	if(customername != "" && phone != "" && email != "" && (logo != "" || customerid != "") && channel != ""){
		if (validateEmail(email)) {
			if (validatePhone(phone)) {
				return true;
			
			} else {
				jQuery("#error").html("Please enter valid phone no");
			}
			
		} else {
			jQuery("#error").html("Please enter valid email address");
		}
	}
	return false;
}





		function clearError()
		{

		jQuery("#error").html("");
		jQuery(".msg h4").html("");		
	
		}	
	
function confirmDelChannel(Delid)
{

 swal({
 		title:' ', 
  text: 'Do you really want to remove this Channel?',
  type: 'warning',
  
  showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Remove",   cancelButtonText: "Cancel",  closeOnCancel: true
},function(){ 

var input1 = jQuery("<input>")
               .attr("type", "hidden")
               .attr("name", "delChannelid").val(Delid);
var input2 = jQuery("<input>")
               .attr("type", "hidden")
               .attr("name", "delChannel").val(true);
jQuery('#frm2').append(jQuery(input1));
jQuery('#frm2').append(jQuery(input2));
 jQuery("#frm2").submit();

}); 

}



function confirmEditChannel(Editid)
{

 swal({
 		title:' ', 
  text: 'Do you want to edit this Channel?',
  type: 'warning',
  
  showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Edit",   cancelButtonText: "Cancel",  closeOnCancel: true
},function(){ 

var input1 = jQuery("<input>")
               .attr("type", "hidden")
               .attr("name", "editChannelid").val(Editid);
var input2 = jQuery("<input>")
               .attr("type", "hidden")
               .attr("name", "editChannel").val(true);
jQuery('#frm2').append(jQuery(input1));
jQuery('#frm2').append(jQuery(input2));
 jQuery("#frm2").submit();

}); 

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

setTimeout(function(){
  jQuery("#msg").html("");
}, 3000);
</script>
<?php

include('footer.php');
?>
