<?php
include("header-broadcaster.php");
?>
<article class="content items-list-page">
<style>
svg{overflow:visible !important;}
</style>
<?php

	$searchstring = "";
	
	$start_limit = 0;
	@$page = isset($_GET['page']) ? $_GET['page'] : $_POST['page'];
	if (!isset($page))
	    $page = 1;

	if(isset($_POST['page1'])){

		@$page =	$_POST['page1'];
	}


	if ($page > 1)
	    $start_limit = (($page * ROW_PER_PAGE) - ROW_PER_PAGE);

	$mobileselected =  $pcselected = $cond = $filter = "";
	if($_REQUEST['device'] == "pc"){
		$cond .= " AND device = 'Personal Computer'";
		$pcselected = "selected='selected'";
		$filter.=" Device : Personal Computer | ";	
	}elseif($_REQUEST['device'] == "mobile"){
		$cond .= " AND device = 'Mobile'";
		$mobileselected = "selected='selected'";
		$filter.=" Device : Mobile | ";	
	}

	if($_REQUEST['country'] != ""){
		$cond .= " AND country_code = '".$_REQUEST['country']."'";
		$filter.=" Country : ".$_REQUEST['country']." | ";		
	}
	if($_REQUEST['state'] != ""){
		$cond .= " AND state = '".$_REQUEST['state']."'";
		$stateselected = "<option selected='selected' value='".$_REQUEST['state']."'>".$_REQUEST['state']."</option>";		
		$filter.=" State : ".$_REQUEST['state']." | ";
	}
	if($_REQUEST['city'] != ""){
		$cond .= " AND city = '".$_REQUEST['city']."'";
		$cityselected = "<option selected='selected' value='".$_REQUEST['city']."'>".$_REQUEST['city']."</option>";
		$filter.=" City : ".$_REQUEST['city']." | ";		
	}
	if($_REQUEST['startdate'] != ""){
		$cond .= " AND DATE(CONVERT_TZ(start_datetime,'+00:00','".$coockie."')) >= '".$_REQUEST['startdate']."'";
		$startdate = $_REQUEST['startdate'];	
		$filter.=" Startdate : ".$_REQUEST['startdate']." | ";		
	}
	if($_REQUEST['enddate'] != ""){
		$cond .= " AND DATE(CONVERT_TZ(end_datetime,'+00:00','".$coockie."')) <= '".$_REQUEST['enddate']."'";
		$enddate = $_REQUEST['enddate'];	
		$filter.=" Enddate : ".$_REQUEST['enddate']." | ";		
	}

	$channelId = $_SESSION['channelid'];
	$cond .= " AND page_id = ".$channelId;

	$sql1 = "SELECT count(*) as count,year(CONVERT_TZ(start_datetime,'+00:00','".$coockie."')) as year FROM visitors_info WHERE 1".$cond." GROUP BY year(CONVERT_TZ(start_datetime,'+00:00','".$coockie."'))";	
	$stmt1 = $dbcon->prepare($sql1, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt1->execute();
	$hits = $stmt1->fetchAll(PDO::FETCH_ASSOC);

	$sql2 = "SELECT sum(duration) as duration,year(CONVERT_TZ(start_datetime,'+00:00','".$coockie."')) as year FROM visitors_info WHERE 1 AND duration > 0 AND play = 1".$cond." GROUP BY year(CONVERT_TZ(start_datetime,'+00:00','".$coockie."'))";	
	$stmt2 = $dbcon->prepare($sql2, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt2->execute();
	$durations = $stmt2->fetchAll(PDO::FETCH_ASSOC);

	$countries = getCountries();
	
	
	?>
	<style>
	.xoouserultra-field-value, .xoouserultra-field-type{
		width: unset !important;
		padding: 5px;
	}
	</style>
	<link rel="stylesheet" href="css/jquery-ui.css">
	<link rel="stylesheet" href="css/morris.css">
	<script src="js/jquery-ui.js"></script>
	
	<script src="js/raphael-min.js"></script>
	<script src="js/morris.min.js"></script>
 	
	<section class="section">
                <span style="float:"></span>
                <div class="msg" align="center" style="display:inline-block">
                    <h4>
					
                        </h4>
                </div>
                <div class="row sameheight-container">
                    <div class="col-md-3">
                        
                    </div>
                    <div class="col-md-6">
                        <div id="filter-form-section" class="card card-block sameheight-item" style="height:auto;/*height: 721px;*/">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <div class="header-block">
                                        <p class="title">Yearly Statistics
                                            </p>
                                    </div>
                                </div>
                                <div class="xoouserultra-field-value" style="">
                                    <div id='error' style='color:red;'></div>
					</div>
					<div class="card-block ">
                                    <form role="form" id="xoouserultra-login-form-1" method='post' enctype="multipart/form-data">

										<div class="form-inline"> 
											<label class="control-label">Device</label> &nbsp; 
											<select class="form-control underlined" name="device">
												<option value=''>All</option>
												<option value='mobile' <?php echo $mobileselected; ?>>Mobile</option>
												<option value='pc' <?php echo $pcselected; ?>>Personal Computer</option>
											</select>	
										</div>
										<div class="form-inline"> 
											<label class="control-label">Country</label> &nbsp; 
											<select class="form-control underlined" onchange="return getStates(this.value);" name="country" id="country">
												<option value=''>All</option>
												<?php
												foreach($countries as $country){
													$countryselected = ($country['country_code'] == $_REQUEST['country']) ? 'selected="selected" ' : "";
													echo "<option ".$countryselected."value='".$country['country_code']."'>".$country['country']."</option>";
												}
												?>
											</select>
										</div>
										<div class="form-inline"> 
											<label class="control-label">State</label> &nbsp; 
											<select class="form-control underlined" onchange="return getCities(this.value);" name="state" id="state"><option value=''>All</option>
												<?php
												if($_REQUEST['country'] != ""){ 
													$states = getStates($_REQUEST['country']);
													foreach($states as $state){
														$stateselected = ($state['state'] == $_REQUEST['state']) ? 'selected="selected" ' : "";
														echo "<option ".$stateselected."value='".$state['state']."'>".$state['state']."</option>";
													}
													echo $stateselected; 
												} 
												?>
											</select>
										</div>
										<div class="form-inline"> 
											<label class="control-label">City</label> &nbsp; 
											<select class="form-control underlined" name="city" id="city"><option value=''>All</option>
													<?php
													if($_REQUEST['state'] != ""){ 
														$cities = getCities($_REQUEST['state']);
														foreach($cities as $city){
															$cityselected = ($city['city'] == $_REQUEST['city']) ? 'selected="selected" ' : "";
															echo "<option ".$cityselected."value='".$city['city']."'>".$city['city']."</option>";
														}
														echo $cityselected; 
													} 
													?>
											</select>
										</div>
										
											
                                        <div class="form-inline"> <label class="control-label">Start Date</label> &nbsp;  <input required autocomplete="off" type="text" value="<?php echo $startdate; ?>" id='startdate' name='startdate' class="form-control underlined"> </div>
										
                                        <div class="form-inline"> <label class="control-label">End Date</label> &nbsp;  <input required autocomplete="off" type="text" value="<?php echo $enddate; ?>" id='enddate' name='enddate' class="form-control underlined"> </div>

                                        <div class="xoouserultra-field-value" style="padding-left: 10px;">
                                           	<input type="hidden" name='page' value="1" id="page">
											<input class="btn btn-primary" type="submit" name="filter" id="filter" value="Get Statistics" onclick="return checkDates()"><label style="margin: 20px 10px;color:red !important" id="dateErr"></label>
                                            
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
	<div id="content" role="main" style="min-height:500px;margin: 2% 5%;">
		<!-- h4 style="float:right;"><a alt="click to dashboard" href="customer-main.php">Dashborad</a></h4 -->	
		<div class="pmpro_box" id="pmpro_account-invoices">
			<h2 style="text-align:center"><span class="text-primary">
							<?php if($filter!=""){
					
									echo "Filters => ".$filter;
					
									}?>
					</span></h2>
			
			<?php if($startdate!="" && $enddate!=""){ ?>

			<h3><u>Statistics for page hits</u></h3><br>
			<div id="hitschart"></div>
			<br><br>
			<h3><u>Statistics for video played duration</u></h3><br>
			<div id="durationchart"></div>

			<?php }else{ echo "<div><center><h2>Please choose the date</h2></center></div>"; }  ?>
			
		</div>
	</div>
	<script>
	jQuery(function() {
		jQuery( "#startdate" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			dateFormat: 'yy-mm-dd',
			numberOfMonths: 1,
			maxDate: '0',
			onSelect: function (selected) {
			    var dt = new Date(selected);
			    dt.setDate(dt.getDate() + 1);
			    jQuery("#enddate").datepicker("option", "minDate", dt);
			},
			onClose: function( selectedDate ) {
				jQuery( "#enddate" ).datepicker( "option", "minDate", selectedDate );				
			
			}
		});
		jQuery( "#enddate" ).datepicker({
			defaultDate: "+1w",
			changeMonth: true,
			dateFormat: 'yy-mm-dd',
			numberOfMonths: 1,
			maxDate: '0',
			onClose: function( selectedDate ) {
				jQuery( "#startdate" ).datepicker( "option", "maxDate", selectedDate );				
			}
		});
		
	});

	function getStates(countrycode){

		jQuery('#city').html("<option value=''>All</option>");
		jQuery('#state').html("<option value=''>All</option>");

		if(countrycode!=""){
			jQuery.ajax({  
				type: "POST",
				url : "ajax-info.php",
				data: jQuery.param({ 'action': "getState", 'country_code' : countrycode}) ,
				cache: false,
				success: function(data)
				{
					jQuery('#state').append(data);						
				}
			});	
		}

		return false;
	
	}

	function getCities(state){

		jQuery('#city').html("<option value=''>All</option>");

		if(state!=""){
			jQuery.ajax({  
				type: "POST",
				url : "ajax-info.php",
				data: jQuery.param({ 'action': "getCity", 'state' : state}) ,
				cache: false,
				success: function(data)
				{
					jQuery('#city').append(data);	
				}
			});	
		}

		return false;
	
	}

	</script>

	<?php if($startdate!="" && $enddate!=""){ 
		
		if(count($hits) > 0){ 

			$hitsdata = "";
			foreach($hits as $hit){
				$hitsdata .= '{year:"'.$hit["year"].'",value:"'.$hit["count"].'"},';		
			}
			$hitsdata = substr($hitsdata,0,(strlen($hitsdata) - 1));

		?>
			<script>	
			new Morris.Line({
				element:'hitschart',
				data:[<?php echo $hitsdata; ?>],
				events: ['<?php echo $startdate ?>'],
    			eventStrokeWidth: 0,
   				resize: true,
				xkey:'year',
				ykeys:['value'],
				labels:['Hits'],
				xLabels: 'year'
			});
			</script>
		<?php
		} else { echo "<script>document.getElementById('hitschart').innerHTML = 'No analytics found';</script>"; } 

		if(count($durations) > 0){ 

			$durationsdata = "";
			foreach($durations as $duration){
				$playedduration = $duration['duration'] / 60;
				$playedduration=round($playedduration, 1, PHP_ROUND_HALF_DOWN); //added	

				$durationsdata .= '{year:"'.$duration["year"].'",value:"'.$playedduration.'"},';		
			}
			$durationsdata = substr($durationsdata,0,(strlen($durationsdata) - 1));

		?>
			<script>	
			new Morris.Line({
				element:'durationchart',
				data:[<?php echo $durationsdata; ?>],
				events: ['<?php echo $startdate ?>'],
    			eventStrokeWidth: 0,
   				resize: true,
				xkey:'year',
				ykeys:['value'],
				labels:['Duration(in minutes)'],
				xLabels: 'year'
			});
			</script>	
	<?php
		} else { echo "<script>document.getElementById('durationchart').innerHTML = 'No analytics found';</script>"; }  
	}
?>
</article>
<?php
	include("footer-broadcaster.php");

?>
