<?php


if(defined('STDIN') ){
  //echo("Running from CLI");
}else{
  //echo("Not Running from CLI");
  //exit();
}

include("cron-config.php");

require_once('lib/PHPMailer/class.phpmailer.php');

try {
	
	$sql0 = "SELECT * FROM bouquets where status=1 and is_vod<>1";
	$stmt0 = $dbcon->prepare($sql0, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt0->execute();
	$boqs = $stmt0->fetchAll(PDO::FETCH_ASSOC);		
	$stmt0 = null;
}catch (PDOException $e){
	print $e->getMessage();
}

if(count($boqs) > 0){
	
	foreach($boqs as $boq){		
		
		$boq_id = $boq['id']; 
		$boq_name = $boq['name']; 	
		//$smailid_to_send = $customer['email']; 	
		$smailid_to_send = "george.kongalath@ideabytes.com";	
		$smailid_to_send1 = "kiran.kumar@ideabytes.com";	
		//$smailid_to_send2 = "haritha.pippari@ideabytes.com";	
		$smailid_to_send3 = "sreevalli.mogdumpuram@ideabytes.com";
		$smailid_to_send4 = "siddish.gollapelli@ideabytes.com";	
		$smailid_to_send5 = "srinivas.katta@ideabytes.com";	
		$smailid_to_send6 = "anna.anthony@ideabytes.com";
		//$smailid_to_send7 = "rangandg@gmail.com";
		$smailid_to_send8 = "mamun.a.bd@ideabytes.com";
		//$smailid_to_send9 = "sahebnag@gmail.com";
		$smailid_to_send10 = "mstml@ideabytes.com";

		//$date2 = date('Y-m-d', strtotime("-1 days"));
		//$date1 = date('Y-m-d', strtotime("$date2 -6 days"));

		//$datenow=new DateTime("now");
		//$datenow=$datenow->format("Y-m-d");

		/*$datenow = date("Y-m-d");
		$datewkbck=$date = date('Y-m-d', strtotime('-1 week +1 day')); 
		$datewkbckcal=$date = date('Y-m-d', strtotime('-1 week'));*/

		//$datenow = date("Y-m-d");
		$datenow="2017-02-11";
		$datewkbck=$date = date('Y-m-d', strtotime($datenow.'-1 week +1 day')); 
		$datewkbckcal=$date = date('Y-m-d', strtotime($datenow.'-1 week'));
	
		$date_in_subject = date('Y-m-d', strtotime("-1 days"));
		$subject = "Qezyplay Analytics | ".$boq_name." | Weekly Report | ".$datewkbckcal." to ".$datenow." | Timezone:UTC/GMT";

		//$url = SITE_URL.'/crons/reports/reports_lastweek.php?channel_id='.$channel_id;	
		$url = SITE_URL.'/crons/reports/reports_lastweek.php?boq_id='.$boq_id.'&boq_name='.$boq_name;	
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_NOBODY, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$body = curl_exec($ch);	

		if(curl_exec($ch) === false)
		{
   // echo 'Curl error: ' . curl_error($ch);
		}else{
			//echo "curl success";
			//echo $body;
		}
	
		$mail = new PHPMailer(); // defaults to using php "mail()"
		$mail->SetFrom(ADMIN_EMAILx,"QezyPlay Analytics");
		//$mail->AddAddress($smailid_to_send4);	
		/*$mail->AddAddress($smailid_to_send);	
		
		$mail->AddAddress($smailid_to_send5);	
		$mail->AddAddress($smailid_to_send6);	
		$mail->AddAddress($smailid_to_send1);	
		$mail->AddAddress($smailid_to_send3);
		//$mail->AddAddress($smailid_to_send7);
		$mail->AddAddress($smailid_to_send8);
		//$mail->AddAddress($smailid_to_send9);	
		$mail->AddAddress($smailid_to_send10);	
		//$mail->AddAddress(ADMIN_EMAIL);	*/
		//$mail->AddAddress($smailid_to_send3);
		$mail->AddAddress("siddishg@gmail.com");
		$mail->AddAddress("sharanya.dolly@rocketmail.com");
		$mail->AddAddress("rakesh.marka@ideabytes.com");
		$mail->Subject    = $subject;
		$mail->AltBody    = "Please check"; // optional, comment out and test
		$mail->MsgHTML($body);
		$mail->Send();

		//mail($smailid_to_send3,$subject,print_r($body,true),HEADERS);
		//mail("siddishg@gmail.com",$subject,print_r($body,true),HEADERS);
		//mail("sharanya.dolly@rocketmail.com",$subject,print_r($body,true),HEADERS);		
		//mail("rakesh.marka@idebaytes.com",$subject,print_r($body,true),HEADERS);			
			
	}
}
?>
