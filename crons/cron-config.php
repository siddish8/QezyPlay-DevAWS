<?php

include($_SERVER['DOCUMENT_ROOT'].'/main-config.php');


define("ADMIN_EMAILx", "admin@qezyplay.com");

//echo ADMIN_EMAILx;


function secondsToTime($seconds) {
	echo "Seconds".$seconds;
    $dtF = new DateTime('@0');
    $dtT = new DateTime('@'.$seconds);
	//var_dump($dtT);
	echo $x=$dtF->diff($dtT)->format('%a d %h h %i m %s s');
	
	
   // return $dtF->diff($dtT)->format('%a d %h h %i m %s s');
}

function minutesToTime($minutes) {
$day = floor ($minutes / 1440);
$hour = floor (($minutes - $day * 1440) / 60);
$min = floor($minutes - ($day * 1440) - ($hour * 60));
$sec = round(($minutes - ($day * 1440) - ($hour * 60)-$min)*60,2);
 
// output text as...
 if($day>0){
	 return "{$day}day(s) {$hour}hr {$min}min {$sec}sec";
 }
 elseif($hour>0){
	 return "{$hour}hr {$min}min {$sec}sec";
 }else{
	 return "{$min}min {$sec}sec";
 }

}

function minutesToHours($time, $format = '%02d hr %02d min') {
    if ($time < 1) {
        return;
    }
    $hours = floor($time / 60);
    $minutes = ($time % 60);
    return sprintf($format, $hours, $minutes);
}


