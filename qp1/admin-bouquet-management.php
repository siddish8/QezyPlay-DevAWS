<?php 
	include('header.php');
?>
<style>


</style>

<article class="content items-list-page">
<h2>*Edit Bouquets (mainly images) doesnt work for now</h2>
    <?php


if($_SESSION['adminlevel']>0)
{
//header("Location:".SITE_URL."/qp/admin-main.php");
//exit;
}


$msg = ""; $action = "Add";


if(isset($_REQUEST['delBoq'])){

	$id = $_REQUEST['delBoqid'];
//echo $id;
//exit;

	$stmt11 = $dbcon->prepare("DELETE FROM bouquets WHERE id = ".$id."", array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt11->execute();
	
	$msg = "<span style='color:green'>Bouquet deleted Successfully</span>";
	
}


if(isset($_POST['Add_Submit'])){
	
	$bouquetid=trim($_POST['boqid']);
	$bouquetname=$bouquetname2=trim($_POST['bouquetname']);
	$bouquetname=strtolower(preg_replace('/\s+/', '', $bouquetname));	
	$metadata=trim($_POST['metadata']);
	$metadesc=trim($_POST['metadesc']);	
	$status=trim($_POST['status']);
	$is_free=trim($_POST['is_free']);

	$date = gmdate("Y-m-d H:i:s");
	$download_url=UPLOAD_FOLDER1;
	$userexit=0;

	
	$sql='SELECT * FROM bouquets WHERE LOWER(REPLACE(name," ","")) = "'.$bouquetname.'"';
	$stmt21 = $dbcon->prepare('SELECT * FROM bouquets WHERE LOWER(REPLACE(name," ","")) = "'.$bouquetname.'" ', array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));	
	$stmt21->execute();
	$result21 = $stmt21->fetchAll(PDO::FETCH_ASSOC);
	$userexit = count($result21);


	//echo "yes:".$userexit;

	if((int)$userexit > 0){
		
		$msg1="";

			$msg1.= "<i class='fa fa-arrow-right' aria-hidden='true'></i> Bouquet already exist <br>";
			$msg = "<span id='msg' style='color:red'>".$msg1."</span>";
				
	}else{	
		//echo "NEW";
		if ($_FILES["logofile"]["error"] > 0){
			$msg = "<span style='color:red'>Problem with Bouquet image. Please try again.</span>";
		}else{
			/*$present_time = date("dmYHis");
			$image_extention = explode("/",$_FILES["logofile"]["type"]);
			$sNewFileName = $present_time.".".$image_extention[1];		
											
			if(move_uploaded_file($_FILES["logofile"]["tmp_name"],"bouquet_logo/".$sNewFileName)){*/
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
				$sql22='INSERT INTO bouquets(id,name,imageUrl,meta_data,meta_description,is_free,status,created_datetime,image2xUrl,image3xUrl,imagehdpiUrl,imageldpiUrl,imagemdpiUrl,imagexhdpiUrl,imagexxhdpiUrl,imagexxxhdpiUrl,downloadUrl,imagexUrl) VALUES('.$bouquetid.',"'.$bouquetname2.'","'.$imageUrl.'","'.$metadata.'","'.$metadesc.'","'.$is_free.'","'.$status.'","'.$date.'","'.$image2Xurl.'","'.$image3Xurl.'","'.$imageHDPIurl.'","'.$imageLDPIurl.'","'.$imageMDPIurl.'","'.$imageXHDPIurl.'","'.$imageXXHDPIurl.'","'.$imageXXXHDPIurl.'","'.$download_url.'","'.$imageXurl.'")';
				$stmt22 = $dbcon->prepare($sql22, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));	
				$res22=$stmt22->execute();
				if($res22)
				{
				//echo "Success...<br>";
				//echo "Inserted:".$dbcon->lastInsertId();				
				
				}
				else
				{
				//echo "Failed";
				//print_r($stmt22->errorInfo(),true);
				}

				
				$msg = "<span style='color:green'>Bouquet added Successfully</span>";				
	
			} else{					
				$msg = "<span style='color:red'>Problem with Bouquet image. Please try again.</span>";
			}
			
		}			
	}
}


