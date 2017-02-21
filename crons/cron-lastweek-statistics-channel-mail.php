<?php


if(defined('STDIN') ){
  //echo("Running from CLI");
}else{
  //echo("Not Running from CLI");
  //exit();
}

include("cron-config.php");

require_once('lib/PHPMailer/class.phpmailer.php');

//$channel_id = $_REQUEST['channel_id'];

//channels and ids: TaraTV-129, Channel10-132

try {
	
	//$sql0 = "SELECT * FROM channels where status=1 and id=".$channel_id."";
	
	$sql0 = "SELECT * FROM channels where status=1 and id in (129,132)";
	$stmt0 = $dbcon->prepare($sql0, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt0->execute();
	$chans = $stmt0->fetchAll(PDO::FETCH_ASSOC);		
	$stmt0 = null;
}catch (PDOException $e){
	print $e->getMessage();
}

if(count($chans) > 0){
	
	foreach($chans as $chan){	

			
		
		$channel_id = $chan['id']; 
		$channel_name = $chan['name']; 	

		$sql1 = "SELECT email FROM customer_info WHERE is_admin = 0 and channel_id=".$channel_id." ";
		$stmt1 = $dbcon->prepare($sql1, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
		$stmt1->execute();
		$smailid_to_send0 = $stmt1->fetchColumn();		
		$stmt1 = null;

		//echo "Mail sent to - ".$smailid_to_send0;

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


		$date2 = date('Y-m-d', strtotime("-1 days"));
		$date1 = date('Y-m-d', strtotime("$date2 -6 days"));

		$date_for_web = strtotime($date2);
		$date_in_subject = date('d-m-Y', strtotime($date1))." to ".date('d-m-Y', strtotime($date2));
	
		//$date_in_subject = date('Y-m-d', strtotime("-1 days"));

		$subject = "Qezyplay Analytics - ".$channel_name." | Weekly report | ".$date_in_subject." | Timezone:UTC/GMT";
		$url = SITE_URL.'/crons/reports/reports_lastweek-channel.php?channel_id='.$channel_id.'&channel_name='.$channel_name;	
	
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_NOBODY, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$body = curl_exec($ch);	
	
		$mail = new PHPMailer(); // defaults to using php "mail()"
		//$mail->SetFrom(ADMIN_EMAIL);
		$mail->SetFrom(ADMIN_EMAILx);
		$mail->AddAddress($smailid_to_send0);	//Customer
		//$mail->AddAddress($smailid_to_send4);	//siddish
		//$mail->AddAddress($smailid_to_send3);	//sreevalli
		/*
		$mail->AddAddress($smailid_to_send);	//george
		$mail->AddAddress($smailid_to_send5);	//katta
		$mail->AddAddress($smailid_to_send6);	//anna
		$mail->AddAddress($smailid_to_send1);	//kiran
		$mail->AddAddress($smailid_to_send3);	//sreevalli
		$mail->AddAddress($smailid_to_send8);   //mamun
		$mail->AddAddress($smailid_to_send10);	//MSTML
		*/	
		//$mail->AddAddress($smailid_to_send7);
		//$mail->AddAddress($smailid_to_send9);	
		//$mail->AddAddress(ADMIN_EMAIL);	
		$mail->Subject    = $subject;
		$mail->AltBody    = "Please check"; // optional, comment out and test
		$mail->MsgHTML($body);
		$mail->Send();			
			
	}
}
?>
