<?php


error_reporting(0);
 
//$channel_id = @$_GET["channel_id"];
$channel_id = @$_GET["channel_id"];
$channel_name = @$_GET["channel_name"];

include("../cron-config.php");


$presentdate =  date('d-m-Y');

//For current month's previous month
$date1 = date('Y-m-d', strtotime('first day of last month'));
$date2 = date('Y-m-d', strtotime('last day of last month'));

//For current month's previous month's previous month
/*$date_in_subject = date('F Y', strtotime('first day of last month'));
$pre_mth = Date("F Y", strtotime($date_in_subject . " last month"));
$date1 = date('Y-m-d', strtotime($date_in_subject .'first day of last month'));
$date2 = date('Y-m-d', strtotime($date_in_subject .'last day of last month'));
*/

$today = date('d-m-Y', strtotime($date1))." to ".date('d-m-Y', strtotime($date2));
$date_for_web1 = strtotime($date1);
$date_for_web2 = strtotime($date2);



// graph lib start here
require_once ('../lib/jpgraph/src/jpgraph.php');
require_once ('../lib/jpgraph/src/jpgraph_radar.php');
require_once ('../lib/jpgraph/src/jpgraph_bar.php');

$friendlyIpsCond = $friendlyWebsites = "";

require_once ('../classes/LastMonthChannelReports.class.php');


$WkRpt = new LastMonthChannelReports();
$X=$WkRpt->lastMonthChannelByChannelHits();

$Y=$WkRpt->lastMonthChannelByChannelDuration();


$A=$WkRpt->lastMonthChannelHits();


if($stmt3->rowCount() > 0){
	

	$datay=array();
	$datax=array();
	$datax=$X[0];
	$datay=$X[1];
	
	// Size of graph
	$width=400;
	$height=500;

	// Set the basic parameters of the graph
	$graph = new Graph($width,$height,'auto');
	$graph->SetScale('textlin');

	// Rotate graph 90 degrees and set margin
	//$graph->Set270AndMargin(50,20,50,30);
	//$graph->SetMargin(50,20,50,30);
	//$graph->SetMargin(5,100,3,40);

	// Nice shadow
	$graph->SetShadow();

	// Setup title
	$graph->title->Set('QezyPlay Analytics | '.$channel_name.' '."\n".'Channels-Hits | '.$today.' | Timezone:UTC/GMT');
	$graph->title->SetFont(FF_FONT1,FS_BOLD,14);

	// Setup X-axis
	$graph->xaxis->SetTickLabels($datax);
	//$graph->xaxis->SetFont(FF_FONT1,FS_NORMAL,12);
	$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,8);
	$graph->xaxis->SetLabelAngle(45);

	// Some extra margin looks nicer
	$graph->xaxis->SetLabelMargin(0);

	// Label align for X-axis
	$graph->xaxis->SetLabelAlign('center','top');

	// Add some grace to y-axis so the bars doesn't go
	// all the way to the end of the plot area
	$graph->yaxis->scale->SetGrace(20);

	// We don't want to display Y-axis
	//$graph->yaxis->Hide();

	// Now create a bar pot
	$bplot = new BarPlot($datay);

	$bplot->SetFillColor("#B0C4DE");
	//  ALSO tried:
	//  $bplot->SetColor(array("red","green","blue","gray"));
	$bplot->SetShadow();

	//You can change the width of the bars if you like
	//$bplot->SetWidth(0.5);

	// We want to display the value of each bar at the top
	$bplot->value->Show();
	$bplot->value->SetFont(FF_FONT1,FS_BOLD,12);
	$bplot->value->SetAlign('left','center');
	$bplot->value->SetColor('black','darkred');
	$bplot->value->SetFormat('%.1f mkr');
	

	// Add the bar to the graph
	$graph->Add($bplot);
	$bplot->value->Show();

	// .. and stroke the graph
	//$graph->Stroke();

	// Create the basic radar graph
	
	// And output the graph
	$gdImgHandler = $graph->Stroke(_IMG_HANDLER);

	// Default is PNG so use ".png" as suffix
	$fileName3 = "imagefile13.png";
	$graph->img->Stream($fileName3);
	
}



if($stmt4->rowCount() > 0){
	
	
	$datay=array();
	$datax=array();
	$datax=$Y[0];
	$datay=$Y[1];
	
	//Graphs in Hours
	foreach($datay as $d){
		$d=round($d/60,2);
		$datayH[]=$d;
	}
	$datay=$datayH;//

	
	// Size of graph
	$width=400;
	$height=500;

	// Set the basic parameters of the graph
	$graph = new Graph($width,$height,'auto');
	$graph->SetScale('textlin');

	// Rotate graph 90 degrees and set margin
	//$graph->Set270AndMargin(50,20,50,30);
	//$graph->SetMargin(50,20,50,30);
	//$graph->SetMargin(5,100,3,40);
	// Nice shadow
	$graph->SetShadow();

	// Setup title
	$graph->title->Set('QezyPlay Analytics | '.$channel_name.' '."\n".'Channels-Durations | '.$today.' | Timezone:UTC/GMT');
	$graph->title->SetFont(FF_FONT1,FS_BOLD,14);

	// Setup X-axis
	$graph->xaxis->SetTickLabels($datax);
	$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,8);
	$graph->xaxis->SetLabelAngle(45);

	// Some extra margin looks nicer
	$graph->xaxis->SetLabelMargin(0);

	// Label align for X-axis
	$graph->xaxis->SetLabelAlign('center','top');

	// Add some grace to y-axis so the bars doesn't go
	// all the way to the end of the plot area
	$graph->yaxis->scale->SetGrace(20);

	// We don't want to display Y-axis
	//$graph->yaxis->Hide();

	// Now create a bar pot
	$bplot = new BarPlot($datay);

	$bplot->SetFillColor("#B0C4DE");
	//  ALSO tried:
	//  $bplot->SetColor(array("red","green","blue","gray"));
	$bplot->SetShadow();

	//You can change the width of the bars if you like
	//$bplot->SetWidth(0.5);

	// We want to display the value of each bar at the top
	$bplot->value->Show();
	$bplot->value->SetFont(FF_FONT1,FS_BOLD,12);
	$bplot->value->SetAlign('left','center');
	$bplot->value->SetColor('black','darkred');
	$bplot->value->SetFormat('%.2f mkr');

	// Add the bar to the graph
	$graph->Add($bplot);
	$bplot->value->Show();

	// .. and stroke the graph
	//$graph->Stroke();

	// Create the basic radar graph
	
	// And output the graph
	$gdImgHandler = $graph->Stroke(_IMG_HANDLER);


	// Default is PNG so use ".png" as suffix
	$fileName4 = "imagefile14.png";
	$graph->img->Stream($fileName4);
	
}
	
include "reports_lastmonth-channel.html";
?>