if(isset($_POST['Edit_Submit'])){

	$bouquetid=trim($_POST['bouquetid']);	
	
	$bouquetname=trim($_POST['bouquetname']);
	$metadata=trim($_POST['metadata']);
	$metadesc=trim($_POST['metadesc']);	
	$status=trim($_POST['status']);
	$is_free=trim($_POST['is_free']);
	$date = gmdate("Y-m-d H:i:s");
	
	//$stmt21 = $dbcon->prepare('SELECT id FROM customer_info WHERE id != '.$customerid.' AND (mobile = "'.$phone.'" OR customername = "'.$customername.'" OR email = "'.$email.'" OR channel_id = "'.$channel.'")', array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));	
	$stmt21 = $dbcon->prepare('SELECT * FROM bouquets WHERE id != '.$bouquetid.' AND (name = "'.$bouquetname.'")', array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt21->execute();
	$result21 = $stmt21->fetchAll(PDO::FETCH_ASSOC);	
	//$userexit = $result21['id']; 
	$userexit = count($result21);
	if((int)$userexit > 0){
		
		$msg1="";
		$msg1.= "<i class='fa fa-arrow-right' aria-hidden='true'></i> Bouquet already exist <br>";
		$msg = "<span id='msg' style='color:red'>".$msg1."</span>";
		
	}else{

			if($_FILES["logofile"]["error"] < 1){

			
			/*$present_time = date("dmYHis");
			$image_extention = explode("/",$_FILES["logofile"]["type"]);
			$sNewFileName = $present_time.".".$image_extention[1];		
											
			if(move_uploaded_file($_FILES["logofile"]["tmp_name"],"bouquet_logo/".$sNewFileName)){*/
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
				//$sql22='INSERT INTO bouquets(id,name,imageUrl,meta_data,meta_description,is_free,status,created_datetime,image2xUrl,image3xUrl,imagehdpiUrl,imageldpiUrl,imagemdpiUrl,imagexhdpiUrl,imagexxhdpiUrl,imagexxxhdpiUrl,downloadUrl,imagexUrl) VALUES('.$bouquetid.',"'.$bouquetname2.'","'.$imageUrl.'","'.$metadata.'","'.$metadesc.'","'.$is_free.'","'.$status.'","'.$date.'","'.$image2Xurl.'","'.$image3Xurl.'","'.$imageHDPIurl.'","'.$imageLDPIurl.'","'.$imageMDPIurl.'","'.$imageXHDPIurl.'","'.$imageXXHDPIurl.'","'.$imageXXXHDPIurl.'","'.$download_url.'","'.$imageXurl.'")';				
				$sql22='UPDATE bouquets SET imageUrl = "'.$imageUrl.'",meta_data = "'.$metadata.'", meta_description = "'.$metadesc.'", is_free = "'.$is_free.'", status = "'.$status.'", image2xUrl = "'.$image2Xurl.'", image3xUrl = "'.$image3Xurl.'", imagehdpiUrl = "'.$imageHDPIurl.'", imageldpiUrl = "'.$imageLDPIurl.'", imagemdpiUrl = "'.$imageMDPIurl.'", imagexhdpiUrl = "'.$imageXHDPIurl.'", imagexxhdpiUrl = "'.$imageXXHDPIurl.'", imagexxxhdpiUrl = "'.$imageXXXHDPIurl.'", imagexUrl = "'.$imageXurl.'" WHERE id = '.$bouquetid;
				$stmt22 = $dbcon->prepare($sql22, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));	
				$res22=$stmt22->execute();
				if($res22){
				//echo "Success...<br>";
				//echo "Inserted:".$dbcon->lastInsertId();				
				}else{
				//echo "Failed";uet image2. Please try again.
				//print_r($stmt22->errorInfo(),true);
				}				
				$msg = "<span style='color:green'>Bouquet added Successfully</span>";				
	
			}else{
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
				//$sql22='INSERT INTO bouquets(id,name,imageUrl,meta_data,meta_description,is_free,status,created_datetime,image2xUrl,image3xUrl,imagehdpiUrl,imageldpiUrl,imagemdpiUrl,imagexhdpiUrl,imagexxhdpiUrl,imagexxxhdpiUrl,downloadUrl,imagexUrl) VALUES('.$bouquetid.',"'.$bouquetname2.'","'.$imageUrl.'","'.$metadata.'","'.$metadesc.'","'.$is_free.'","'.$status.'","'.$date.'","'.$image2Xurl.'","'.$image3Xurl.'","'.$imageHDPIurl.'","'.$imageLDPIurl.'","'.$imageMDPIurl.'","'.$imageXHDPIurl.'","'.$imageXXHDPIurl.'","'.$imageXXXHDPIurl.'","'.$download_url.'","'.$imageXurl.'")';				
				$sql22='UPDATE bouquets SET meta_data = "'.$metadata.'", meta_description = "'.$metadesc.'", is_free = "'.$is_free.'", status = "'.$status.'", image2xUrl = "'.$image2Xurl.'", image3xUrl = "'.$image3Xurl.'", imagehdpiUrl = "'.$imageHDPIurl.'", imageldpiUrl = "'.$imageLDPIurl.'", imagemdpiUrl = "'.$imageMDPIurl.'", imagexhdpiUrl = "'.$imageXHDPIurl.'", imagexxhdpiUrl = "'.$imageXXHDPIurl.'", imagexxxhdpiUrl = "'.$imageXXXHDPIurl.'" WHERE id = '.$bouquetid;
				$stmt22 = $dbcon->prepare($sql22, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));	
				$res22=$stmt22->execute();

				//echo $_FILES["logofile"]["error"];
				
			}
			}else{
				echo $sql22='UPDATE bouquets SET meta_data = "'.$metadata.'", meta_description = "'.$metadesc.'", is_free = "'.$is_free.'", status = "'.$status.'" WHERE id = '.$bouquetid.'';
				$stmt22 = $dbcon->prepare($sql22, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));	
				$res22=$stmt22->execute();

				$msg = "<span style='color:red'>Problem with Bouquet image2. Please try again.</span>";

			}
			
		}			
	}
	



