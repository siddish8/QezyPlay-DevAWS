<?php

include('db-config.php');
include('function_common.php');


 

						//$admin_mail_id="siddish.gollapelli@ideabytes.com";
						$sitename = "QezyPlay";
						$siteurl=SITE_URL."/";
						$loginlink = SITE_URL."/login";	
						$reglink = SITE_URL."/register";	
						$sub_pagelink = SITE_URL."/subscription";						
						//$agentloginlink = SITE_URL."/qp/agent-login.php";
						
						
						$headers = "MIME-Version: 1.0" . "\r\n";
						$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

						
						$headers .= 'From: Admin-QezyPlay <admin@qezyplay.com>' . "\r\n";						
						
						//$subject = "Special Promo Code For You";
						//$subject = "Christmas Greetings";
						$subject = "QezyPlay is now on IOS - Enjoy it on your Iphone or Ipad - anywhere in the world where internet is available.";

						$regards = "<p>Regards, <br>QezyPlay Team</p>";
						$regardsSurvey = "<p>Thanking you in advance, <br>Qezy®Play Team</p><p>** To be eligible for the prizes, user must agree to have their name and picture published on our web and social media sites</p>";
						
					
						//holiday season 1st mail_all
						/* 
						<p> This holiday season, extend your access to Qezy®Play Bengali live TV for 2 weeks by using the promo code<br><center><b><i>KOHLI100</i></b></center></p>
						<p>You can use this  promo code in subscription page <a href='$sub_pagelink' target='_blank'>$sub_pagelink</a> if already registered.</p>
						<p>
						 You can share this promocode to your loved ones, so that they can use this promo code at the time of registration  <a href='$reglink' target='_blank'>$reglink</a>  and can get additional 2 weeks free trial.
						</p>
						<p>Enjoy QezyPlay on  your  PC , Android Tablet, Phone etc.. wherever there is internet</p>
					
				<p>QezyPlay updates:<br>
IOS and set Top box apps will be released shortly.<br>
Interested users can mail us (admin@qezyplay.com) for the beta version of IOS app </p><p>Channels Available:<br>
<div align='center' style='margin:0 auto'><img src='".SITE_URL."/wp-content/uploads/2016/11/channels.png' /></div></p><p> Please  visit QezyPlay  <a href='$siteurl' target='_blank'>$siteurl</a>  site for more exiting offers on Monthly, Half-yearly and Yearly plans</p>".$regards
						
						*/
						$bodyF = "
						<p><div align='center' style='margin:0 auto'><img src='".SITE_URL."/wp-content/uploads/2016/06/christmas3.jpg' /></div></p>
						<p>Thank you for registering  with  Qezyplay. Our Team is working hard to get you quality programming.</p>
						<p>Please use the  promo code to extend your free trial by 2 weeks. This promo code is valid till Dec 31st 2016. <br><center><b><i><span style='color:green;font-size:20px'>XMAS25</span></i></b></center></p>
						<p>Use this promo code in  the subscription page <a href='$sub_pagelink' target='_blank'>$sub_pagelink</a></p>
						<p>
						  <a href='$reglink' target='_blank'>You can share this promocode with your loved ones, so they too can enjoy Qezyplay</a>
						</p>
					
<p>We look forward to your subscription on Qezyplay</p>".$regards;


						$bodyG = "
						<p><div align='center' style='margin:0 auto'><img src='".SITE_URL."/wp-content/uploads/2016/06/christmas3.jpg' /></div></p>
						<p>Thank you for Subscribing to Qezyplay and being valuable part of our family</p>
						<p>In the Spirit of giving, please share the  promocode to friends and family. <br><center><b><i><span style='color:green;font-size:20px'>XMAS16</span></i></b></center></p>
</p>
						<p>The promocode is redeemable for 2 extra weeks of a free trial. Expires Dec 31st 2016.</p>
						<p><a href='$reglink' target='_blank'>Register Here</a></p>

						".$regards;

						$bodySurvey = "
						<p>New – Qezy®play is now available on IPad and Iphone. New release is also available for Android.<br>
						Register your app on Iphone, Ipad and Android by 27th of Jan 2017 and become eligible to win a 6 month free subscription.</p>
 
						<p>To enhance your enjoyment, please take a few minutes to answer this survey by Jan 31st 2017.<br>
						We will draw 5 names from those that respond to the survey and award them a free one month subscriptions.</p>
						<p>
						1)      Rate your experience with Qezy®Play<br>
						a.      Excellent<br>
						b.      Very Good<br>
						c.      Good<br>
						d.      Fair<br>
						e.      Bad<br>
						 		_____________________________________________________<br>
						<br>
						2)      How do you watch Qezy®Play (select all that apply)<br>
						a.      PC Browser – which Browser – Chrome, Firefox or Explorer<br>
						b.      Mac Safari Browser<br>
						c.      Android – which device tablet, phone<br>
						d.      Ios – Iphone, Ipad<br>
								 _____________________________________________________<br>
						<br>
						3)      Value for Money<br>
						a.      Excellent<br>
						b.      Very Good<br>
						c.      Good<br>
						d.      Fair<br>
						e.      Bad<br>
								 _____________________________________________________<br>
						<br>
						4)      Have you contacted our support – If yes, How do you rate us?<br>
						a.      Have not used<br>
						b.      Excellent<br>
						c.      Very Good<br>
						d.      Good<br>
						e.      Fair<br>
						f.       Bad<br>
								 _____________________________________________________<br>
						<br>
						5)      Do you have any suggestions for features and improvements<br>
						a.      _____________________________________________________<br>
								_____________________________________________________<br>
								_____________________________________________________
						</p>									
						
						".$regardsSurvey;

//echo $bodyG;

//echo $bodySurvey;

//$res=get_all("SELECT user_email,user_login,display_name from wp_users where ID in (1980,1933,1547,1475,1489,1505)");
$res=get_all("SELECT user_email,user_login,display_name from wp_users where ID not in (1980,1933,1547,1475,1489,1505)");




foreach($res as $r)
{


$em=$r['user_email'];

$un=$r['user_login'];
$un=ucfirst($un); //added
$dn=$r['display_name'];
$body0="<p>Dear $un,</p>";

//$body=$body0.$bodyF;
//$body=$body0.$bodyG;
$body=$body0.$bodySurvey;


echo $em."<br>".$un."<br>";
mail($em,$subject,print_r($body,true),$headers);
echo "Mail Sent to $em"."<br>";
}

echo $body;
$em="siddish.gollapelli@ideabytes.com";
$em1="sreevalli.mogdumpuram@ideabytes.com";
//$em2="george.kongalath@ideabytes.com";
//mail("siddish.gollapelli@ideabytes.com",$subject,print_r($body,true),$headers);
//mail($em1,$subject,print_r($body,true),$headers);
//mail("haritha.pippari@ideabytes.com",$subject,print_r($body,true),$headers);
//mail($em2,$subject,print_r($body,true),$headers);










?>
