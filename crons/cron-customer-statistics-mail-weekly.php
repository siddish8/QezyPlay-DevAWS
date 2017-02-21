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
	
	$sql0 = "SELECT * FROM customer_info WHERE is_admin = 0";
	$stmt0 = $dbcon->prepare($sql0, array(PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL));
	$stmt0->execute();
	$customers = $stmt0->fetchAll(PDO::FETCH_ASSOC);		
	$stmt0 = null;
}catch (PDOException $e){
	print $e->getMessage();
}

if(count($customers) > 0){
	
	foreach($customers as $customer){		
		
		$channel_id = $customer['channel_id']; 	
		$smailid_to_send = $customer['email']; 	
		//$smailid_to_send = "pradeep.ganapathy@ideabytes.com";	
		$smailid_to_send1 = "siddish.gollapelli@ideabytes.com";	
		$smailid_to_send2 = "haritha.pippari@ideabytes.com";	
		$smailid_to_send3 = "sreevalli.mogdumpuram@ideabytes.com";

		$date2 = date('Y-m-d', strtotime("-1 days"));
		$date1 = date('Y-m-d', strtotime("$date2 -6 days"));
	
		$date_in_subject = date('Y-m-d', strtotime("-1 days"));
		$subject = "Qezyplay Analytics - ".$customer['customername']." | Weekly report | ".$date1." to ".$date2;

		$url = SITE_URL.'/crons/reports/reports_weekly.php?channel_id='.$channel_id;	
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_NOBODY, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$body = curl_exec($ch);	
	
		$mail = new PHPMailer(); // defaults to using php "mail()"
		$mail->SetFrom(ADMIN_EMAILx);
		//$mail->AddAddress($smailid_to_send);	
		$mail->AddAddress($smailid_to_send1);	
		//$mail->AddAddress($smailid_to_send2);	
		$mail->AddAddress($smailid_to_send3);	
		//$mail->AddAddress(ADMIN_EMAIL);	
		$mail->Subject    = $subject;
		$mail->AltBody    = "Please check"; // optional, comment out and test
		$mail->MsgHTML($body);
		$mail->Send();			
			
	}
}
?>