if(isset($_REQUEST['editBouquet'])){

	$id = $_REQUEST['editBouquetid'];		

//echo $id;
//exit;		

	$stmt1 = $dbcon->prepare("SELECT * FROM bouquets where id='".$id."'", array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt1->execute();
	$result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
	foreach($result1 as $row1){
		$bouquetid1=$row1['id'];
		$bouquetname1=$row1['name'];
		$metadata1=$row1['meta_data'];
		$metadesc1=$row1['meta_description'];

		$logo1=$row1['imageUrl'];

		$xurl_logo1=$row1['imagexUrl'];
		$xurl2_logo1=$row1['image2xUrl'];
		$xurl3_logo1=$row1['image3xUrl'];

		$ldpi_logo1=$row1['imageldpiUrl'];
		$mdpi_logo1=$row1['imagemdpiUrl'];
		$hdpi_logo1=$row1['imagehdpiUrl'];
		$xhdpi_logo1=$row1['imagexhdpiUrl'];
		$xxhdpi_logo1=$row1['imagexxhdpiUrl'];
		$xxxhdpi_logo1=$row1['imagexxxhdpiUrl'];

		$status1=$row1['status'];
		$is_free1=$row1['is_free'];
	}

		
	$action = "Edit";
	//echo $action;

}	


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

<h2 style="text-align:center">Bouquet Management</h2>
<?php		if($_SESSION['adminlevel']<1)
{ 

if ($action=="Edit"){ echo "<style>#add_boq_btn{display:none} #boq-form-section{display:block !important;}</style>";}
?>	
<section class="section">
<span style="float:"></span><div class="msg" align="center" style="display:inline-block"><h4><?php echo $msg;?></h4></div>
                        <div class="row sameheight-container">
				 <div class="col-md-3">
                             
				<button id="add_boq_btn" class="btn btn-primary" onclick="return boq_form()">Add New Bouquet</button>

                            </div>
                            <div class="col-md-6">
                                <div id="boq-form-section" class="card card-block sameheight-item" style="display:none;height:auto !important;/*height: 721px;*/">
                                   <div class="card card-primary">
					<div class="card-header">
                                        <div class="header-block">
                                            <p class="title"> <?php echo $action; ?> Bouquet </p>
                                        </div>
                                    </div>
				     <div class="xoouserultra-field-value" style="">
						<div id='error' style='color:red;'></div>
					</div>
					<div class="card-block">
                                    <form role="form" method='post' enctype="multipart/form-data">
					<!-- <input type="hidden" id="boqid" name="boqid" value="<?php echo $id; ?>"/> -->
					<div class="form-group"> <label class="control-label">Bouquet Name</label>
					<select <?php if($action == 'Edit'){ echo "disabled"; } ?> onchange=updateBoqName(this.value,this.options[this.selectedIndex].innerHTML) onclick="clearError()" class="form-control underlined" id="boqid" name="boqid">
					<option value="">SELECT Bouquet</option>
					<?php 
					$sql5="SELECT a.term_id,a.name FROM wp_terms a inner join wp_term_taxonomy b on a.term_id=b.term_taxonomy_id where b.taxonomy='category'";
					$boqs=get_all($sql5);
					foreach($boqs as $boq){
						$boqselected = ($bouquetid1 == $boq['term_id']) ? 'selected="selected" ' : "";
						?>

						<option <?php echo $boqselected ?> value="<?php echo $boq['term_id'] ?>"><?php echo $boq['name']?></option>
						<?php
					}

					?>
                     </div>
					 <div class="form-group">
					 <input type="hidden" id="bouquetid" name="bouquetid" value="<?php echo $id; ?>
					 <input type="hidden" id="bouquetname" name="bouquetname" value=""></div>             
					

					<div class="form-group"> <label class="control-label">Logo (path)</label> 

					<?php
						 if($logo1 !="" ) { echo '<img src="'.@UPLOAD_FOLDER1.$logo1.'" style="max-height:100px;max-width:200px;">'; } ?>
					<input onclick="clearError()" type="file" accept="image/*" id="logofile" name="logofile" class="form-control underlined"> </div>

					<div class="form-group"> <label class="control-label">Meta Data</label> <input onclick="clearError()" type="text" value="<?php echo @$metadata1;?>" id="metadata" name="metadata" class="form-control underlined" > </div>
										
					<div class="form-group"> <label class="control-label">Meta Description</label> <textarea rows="4" cols="50" onclick="clearError()" alt="" placeholder="Ex:Bengali Bouquet consists of channels from both WestBengal and Bangladesh" value="<?php echo @$metadesc1;?>"  id="metadesc" name="metadesc" class="form-control underlined"><?php echo @$metadesc1;?></textarea></div>

					<div class="form-group"> <label class="control-label">Bouquet Status</label> 
					
									<select name="status" alt="" id="status" onclick="clearError()" class="form-control underlined">
									<option value="">-Set Bouquet Status-</option>
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
					<div class="form-group"> <label class="control-label">Bouquet Paid/Free</label> 
					
									<select name="is_free" alt="" id="is_free" onclick="clearError()" class="form-control underlined">
									<option value="">-Set Bouquet Free/Paid-</option>
									<?php
									//$selected = ($row['status'] == $is_free1) ? "selected='selected'" : "";									
									for($i=0;$i<=1;$i++)
									{
										$selected = ($i == $status1) ? "selected='selected'" : "";
										$ival = ($i == 1) ? "Free" : "Paid";
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
								<input type="hidden" name="editBoq"  value="true" />
								<input type="hidden" name="editBoqid"  value="<?php echo @$boqid1;?>" />
								<?php } ?>
								<input class="btn btn-primary" type="submit" onclick="return callsubmit();" name="<?php echo $action;?>_Submit"  value="Submit" />
								<?php if($action=="Edit"){?>
								<a class="btn btn-primary" href="<?php echo SITE_URL.'/qp1/admin-bouquet-management.php'?>">Back</a>
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
                                            <h3 class="title"bouquetid>
							Bouquets
						</h3> </div>
                                        <section class="example">		
		<form id="frm2" method="post">
		 <div class="table-responsive">
                                                <table class="table table-striped table-bordered table-hover">
		
			<thead>
				<tr>					
					<th>Bouquet Name</th>
					<th>Logo</th>
					<th>Meta Data</th>
					<th>Meta Description</th>					
					<th>Status</th>
					
					
					<?php		if($_SESSION['adminlevel']<1)
{ ?> <th>Action</th> <?php } ?>
				</tr>
			</thead>
			<tbody id="boq_list" class="ui-sortable">
			<?php
			$sql4 = "SELECT * FROM bouquets";	
			$result4 = get_all($sql4);
						
			foreach($result4 as $row){

				$id=$row['id'];
				$bouquetname=$row['name'];
				$metadata=$row['meta_data'];
				$metadesc=$row['meta_description'];
				
				$logo = $row['imageUrl'];
				$stat = $row['status'];
				if($stat==1)
				{$status="Active";}
				if($stat==0)
				{$status="Inactive";}

				if($row['is_admin'] != 1){
			?>
				<tr style="" class="ui-sortable-handle">							
				<td style="width: 342px;color:blue;" class="level_name"><a style="color:blue;"><?php echo $bouquetname;?></a></td>
				<td style="width: 192px;"><img height="50px" width="150px" src="<?php echo UPLOAD_FOLDER1.$logo;?>"></td>
							
				<td style="width: 184px;"><?php echo $metadata;?></td>				
				<td style="width: 192px;"><?php echo $metadesc;?></td>
				<td style="width: 192px;"><?php echo $status;?></td>	
				
				
<?php		if($_SESSION['adminlevel']<1)
{ ?>

				
				<td style="width: 332px;">


<a style="cursor:pointer;color:blue;" id="editbouquet" name="editbouquet" onclick="return confirmEditBouquet(<?php echo $id;?>)">Edit</a>
&nbsp;
<a style="cursor:pointer;color:blue;" id="removebouquet" name="removebouquet" onclick="return confirmDelBouquet(<?php echo $id;?>)">Remove</a>	


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
function updateBoqName(boqid,boqname){

		jQuery('#bouquetname').val(boqname);
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
	
function confirmDelBouquet(Delid)
{

 swal({
 		title:' ', 
  text: 'Do you really want to remove this Bouquet?',
  type: 'warning',
  
  showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Remove",   cancelButtonText: "Cancel",  closeOnCancel: true
},function(){ 

var input1 = jQuery("<input>")
               .attr("type", "hidden")
               .attr("name", "delBoqid").val(Delid);
var input2 = jQuery("<input>")
               .attr("type", "hidden")
               .attr("name", "delBoq").val(true);
jQuery('#frm2').append(jQuery(input1));
jQuery('#frm2').append(jQuery(input2));
 jQuery("#frm2").submit();

}); 

}



function confirmEditBouquet(Editid)
{

 swal({
 		title:' ', 
  text: 'Do you want to edit this Bouquet?',
  type: 'warning',
  
  showCancelButton: true,   confirmButtonColor: "#DD6B55",   confirmButtonText: "Edit",   cancelButtonText: "Cancel",  closeOnCancel: true
},function(){ 

var input1 = jQuery("<input>")
               .attr("type", "hidden")
               .attr("name", "editBouquetid").val(Editid);
var input2 = jQuery("<input>")
               .attr("type", "hidden")
               .attr("name", "editBouquet").val(true);
jQuery('#frm2').append(jQuery(input1));
jQuery('#frm2').append(jQuery(input2));
 jQuery("#frm2").submit();

}); 

}


function boq_form(){

var s=document.getElementById("boq-form-section");

if(s.style.display=="none")
{
jQuery("#boq-form-section").show();
jQuery("#boq-form-section").css("height","auto");

}
else
{
jQuery("#boq-form-section").hide();
}
}

jQuery("#boq-form-section").css("height","auto");

setTimeout(function(){
  jQuery("#msg").html("");
}, 3000);
</script>

<?php

include('footer.php');
?>